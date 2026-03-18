<?php
namespace App\Services;

use App\Models\Order;
use Carbon\Carbon;

class PaymeService
{
    private ?string $merchantId;
    private ?string $secretKey;
    private bool    $testMode;

    const COMMISSION = 0.10; // 10%

    public function __construct()
    {
        $this->merchantId = env('PAYME_MERCHANT_ID', '');
        $this->secretKey  = env('PAYME_SECRET_KEY', 'test');
        $this->testMode   = (bool) env('PAYME_TEST_MODE', true);
    }

    // ── To'lov linki yaratish ──
    public function createPaymentUrl(int $orderId, float $amount): string
    {
        // Payme amount tiyin da (so'm * 100)
        $amountTiyin = (int)($amount * 100);
        $returnUrl   = route('payment.payme.return');

        $params = base64_encode(json_encode([
            'm'            => $this->merchantId,
            'ac.order_id'  => (string)$orderId,
            'a'            => $amountTiyin,
            'c'            => $returnUrl,
        ]));

        if ($this->testMode) {
            return "https://checkout.test.paycom.uz/{$params}";
        }

        return "https://checkout.paycom.uz/{$params}";
    }

    // ── Auth tekshirish ──
    private function checkAuth(?string $authHeader): bool
    {
        if ($this->testMode) return true; // Test rejimda auth tekshirmaymiz

        if (!$authHeader) return false;

        $encoded  = base64_encode("Paycom:{$this->secretKey}");
        $expected = "Basic {$encoded}";

        return $authHeader === $expected;
    }

    // ── Asosiy handler ──
    public function handle(?string $authHeader, array $data): array
    {
        if (!$this->checkAuth($authHeader)) {
            return $this->error(-32504, 'Insufficient privilege');
        }

        $method = $data['method'] ?? '';
        $params = $data['params'] ?? [];
        $id     = $data['id'] ?? null;

        $result = match($method) {
            'CheckPerformTransaction' => $this->checkPerformTransaction($params),
            'CreateTransaction'       => $this->createTransaction($params),
            'PerformTransaction'      => $this->performTransaction($params),
            'CancelTransaction'       => $this->cancelTransaction($params),
            'CheckTransaction'        => $this->checkTransaction($params),
            'GetStatement'            => $this->getStatement($params),
            default                   => $this->error(-32601, 'Method not found'),
        };

        // Agar result da error bo'lsa id qo'shamiz
        if (isset($result['error'])) {
            return array_merge($result, ['id' => $id]);
        }

        return array_merge($result, ['id' => $id]);
    }

    // ── CheckPerformTransaction ──
    private function checkPerformTransaction(array $params): array
    {
        $orderId = $params['account']['order_id'] ?? null;
        $amount  = $params['amount'] ?? 0;

        $order = Order::find($orderId);

        if (!$order) {
            return $this->error(-31050, 'Order not found');
        }

        $orderAmountTiyin = (int)($order->total * 100);

        if ($orderAmountTiyin !== (int)$amount) {
            return $this->error(-31001, 'Wrong amount');
        }

        if ($order->payment_status === 'paid') {
            return $this->error(-31099, 'Already paid');
        }

        return ['result' => ['allow' => true]];
    }

    // ── CreateTransaction ──
    private function createTransaction(array $params): array
    {
        $orderId    = $params['account']['order_id'] ?? null;
        $transId    = $params['id'];
        $amount     = $params['amount'];
        $createTime = $params['time'];

        $order = Order::find($orderId);

        if (!$order) {
            return $this->error(-31050, 'Order not found');
        }

        // Mavjud boshqa transaction tekshir
        if ($order->payme_transaction_id && $order->payme_transaction_id !== $transId) {
            return $this->error(-31099, 'Transaction already exists for this order');
        }

        $order->update(['payme_transaction_id' => $transId]);

        return [
            'result' => [
                'create_time' => $createTime,
                'transaction' => $transId,
                'state'       => 1,
            ]
        ];
    }

