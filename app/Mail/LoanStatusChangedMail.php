<?php

namespace App\Mail;

use App\Models\LoanApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LoanStatusChangedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public LoanApplication $loan,
        public string $status,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mise à jour de votre demande de crédit',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.loan-status-changed',
        );
    }
}
