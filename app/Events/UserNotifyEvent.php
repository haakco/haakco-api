<?php

namespace App\Events;

use App\Models\Enum\Alert\AlertTypesEnum;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UserNotifyEvent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    private User $user;
    public string $message;
    public string $alertType = AlertTypesEnum::ALERT_TYPE_INFO;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\User $user
     * @param string $message
     * @param string $alertType
     */
    public function __construct(User $user, string $message, string $alertType = AlertTypesEnum::ALERT_TYPE_INFO)
    {
        $this->user = $user;
        $this->message = $message;
        $this->alertType = $alertType;

        Log::info(
            'Sent message to: ' . $this->user->uuid,
            [
                $this->message,
            ]
        );
    }

    /**
     * Get the channels the event should broadcast on.
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->user->uuid);
    }

//    public function broadcastAs()
//    {
//        return 'UserNotifyEvent';
//    }
}
