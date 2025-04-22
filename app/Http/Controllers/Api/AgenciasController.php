<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\RegistroMailable;
use App\Models\AgenciaRegistro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AgenciasController extends Controller
{
    public function agencias(Request $request)
    {
        try{
            $agencia = new AgenciaRegistro();
            $agencia->nombre = $request->nombre;
            $agencia->celular = $request->celular;
            $agencia->documento = $request->documento;
            $agencia->numero = $request->numdocumento;
            $agencia->correo = $request->email;
            $agencia->aceptado = 0;
            if($request->hasFile('archivo'))
            {
                $nombreimg=$request->nombre.'.'.$request->file('archivo')->getClientOriginalExtension();
                $ruta=$request->archivo->storeAs('img/agencias',$nombreimg);
                $agencia->archivo = $nombreimg;
            }
            $agencia->save();
            Mail::to($request->email)->bcc('operaciones@vertigotravelperu.com')->send(new RegistroMailable($request,$nombreimg));
            return response()->json([
                'success' => true,
                'message' => 'Correo enviado correctamente.'
            ], 200);
        }catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Hubo un error al enviar el correo. Por favor, inténtelo de nuevo más tarde.'.$e->getMessage(),
            ], 500);
        }
        
    }
}
