<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ResultLiveScoreEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $changeStatus;

    /**
     * Create a new event instance.
     */
    public function __construct($changeStatus)
    {
        //
        $this->changeStatus = $changeStatus;
    }

    public function broadcastOn()
    {
        return new Channel('result-live-score');
    }

    public function broadcastWith()
    {
        return [
            'changeStatus' => $this->changeStatus,
        ];
    }
}
