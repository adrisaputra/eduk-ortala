<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Spatie\DbDumper\Databases\MySql;
use Carbon\Carbon;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create copy of mysql dump for existing database.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filename = "eduk-backup-" . Carbon::now()->format('Y-m-d') . ".sql";

        // Create backup folder and set permission if not exist.
        $storageAt = public_path('/db_backup/');
        if(!File::exists($storageAt)) {
            File::makeDirectory($storageAt, 0755, true, true);
        }

        $command = "".env('DB_MYSQLDUMP_PATH')." --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . " > " . $storageAt . $filename;

        $returnVar = NULL;
        $output = NULL;
        exec($command, $output, $returnVar);
    }
}
