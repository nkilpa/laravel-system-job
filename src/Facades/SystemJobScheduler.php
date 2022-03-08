<?php

namespace nikitakilpa\SystemJob\Facades;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Facade;
use nikitakilpa\SystemJob\Services\Impls\CreateJobService;

class SystemJobScheduler extends Facade
{
    protected static function getFacadeAccessor()
    {
        return CreateJobService::class;
    }
}