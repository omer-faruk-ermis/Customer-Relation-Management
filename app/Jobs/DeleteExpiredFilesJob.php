<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DeleteExpiredFilesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $files = Storage::files('public/images');

        foreach ($files as $file) {
            $lastModified = Storage::lastModified($file);
            $expirationTime = Carbon::createFromTimestamp($lastModified)->addMinute();

            if ($expirationTime->isPast()) {
                Storage::delete($file);
                Log::info('Deleted expired file: ' . $file);
            }
        }
    }
}
