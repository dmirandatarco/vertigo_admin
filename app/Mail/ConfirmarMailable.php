<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConfirmarMailable extends Mailable
{
    use Queueable, SerializesModels;


    public function __construct(public $agencia)
    {
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function build()
    {
        return  $this->subject("Confirmación Vertigo Travel Perú")
        ->markdown('pages.mails.agencias-confirmar',[
            'agencia' => $this->agencia
        ]);
    }
}
