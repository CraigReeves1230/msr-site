<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PrivateMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $author;
    public $recipient;
    public $message;
    public $image;
    public $created_at;
    public $link;

    public function __construct($author, $recipient, $message, $created_at, $link)
    {
        $this->message = str_limit($message, 40);
        $this->recipient = $recipient;
        $this->author = $author;
        $this->image = $author->images[0]->path;
        $this->created_at = $created_at;
        $this->link = $link;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('new-pm.' . $this->recipient->id);
    }
}
