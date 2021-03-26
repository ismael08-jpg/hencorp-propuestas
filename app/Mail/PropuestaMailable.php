<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use SplSubject;

class PropuestaMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Hencorp - Nueva propuesta';
    public $enc = '';
    public $pdf = '';
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($informacion, $pdf)
    {
        $this->enc = $informacion;
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(Auth::user()->email)->view('email.emailPropuesta')
                    ->attachData($this->pdf, 'Propuesta.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
