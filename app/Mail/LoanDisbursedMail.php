<?php

namespace App\Mail;

use App\Models\LoanApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LoanDisbursedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public LoanApplication $loan) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre crédit a été décaissé',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.loan-disbursed',
        );
    }
}
