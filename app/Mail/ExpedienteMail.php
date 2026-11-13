<?php

namespace App\Mail;

use App\Models\Estudiante;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExpedienteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $estudiante;
    public $attachmentBinary;
    public $filename;
    public $mime;

    public function __construct(Estudiante $estudiante, $attachmentBinary = null, $filename = null, $mime = null)
    {
        $this->estudiante = $estudiante;
        $this->attachmentBinary = $attachmentBinary;
        $this->filename = $filename ?? 'Expediente.pdf';
        $this->mime = $mime ?? 'application/pdf';
    }

    public function build()
    {
        $mail = $this->subject('Expediente Académico Oficial - ' . ($this->estudiante->user->name ?? 'Estudiante'))
            ->view('email.expediente');

        if ($this->attachmentBinary) {
            $mail->attachData($this->attachmentBinary, $this->filename, [
                'mime' => $this->mime,
            ]);
        }

        return $mail;
    }
}
