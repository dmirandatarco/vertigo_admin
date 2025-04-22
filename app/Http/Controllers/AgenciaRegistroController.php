<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmarMailable;
use App\Models\AgenciaRegistro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AgenciaRegistroController extends Controller
{
    public function index(Request $request)
    {
        $agencias = AgenciaRegistro::all();
        $i = 0;
        return view('pages.agencia-registro.index',compact('agencias','i'));
    }

    public function aceptar($id)
    {
        $agencia = AgenciaRegistro::find($id);
        Mail::to($agencia->correo)->send(new ConfirmarMailable($agencia));
        $agencia->aceptado = 1;
        $agencia->save();
        return redirect()->back()->with('success','Correo Enviado.');
    }
}
