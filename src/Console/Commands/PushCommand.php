<?php

namespace nikitakilpa\SystemJob\Console\Commands;

use Illuminate\Console\Command;
use nikitakilpa\SystemJob\Services\JobService;

class PushCommand extends Command
{
    protected $signature = 'job:push';

    protected $description = 'Push system job to queue \'system_jobs\'.';

    public function handle()
    {
        $service = new JobService();
        $service->push();
    }
}