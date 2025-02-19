<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IziPayController extends Controller
{
    public function formToken(Request $request)
    {
        $llavepublica =  env('IZIPAY_USERNAME').':'. env('IZIPAY_API_PASSWORD');

        $authorizacion = base64_encode($llavepublica);
        $token = Http::withHeaders([
            'Authorization' => 'Basic ' . $authorizacion,
            'Accept' => 'application/json'
        ])
            ->post('https://api.micuentaweb.pe/api-payment/V4/Charge/CreatePayment', [
                'amount' => 100,
                'currency' => 'USD',
                'orderId' => 1,
                'customer' => [
                    'reference' => 124,
                    'email' => 'dmirandatarco@gmail.com',
                    'billingDetails' => [
                        'firstName' => 'DAVID MIRANDA',
                    ],
                ]
            ])->object();

        $formToken =  $token->answer->formToken;

        $data = [
            'formToken' => $formToken,
            'publicKey' => env('IZIPAY_PUBLIC_KEY'),
        ];

        return response()->json($data);
    }

    private function checkHash($request, $key)
    {
        $krAnswer = str_replace('\/', '/',  $request["kr-answer"]);
        
        $calculateHash = hash_hmac("sha256", $krAnswer, $key);

        return ($calculateHash == $request["kr-hash"]);
    }

    public function validateData(Request $request)
    {
        if (empty($request)) {
            throw new \Exception("No post data received!");
        }
          
        $validate = $this->checkHash($request->json()->all(), env("IZIPAY_SHA256_KEY"));
    
        return response()->json($validate, 200);
    }

    public function ipn(Request $request)
    { 
        if (empty($request)) {
            throw new \Exception("No post data received!");
        }
        
        // Validación de firma en IPN
        if (!$this->checkHash($request, env("IZIPAY_PASSWORD"))) {
            throw new \Exception("Invalid signature");
        }

        $answer = json_decode($request["kr-answer"], true);
        $transaction = $answer['transactions'][0];
        
        // Verifica orderStatus PAID
        $orderStatus = $answer['orderStatus'];
        $orderId = $answer['orderDetails']['orderId'];
        $transactionUuid = $transaction['uuid'];

        return 'OK! OrderStatus is ' . $orderStatus;
    }
}
