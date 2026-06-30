<?php

namespace App\Events;

use App\Models\Gensen\GensenExportImportHistory;
use App\Models\Gensen\GensenSeluruhBerkasZipJob;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SeluruhBerkasZipJobStatusUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;

    /**
     * Create a new event instance.
     */
    public function __construct(GensenSeluruhBerkasZipJob $zipJob)
    {
        $this->data = [
            'id' => $zipJob->id,
            'type' => GensenSeluruhBerkasZipJob::class,
            'status' => $zipJob->status->value,
            'created_by' => $zipJob->created_by,
            'zip_path' => $zipJob->zip_path,
            'zip_disk' => $zipJob->zip_disk,
            // 'file_path' => $history->file_path,
            // 'disk' => $history->disk,
            // 'file_name' => $history->file_name,
            // 'url' => $history->previewUrl(),
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        Log::info('Broadcast channel hit Zip Seluruh Berkas');
        return [
            // 'export-status'
            new Channel('zip-seluruh-berkas-status')

        ];
    }
    public function broadcastAs()
    {
        return 'zip-seluruh-berkas.status.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'data' => $this->data,
        ];
    }
}
