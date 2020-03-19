<?php

namespace App\Console\Commands;

use App\Events\UserNotifyEvent;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class NotifyUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test notify user';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $userTim = User::query()
            ->where('email', 'tim@haak.co')
            ->first();

        Auth::login($userTim);
        event(new UserNotifyEvent($userTim, $userTim));
    }
}
