<?php

namespace App\Jobs;

use App\Libraries\Email\EmailLibrary;
use App\Libraries\User\UserLibrary;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UserRegisteredJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected User $user;

    /**
     * Create a new job instance.
     *
     * @param \App\Models\User$user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param UserLibrary $userLibrary
     * @return void
     * @throws \Exception
     */
    public function handle(UserLibrary $userLibrary): void
    {
        $userLibrary->userRegistered($this->user);
    }
}
