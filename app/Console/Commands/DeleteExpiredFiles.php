<?php

namespace App\Console\Commands;

use App\Jobs\DeleteExpiredFilesJob;
use Illuminate\Console\Command;

class DeleteExpiredFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'files:delete-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes expired files from the storage';

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
     * @return void
     */
    public function handle(): void
    {
        DeleteExpiredFilesJob::dispatch();
        $this->info('DeleteExpiredFilesJob dispatched successfully.');
    }
}
