<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

class ImportProduct implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // if (!$this->isQueueListenerRunning()) {
        //     $pid = $this->startQueueListener();
        //     $this->saveQueueListenerPID($pid);
        // }

        Artisan::call('queue:work');
    }

    private function isQueueListenerRunning()
    {
        if (!$pid = $this->getLastQueueListenerPID()) {
            return false;
        }

        $process = exec("ps -p $pid -opid=,cmd=");
        //$processIsQueueListener = str_contains($process, 'queue:listen'); // 5.1
        $processIsQueueListener = !empty($process); // 5.6 - see comments

        return $processIsQueueListener;
    }

    private function getLastQueueListenerPID()
    {
        if (!file_exists(__DIR__ . '/queue.pid')) {
            return false;
        }

        return file_get_contents(__DIR__ . '/queue.pid');
    }

    private function saveQueueListenerPID($pid)
    {
        file_put_contents(__DIR__ . '/queue.pid', $pid);
    }

    private function startQueueListener()
    {
        $command = 'php-cli ' . base_path() . '/artisan queue:work --timeout=60 --sleep=5 --tries=3 > /dev/null & echo $!'; // 5.6 - see comments
        $pid = exec($command);

        return $pid;
    }
}
