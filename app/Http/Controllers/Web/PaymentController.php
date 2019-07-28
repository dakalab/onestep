<?php

namespace App\Http\Controllers\Web;

use App\Models\Order;
use App\Models\PaypalSetting;
use Illuminate\Http\Request;
use PayPal\Api\Payment;

class PaymentController extends Controller
{
    public function handle(Request $request)
    {
        $this->getLogger()->debug($request->__toString());

        $order = Order::find($request->order_id);

        if (!$order) {
            return $this->error(__('order.invalid_order'));
        }

        // check whether this payment is valid
        try {
            $payment = Payment::get($request->payment_id, PaypalSetting::getApiContext());
            if (!$payment) {
                $this->getLogger()->error('payment does not exist in paypal: ' . $request->payment_id);
                return $this->error(__('order.invalid_payment'));
            }
            $this->getLogger()->debug($payment->toJSON());

            if ($payment->getState() != 'approved') {
                return $this->error(__('order.invalid_payment'));
            }
            $transactions = $payment->getTransactions();
            if (empty($transactions) || empty($transactions[0])) {
                return $this->error(__('order.invalid_payment'));
            }
            $transaction = $transactions[0];
            $amount = $transaction->getAmount();
            if (empty($amount)) {
                return $this->error(__('order.invalid_payment'));
            }
            if ($amount->getTotal() != $order->total) {
                return $this->error(__('order.invalid_payment'));
            }
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }

        // update the order info by the reponse data from paypal
        $payerInfo = $payment->getPayer()->getPayerInfo();
        if (empty($order->firstname)) {
            $order->firstname = $payerInfo->getFirstName();
        }
        if (empty($order->lastname)) {
            $order->lastname = $payerInfo->getLastName();
        }
        if (empty($order->email)) {
            $order->email = $payerInfo->getEmail();
        }
        if (empty($order->phone)) {
            $order->phone = $payerInfo->getPhone();
        }

        if (empty($order->address)) {
            $address = $payerInfo->getShippingAddress();
            $order->address = $address->getLine1() . ' ' . $address->getLine2();
            $order->city = $address->getCity();
            $order->province = $address->getState();
            $order->postcode = $address->getPostalCode();
            $order->country = $address->getCountryCode();
        }

        $order->order_no = $request->order_no;
        $order->confirmed_at = date('Y-m-d H:i:s');
        $order->pay([
            'transaction_no' => $request->payment_id,
            'token'          => $request->token,
            'payer_id'       => $request->payer_id,
        ]);

        return $this->success();
    }

    public function index($id)
    {
        try {
            $payment = Payment::get($id, PaypalSetting::getApiContext());
            $this->getLogger()->debug($payment->toJSON());
            return response()->json($payment->toArray());
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }
}
