<?php

namespace nikitakilpa\SystemJob\Console\Commands;

use Illuminate\Console\Command;
use nikitakilpa\SystemJob\Services\SystemJobService;

class PushCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system-job:push {database?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Push jobs to queue';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $db = $this->hasArgument('database') ? $this->argument('database') : config('schedule.default');
        $service = new SystemJobService();
        $service->push($db);
        echo("Jobs pushed\n");
        return 0;
    }
}
