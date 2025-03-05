<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pasajero;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IziPayController extends Controller
{
    public function formToken(Request $request)
    {
        $llavepublica =  env('IZIPAY_USERNAME').':'. env('IZIPAY_API_PASSWORD');

        $mytime= Carbon::now('America/Lima');

        $cliente=Pasajero::updateOrCreate([
            'nombre' => $request->cliente['nombre'],
            'tipo_documento' => $request->cliente['tipo_documento'],
            'num_documento' => $request->cliente['num_documento'],
            'pais_id' => $request->cliente['pais_id'],
        ],[
            'email' => $request->cliente['email'],
            'celular' => $request->cliente['celular'],
            
        ]);

        $reserva = Reserva::create([
            'pasajero_id' => $cliente->id,
            'fecha' => $mytime->toDateTimeString(),
            'user_id' => 1,
            'confirmado' => 0,
            'observacion'=> null,
        ]);

        foreach($request->detalles as $detalle)
        {
            $reserva->detalles()->create([
                'tour_id' => $detalle['id'],
                'hotel_id' => 1,
                'moneda_id' => 2,
                'fecha_viaje' => $mytime->toDateString(),
                'cantidad' => $detalle['pax'],
                'ingreso' => 0,
                'precio' => $detalle['precio'],
                'observacion' => '',
            ]);
        }

        $reserva->totales()->create([
            'moneda_id' => 2,
            'acuenta' => 0,
            'saldo' => $request->total,
            'total' => $request->total,
        ]);

        $pago20 = $request->total*0.2;

        $authorizacion = base64_encode($llavepublica);
        $token = Http::withHeaders([
            'Authorization' => 'Basic ' . $authorizacion,
            'Accept' => 'application/json'
        ])
            ->post('https://api.micuentaweb.pe/api-payment/V4/Charge/CreatePayment', [
                'amount' => $pago20*100,
                'currency' => 'USD',
                'orderId' => $reserva->id,
                'customer' => [
                    'reference' => $cliente->id,
                    'email' => $cliente->email,
                    'billingDetails' => [
                        'firstName' => $cliente->nombre,
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
        if (!$this->checkHash($request, env("IZIPAY_API_PASSWORD"))) {
            throw new \Exception("Invalid signature");
        }

        $answer = json_decode($request["kr-answer"], true);
        $transaction = $answer['transactions'][0];
        
        // Verifica orderStatus PAID
        $orderStatus = $answer['orderStatus'];
        $orderId = $answer['orderDetails']['orderId'];
        $transactionUuid = $transaction['uuid'];

        $reserva = Reserva::find($answer['orderDetails']['orderId']);
        $reserva->confirmado = 1;
        $reserva->save();

        return 'OK! OrderStatus is ' . $orderStatus;
    }
}
