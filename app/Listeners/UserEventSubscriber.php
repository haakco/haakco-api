<?php

namespace App\Listeners;

use App\Jobs\UserRegisteredJob;
use Illuminate\Auth\Events\Registered;
use Illuminate\Events\Dispatcher;

class UserEventSubscriber
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handleUserRegistered($event): void
    {
        UserRegisteredJob::dispatch($event->user);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param Dispatcher $events
     */
    public function subscribe($events): void
    {
        $events->listen(
            Registered::class,
            'App\Listeners\UserEventSubscriber@handleUserRegistered'
        );
    }
}
