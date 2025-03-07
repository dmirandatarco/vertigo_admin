<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WhatsappRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if($this->tipoform=="crear"){
            $numero='required|numeric|digits:9|unique:whatsapps';
        }else{
            $numero='required|numeric|digits:9|unique:whatsapps,numero,'.$this->id_whatsapp;
        }
        return [
            'numero' => $numero,
            'cargo' => 'required|max:50',
            'nombre' => 'required|max:250',
        ];
    }
}
