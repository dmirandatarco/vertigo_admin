<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistroMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $request;
    public $nombre;

    public function __construct($request,$nombre)
    {
        $this->request=$request;
        $this->nombre=$nombre;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function build()
    {
        $archivoPath = storage_path("app/public/img/agencias/" . $this->nombre);

        return  $this->subject("Registro Vertigo Travel Perú")
        ->markdown('pages.mails.agencias',[
            'request' => $this->request
        ])
        ->attach($archivoPath, [
            'as' => $this->request->archivo,
            'mime' => mime_content_type($archivoPath),
        ]);
    }

}
