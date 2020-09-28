<?php

namespace Modules\Indexing\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Indexing\Entities\Indexing;

class IndexingDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $indexing;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Indexing $indexing)
    {
        $this->indexing = $indexing;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
