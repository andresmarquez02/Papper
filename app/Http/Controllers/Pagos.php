<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use \PayPal\Auth\OAuthTokenCredential;
use \PayPal\Rest\ApiContext;
use \PayPal\Api\Amount;
use \PayPal\Api\Payer;
use \PayPal\Api\Transaction;
use \PayPal\Api\RedirectUrls;
use \PayPal\Api\Payment;
use \PayPal\Exception\PayPalConnectionException;
use  \PayPal\Api\PaymentExecution;
class Pagos extends Controller
{
    public $apiContext = null;
    public $totalFinal = null;
    public function __construct(){

        $paypalConfig = Config::get('paypal');
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $paypalConfig['client_id'],
                $paypalConfig['secret']
            )
        );
        $this->apiContext->setConfig(array(
            'mode' => 'live',
            'service.EndPoint' => 'https://api.paypal.com',
            'http.ConnectionTimeOut' => 90,
            'log.LogEnabled' => true,
            'log.FileName' => storage_path('logs/paypal.log'),
            'log.LogLevel' => 'FINE'
        ));
    }
    public function carrito(Request $request){
        session()->put('total_final', $request->total);
        return  $request->total;
    }
    public function pagar(){
        // dd($this->apiContext);
        // After Step 2
        $this->totalFinal = session()->get('total_final');
        if($this->totalFinal == 0 || $this->totalFinal == null){
            return redirect('expresso')->with('msg','No tiene ningun producto en su carrito');
        }
        $this->totalFinal = $this->totalFinal + $this->totalFinal;
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setTotal($this->totalFinal);
        $amount->setCurrency('USD');

        $transaction = new Transaction();
        $transaction->setAmount($amount);

        $callback = url('paypal/status');
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($callback)
        ->setCancelUrl($callback);

        $payment = new Payment();
        $payment->setIntent('sale')
        ->setPayer($payer)
        ->setTransactions(array($transaction))
        ->setRedirectUrls($redirectUrls);
        try {
            $payment->create($this->apiContext);
            //echo $payment;
            return redirect()->away($payment->getApprovalLink());
            // echo "\n\nRedirect user to approval_url: " . $payment->getApprovalLink() . "\n";
        }
        catch (PayPalConnectionException $ex) {
            // This will print the detailed information on the exception.
            //REALLY HELPFUL FOR DEBUGGING
            echo $ex->getData();
        }
    }
    public function status(Request $request){
        if(! $request->paymentId || ! $request->token || ! $request->PayerID){
            return redirect('expresso')->with('msg',"No se ha podido procesar el pago");
        }
        $payment = Payment::get($request->paymentId, $this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->PayerID);
        $result = $payment->execute($execution, $this->apiContext);
        if($result->getState() === "approved"){
            return redirect('expresso')->with('msg','Pago realizado exitosamente');
        }
        return redirect('expresso')->with('msg','Lo sentimos su pago no se pudo realizar');
    }
}
