<?php

namespace App\Console\Commands;

use App\Events\UserAlertEvent;
use App\Events\UserSendActionEvent;
use App\Models\User;
use Illuminate\Console\Command;

class NotifyUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'notify:user';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Test notify user';

    /**
     * Execute the console command.
     * @return mixed
     */
    public function handle()
    {
        $adminUser = User::query()
            ->where('email', config('haakco.primary_user.email'))
            ->first();

        event(new UserAlertEvent($adminUser, 'Test message'));
        event(
            new UserSendActionEvent(
                $adminUser, '[Alert] Add Alert', [
                'alertType' => 'info',
                'message' => 'Test generic action',
            ]
            )
        );
    }
}
