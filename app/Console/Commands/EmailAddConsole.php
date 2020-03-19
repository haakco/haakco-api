<?php

namespace App\Console\Commands;

use App\Libraries\Email\EmailLibrary;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class EmailAddConsole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:add {--email=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @param EmailLibrary $emailLibrary
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle(EmailLibrary $emailLibrary)
    {
        Log::info('Console start ' . $this->getName());
        $emailString = $this->option('email');
        if (empty($emailString)) {
            $emailLibrary->emailAddAllMissing();
        } else {
            $emailLibrary->emailAdd($emailString);
        }
    }
}
