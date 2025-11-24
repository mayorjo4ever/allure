<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DatabaseBackup extends Command
{
    protected $signature = 'db:backup';
    protected $description = 'Backup the entire database into an SQL file';

    public function handle()
    {
        $db = env('DB_DATABASE');
        $user = env('DB_USERNAME');
        $pass = env('DB_PASSWORD');
        $host = env('DB_HOST');

        $backupDir = storage_path('app/backups');

        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0777, true);
        }

        $fileName = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        $filePath = $backupDir . '/' . $fileName;

        // Build the mysqldump command
       $mysqldump = '"C:\\xampp\\mysql\\bin\\mariadb-dump.exe"';

        $command = "{$mysqldump} --host={$host} -u {$user} {$db} > \"{$filePath}\"";
        exec($command, $output, $returnVar);

        //  -p{$pass}
        // Execute the command
        $returnVar = NULL;
        $output = NULL;
        exec($command, $output, $returnVar);

        if ($returnVar === 0) {
            $this->info("Database backup created successfully:");
            $this->info($filePath);
        } else {
            $this->error("Backup failed. Check mysqldump installation.");
        }
    }
}
