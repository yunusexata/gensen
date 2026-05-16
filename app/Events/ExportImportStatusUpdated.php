<?php

namespace App\Events;

use App\Models\Gensen\GensenExportImportHistory;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ExportImportStatusUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;

    /**
     * Create a new event instance.
     */
    public function __construct(GensenExportImportHistory $history)
    {
        $this->data = [
            'id' => $history->id,
            'type' => $history->type,
            'created_by' => $history->created_by,
            'status' => $history->status->value,
            'file_path' => $history->file_path,
            'disk' => $history->disk,
            'file_name' => $history->file_name,
            'url' => $history->previewUrl(),
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        Log::info('Broadcast channel hit');
        return [
            // 'export-status'
            new Channel('export-import-status')

        ];
    }
    public function broadcastAs()
    {
        return 'export-import.status.updated';
    }
}
