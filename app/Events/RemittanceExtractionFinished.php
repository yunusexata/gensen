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

class RemittanceExtractionFinished implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $gensen_form_id;
    /**
     * Create a new event instance.
     */
    public function __construct($gensen_form_id)
    {
        $this->gensen_form_id = $gensen_form_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        logger('Broadcast channel hit finish');
        return [
            // 'export-status'
            new Channel('export-remittance-extranction')
        ];
    }
    public function broadcastAs()
    {
        return 'export.remittance-extraction.finished';
    }
}
