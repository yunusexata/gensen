<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ConvertPdfToIMageFinished implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $gensen_form_id;
    public $attachment_type;
    /**
     * Create a new event instance.
     */
    public function __construct($gensen_form_id, $attachment_type)
    {
        $this->gensen_form_id = $gensen_form_id;
        $this->attachment_type = $attachment_type;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        logger('Broadcast channel hit Convert to Image Finish');
        return [
            // 'export-status'
            new Channel('convert-attachment')
        ];
    }
    public function broadcastAs()
    {
        return 'export.convert-attachment.finished';
    }
}
