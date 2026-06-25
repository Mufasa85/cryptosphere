<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $verificationUrl;

    public function __construct(User $user, ?string $verificationUrl = null)
    {
        $this->user = $user;
        $this->verificationUrl = $verificationUrl ?? url('/email/verify?user=' . $user->id);
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Vérification de votre adresse email - MicroCredit',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.verify-email', //  Vérifier que cette vue existe
            with: [
                'userName' => $this->user->name,
                'verificationUrl' => $this->verificationUrl,
                'appName' => config('app.name'),
            ]
        );
    }
}
