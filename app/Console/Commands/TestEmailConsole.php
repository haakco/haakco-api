<?php

namespace App\Console\Commands;

use App\Libraries\Email\EmailTestingLibrary;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TestEmailConsole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {--email=} {--display-name=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the email delivery';

    /**
     * Execute the console command.
     *
     * @param EmailTestingLibrary $emailTestingLibrary
     * @return mixed
     */
    public function handle(EmailTestingLibrary $emailTestingLibrary)
    {
        Log::info('Console start ' . $this->getName());

        $email = $this->option('email');
        $displayName = $this->option('display-name');

        $emailTestingLibrary->sendEmailThroughQueue($email, $displayName);
        $emailTestingLibrary->sendEmail($email, $displayName);
        Log::info('Console end ' . $this->getName());
    }
}
