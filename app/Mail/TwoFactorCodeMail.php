<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TwoFactorCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre code de vérification',
        );
    }

    public function content(): Content
    {
        return new Content(
            html: 'emails.two-factor-code-premium',
            with: [
                'code' => $this->user->two_factor_code,
                'name' => $this->user->name,
                'otpCode' => $this->user->two_factor_code,
            ],
        );
    }
}
