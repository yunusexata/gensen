<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

#[Signature('backup:database')]
#[Description('Backup PostgreSQL database')]
class BackupDatabaseCommand extends Command
{
    /**
     * Execute the console command.
     */

    // protected $signature = 'backup:database';

    // protected $description = 'Backup PostgreSQL database';

    public function handle()
    {

        $filename = 'backup_' . now()->format('Y_m_d_His') . '.sql';

        $tempDir = storage_path('app/temp_backups');

        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0775, true);
        }

        $localPath = $tempDir . DIRECTORY_SEPARATOR . $filename;

        $command = sprintf(
            'PGPASSWORD="%s" pg_dump -U %s -h %s -p %s %s > %s',
            env('DB_PASSWORD'),
            env('DB_USERNAME'),
            env('DB_HOST'),
            env('DB_PORT'),
            env('DB_DATABASE'),
            escapeshellarg($localPath)
        );

        exec($command, $output, $result);

        if ($result !== 0 || !file_exists($localPath)) {
            throw new Exception('Database backup failed.');
        }

        $disk = Storage::disk('supabase');

        $remotePath = 'database_backups/' . $filename;

        $stream = fopen($localPath, 'rb');

        $disk->writeStream($remotePath, $stream);

        fclose($stream);

        // Delete local temp file
        unlink($localPath);

        $this->info('Backup completed: ' . $filename);
    }
}
