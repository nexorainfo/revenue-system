<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActivityLogEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ?string $model;

    public ?int $model_id;

    public string $activity_type;

    public function __construct(string $activity_type, ?string $model = null, ?int $model_id = null)
    {
        $this->model = $model;
        $this->model_id = $model_id;
        $this->activity_type = $activity_type;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    final public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
