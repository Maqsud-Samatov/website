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

    // Mijoz to'lovdan qaytganda
    public function return(Request $request)
    {
        $orderId = $request->get('merchant_trans_id');
        $error   = $request->get('error', 0);

        if ($error == 0) {
            return redirect()->route('payment.success', $orderId);
        }

        return redirect()->route('payment.failed', $orderId);
    }
}