<?php
namespace App\Services;

class ClickService
{
    private ?string $merchantId;
    private ?string $serviceId;
    private ?string $merchantUserId;
    private ?string $secretKey;
    private bool    $testMode;
    private string  $endpoint;

    const COMMISSION = 0.10; // 10%

    public function __construct()
    {
        $this->merchantId     = env('CLICK_MERCHANT_ID', '1');
        $this->serviceId      = env('CLICK_SERVICE_ID', '1');
        $this->merchantUserId = env('CLICK_MERCHANT_USER_ID', '1');
        $this->secretKey      = env('CLICK_SECRET_KEY', 'test');
        $this->testMode       = (bool) env('CLICK_TEST_MODE', true);
        $this->endpoint       = 'https://api.click.uz/v2/merchant/';
    }

    // ── To'lov linki yaratish ──
    public function createPaymentUrl(int $orderId, float $amount): string
    {
        $returnUrl = urlencode(route('payment.click.return'));

        if ($this->testMode) {
            return "https://my.click.uz/services/pay?service_id=2&merchant_id=1&amount={$amount}&transaction_param={$orderId}&return_url={$returnUrl}";
        }

        return "https://my.click.uz/services/pay?service_id={$this->serviceId}&merchant_id={$this->merchantId}&amount={$amount}&transaction_param={$orderId}&return_url={$returnUrl}";
    }

    // ── Sign tekshirish ──
    private function checkSign(array $data, bool $isComplete = false): bool
    {
        if ($this->testMode) return true; // Test rejimda sign tekshirmaymiz

        if ($isComplete) {
            $sign = md5(
                $data['click_trans_id'] .
                $data['service_id'] .
                $this->secretKey .
                $data['merchant_trans_id'] .
                $data['merchant_prepare_id'] .
                $data['amount'] .
                $data['action'] .
                $data['sign_time']
            );
        } else {
            $sign = md5(
                $data['click_trans_id'] .
                $data['service_id'] .
                $this->secretKey .
                $data['merchant_trans_id'] .
                $data['amount'] .
                $data['action'] .
                $data['sign_time']
            );
        }

        return $sign === $data['sign_string'];
    }

    // ── Prepare ──
    public function prepare(array $data): array
    {
        if (!$this->checkSign($data)) {
            return $this->error(-1, 'SIGN CHECK FAILED!', $data);
        }

        $order = \App\Models\Order::find($data['merchant_trans_id']);

        if (!$order) {
            return $this->error(-5, 'Order not found', $data);
        }

        if (abs($order->total - $data['amount']) > 1) {
            return $this->error(-2, 'Incorrect parameter amount', $data);
        }

        if ($order->payment_status === 'paid') {
            return $this->error(-4, 'Already paid', $data);
        }

        return [
            'error'               => 0,
            'error_note'          => 'Success',
            'click_trans_id'      => $data['click_trans_id'],
            'merchant_trans_id'   => $data['merchant_trans_id'],
            'merchant_prepare_id' => $order->id,
        ];
    }

    // ── Complete ──
    public function complete(array $data): array
    {
        if (!$this->checkSign($data, true)) {
            return $this->error(-1, 'SIGN CHECK FAILED!', $data);
        }

        if ((int)$data['error'] < 0) {
            return $this->error($data['error'], 'Transaction cancelled', $data);
        }

        $order = \App\Models\Order::find($data['merchant_trans_id']);

        if (!$order) {
            return $this->error(-5, 'Order not found', $data);
        }

        if ($order->payment_status === 'paid') {
            return $this->error(-4, 'Already paid', $data);
        }

        // Komissiya hisoblash
        $total            = $order->total;
        $commission       = round($total * self::COMMISSION);
        $restaurantAmount = $total - $commission;

        $order->update([
            'payment_status'       => 'paid',
            'status'               => 'confirmed',
            'click_transaction_id' => $data['click_trans_id'],
            'commission'           => $commission,
            'restaurant_amount'    => $restaurantAmount,
            'paid_at'              => now(),
        ]);

        return [
            'error'             => 0,
            'error_note'        => 'Success',
            'click_trans_id'    => $data['click_trans_id'],
            'merchant_trans_id' => $data['merchant_trans_id'],
        ];
    }

    // ── Error helper ──
    private function error(int $code, string $note, array $data = []): array
    {
        return [
            'error'             => $code,
            'error_note'        => $note,
            'click_trans_id'    => $data['click_trans_id'] ?? null,
            'merchant_trans_id' => $data['merchant_trans_id'] ?? null,
        ];
    }
}