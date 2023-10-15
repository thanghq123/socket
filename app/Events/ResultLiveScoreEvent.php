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

    public $examCode;

    /**
     * Create a new event instance.
     */
    public function __construct($examCode)
    {
        //
        $this->examCode = $examCode;
    }

    public function broadcastOn()
    {
        return new Channel('result-live-score.' . $this->examCode);
    }

    public function broadcastWith()
    {
        return [
            'examCode' => $this->examCode,
        ];
    }
}
