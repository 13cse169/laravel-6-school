<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmpRegisteredEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $email;
    protected $body;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($email, $body)
    {
        $this->email = $email;
        $this->body  = $body;
    }
}