    // ── PerformTransaction ──
    private function performTransaction(array $params): array
    {
        $transId = $params['id'];
        $order   = Order::where('payme_transaction_id', $transId)->first();

        if (!$order) {
            return $this->error(-31003, 'Transaction not found');
        }

        // Allaqachon to'langan
        if ($order->payment_status === 'paid') {
            return [
                'result' => [
                    'transaction'  => $transId,
                    'perform_time' => $order->paid_at ? $order->paid_at->timestamp * 1000 : now()->timestamp * 1000,
                    'state'        => 2,
                ]
            ];
        }

        // Komissiya hisoblash
        $total            = $order->total;
        $commission       = round($total * self::COMMISSION);
        $restaurantAmount = $total - $commission;

        $performTime = now()->timestamp * 1000;

        $order->update([
            'payment_status'    => 'paid',
            'status'            => 'confirmed',
            'commission'        => $commission,
            'restaurant_amount' => $restaurantAmount,
            'paid_at'           => now(),
        ]);

        return [
            'result' => [
                'transaction'  => $transId,
                'perform_time' => $performTime,
                'state'        => 2,
            ]
        ];
    }

    // ── CancelTransaction ──
    private function cancelTransaction(array $params): array
    {
        $transId = $params['id'];
        $reason  = $params['reason'] ?? 0;

        $order = Order::where('payme_transaction_id', $transId)->first();

        if (!$order) {
            return $this->error(-31003, 'Transaction not found');
        }

        // Allaqachon yetkazilgan buyurtmani bekor qilib bo'lmaydi
        if ($order->status === 'delivered') {
            return $this->error(-31007, 'Could not cancel transaction');
        }

        $order->update([
            'status'         => 'cancelled',
            'payment_status' => 'unpaid',
        ]);

        return [
            'result' => [
                'transaction' => $transId,
                'cancel_time' => now()->timestamp * 1000,
                'state'       => -1,
            ]
        ];
    }

    // ── CheckTransaction ──
    private function checkTransaction(array $params): array
    {
        $transId = $params['id'];
        $order   = Order::where('payme_transaction_id', $transId)->first();

        if (!$order) {
            return $this->error(-31003, 'Transaction not found');
        }

        $state = match($order->payment_status) {
            'paid'   => 2,
            'unpaid' => 1,
            default  => -1,
        };

        return [
            'result' => [
                'create_time'  => $order->created_at->timestamp * 1000,
                'perform_time' => $order->paid_at ? $order->paid_at->timestamp * 1000 : 0,
                'cancel_time'  => 0,
                'transaction'  => $transId,
                'state'        => $state,
                'reason'       => null,
            ]
        ];
    }

    // ── GetStatement ──
    private function getStatement(array $params): array
    {
        $from = $params['from'];
        $to   = $params['to'];

        $orders = Order::where('payment_method', 'payme')
            ->where('payment_status', 'paid')
            ->whereBetween('paid_at', [
                Carbon::createFromTimestampMs($from),
                Carbon::createFromTimestampMs($to),
            ])
            ->get();

        $transactions = $orders->map(fn($order) => [
            'id'           => $order->payme_transaction_id,
            'time'         => $order->created_at->timestamp * 1000,
            'amount'       => (int)($order->total * 100),
            'account'      => ['order_id' => (string)$order->id],
            'create_time'  => $order->created_at->timestamp * 1000,
            'perform_time' => $order->paid_at ? $order->paid_at->timestamp * 1000 : 0,
            'cancel_time'  => 0,
            'transaction'  => $order->payme_transaction_id,
            'state'        => 2,
            'reason'       => null,
        ]);

        return ['result' => ['transactions' => $transactions->values()]];
    }

    // ── Error helper ──
    private function error(int $code, string $message): array
    {
        return [
            'error' => [
                'code'    => $code,
                'message' => [
                    'ru' => $message,
                    'uz' => $message,
                    'en' => $message,
                ],
                'data' => null,
            ]
        ];
    }
}