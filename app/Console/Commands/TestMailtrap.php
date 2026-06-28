<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestMailtrap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:mailtrap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Quick check that the mailer mailtrap is defined and usable.';

    public function handle(): int
    {
        $mailer = config('mail.mailers.mailtrap');

        if (!is_array($mailer) || empty($mailer['transport'])) {
            $this->error('mail.mailers.mailtrap is not configured properly');
            return Command::FAILURE;
        }

        // Don’t actually send mail here—only ensure mailer can be resolved.
        Mail::mailer('mailtrap');

        $this->info('mailtrap mailer is defined and resolvable.');
        return Command::SUCCESS;
    }
}

