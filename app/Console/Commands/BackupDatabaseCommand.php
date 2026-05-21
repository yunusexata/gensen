<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

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

        $path = storage_path('app/backups/' . $filename);

        if (!is_dir(storage_path('app/backups'))) {
            mkdir(storage_path('app/backups'), 0775, true);
        }

        $command = sprintf(
            'PGPASSWORD="%s" pg_dump -U %s -h %s -p %s %s > %s',
            env('DB_PASSWORD'),
            env('DB_USERNAME'),
            env('DB_HOST'),
            env('DB_PORT'),
            env('DB_DATABASE'),
            $path
        );

        exec($command);

        $this->info('Backup completed: ' . $filename);
    }
}
