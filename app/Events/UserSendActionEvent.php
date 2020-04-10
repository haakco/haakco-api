<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UserSendActionEvent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    private User $user;


    public string $actionType;
    /**
     * @var array|null
     */
    public ?array $actionPayload;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\User $user
     * @param string $actionType
     * @param array|null $actionPayload
     */
    public function __construct(User $user, string $actionType, ?array $actionPayload = null)
    {
        $this->user = $user;
        $this->actionType = $actionType;
        $this->actionPayload = $actionPayload;

        Log::info(
            'Sent action to: ' . $this->user->uuid,
            [
                'actionType' => $this->actionType,
                'actionPayload' => $this->actionPayload,
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
}
