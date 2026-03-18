<?php
namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Services\ClickService;
use Illuminate\Http\Request;

class ClickController extends Controller
{
    private ClickService $click;

    public function __construct(ClickService $click)
    {
        $this->click = $click;
    }

    // Click prepare endpoint
    public function prepare(Request $request)
    {
        $result = $this->click->prepare($request->all());
        return response()->json($result);
    }

    // Click complete endpoint
    public function complete(Request $request)
    {
        $result = $this->click->complete($request->all());
        return response()->json($result);
    }

    public function return(Request $request)
    {
        // Click qaytganda barcha parametrlarni tekshiramiz
        $orderId = $request->get('merchant_trans_id') 
                ?? $request->get('transaction_param')
                ?? $request->get('merchant_prepare_id')
                ?? $request->get('order_id')
                ?? null;

        $error = $request->get('payment_status') 
            ?? $request->get('error', 0);

        // orderId yo'q — savatga qaytamiz
        if (!$orderId) {
            return redirect()->route('user.cart.index')
                ->with('info', 'To\'lov bekor qilindi');
        }

        if ($error == 0) {
            return redirect()->route('payment.success', ['orderId' => $orderId]);
        }

        return redirect()->route('payment.failed', ['orderId' => $orderId]);
    }
}