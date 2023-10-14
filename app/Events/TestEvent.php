<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;

class TestEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $msg;

    /**
     * Create a new event instance.
     */
    public function __construct($msg)
    {
        //
        $this->msg = $msg;
    }

    /**
     * Get the channels the event should broadcast on.
     *
//     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel('test-channel');
//        return new PrivateChannel('chat-room');
    }

//    public function broadcastAs()
//    {
//        return 'TestEvent';
//    }

    public function broadcastWith()
    {
        return [
            'msg' => 'helo123',
        ];
    }
}
