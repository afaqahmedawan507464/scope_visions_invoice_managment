public function backupDatabase()
{
    try {
        // Set the path for the backup file
        $backupPath = storage_path('backups') . '/backup-' . date('Y-m-d-H-i-s') . '.sql';

        // Ensure the backup directory exists
        if (!file_exists(dirname($backupPath))) {
            mkdir(dirname($backupPath), 0755, true);
        }

        // Command to run mysqldump
        $command = sprintf('mysqldump --user=%s --password=%s --host=%s %s > %s',
            env('DB_USERNAME'),
            env('DB_PASSWORD'),
            env('DB_HOST'),
            env('DB_DATABASE'),
            $backupPath
        );

        // Execute the command
        exec($command);

        // Check if the backup file was created successfully
        if (file_exists($backupPath)) {
            // Create a zip file of the backup
            $zip = new \ZipArchive();
            $zipFilePath = storage_path('backups') . '/backup-' . date('Y-m-d-H-i-s') . '.zip';
            if ($zip->open($zipFilePath, \ZipArchive::CREATE) === TRUE) {
                $zip->addFile($backupPath, basename($backupPath));
                $zip->close();

                // Download the zip file
                return response()->download($zipFilePath);
            } else {
                return response()->json(['message' => 'Failed to create zip file'], 500);
            }
        } else {
            return response()->json(['message' => 'Database backup failed'], 500);
        }
    } catch (\Exception $e) {
        return response()->json(['message' => 'Database backup failed: ' . $e->getMessage()], 500);
    }
}

