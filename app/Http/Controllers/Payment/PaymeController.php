<?php
namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Services\PaymeService;
use Illuminate\Http\Request;

class PaymeController extends Controller
{
    private PaymeService $payme;

    public function __construct(PaymeService $payme)
    {
        $this->payme = $payme;
    }

    // Payme webhook endpoint
    public function webhook(Request $request)
    {
        $authHeader = $request->header('Authorization', '');
        $data       = $request->all();

        $result = $this->payme->handle($authHeader, $data);

        return response()->json($result);
    }

    // Mijoz to'lovdan qaytganda
    public function return(Request $request)
    {
        $orderId = $request->get('order_id');
        return redirect()->route('payment.success', $orderId);
    }
}