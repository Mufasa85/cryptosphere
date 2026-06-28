<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Messages\MailMessage;

class TestSendMailtrap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:send-mailtrap {toEmail? : Destination email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a simple test email using the mailtrap mailer (no queue).';

    public function handle(): int
    {
        $to = $this->argument('toEmail') ?: env('MAIL_TEST_TO_EMAIL');

        if (empty($to)) {
            $this->error('Missing destination email. Pass it as argument or set MAIL_TEST_TO_EMAIL in .env.');
            return Command::FAILURE;
        }

        try {
            // Ensure we explicitly use mailtrap and send a raw text message.
            Mail::mailer('mailtrap')->raw(
                'Test email sent from Laravel using mailtrap mailer.',
                function ($message) use ($to) {
                    $message->to($to)
                        ->subject('Mailtrap test (Laravel)');
                }
            );

            $this->info("Test email dispatched to {$to} using mailtrap.");
            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $this->error('Mail sending failed: ' . $e->getMessage());
            $this->line($e->getTraceAsString());
            return Command::FAILURE;
        }
    }
}

