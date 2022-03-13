<?php

namespace nikitakilpa\SystemJob\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class Job implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $jobId;
    protected string $driver;
    protected array $params;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($jobId, string $driver, array $params)
    {
        $this->jobId = $jobId;
        $this->driver = $driver;
        $this->params = $params;
    }
}