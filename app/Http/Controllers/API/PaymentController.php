<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Braintree\Gateway;

class PaymentController extends Controller
{
    protected $gateway;

    public function __construct(Gateway $gateway) {
        $this->gateway = $gateway;
    }

    public function token() {
        $clientToken = $this->gateway->clientToken()->generate(); // Funzione dell'sdk per generare un token

        return response()->json([
            'token' => $clientToken
        ]); // Return di un json con la chiave token e il token generato dall'sdk come valore
    }

    public function process(Request $request) {
        
        $amount = $request->input('amount'); // Importo della transazione
        $nonce = $request->input('payment_method_nonce'); // Il nonce è la chiave temporanea della transazione

        $result = $this->gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);


    }
}
