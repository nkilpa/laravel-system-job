<?php

namespace nikitakilpa\SystemJob\Facades;

use Illuminate\Support\Facades\Facade;
use nikitakilpa\SystemJob\Components\Interfaces\ManagerInterface;
use nikitakilpa\SystemJob\Components\Interfaces\SchedulerInterface;

/**
 * Class SystemJobFacade
 *
 * @method static SchedulerInterface scheduler(string $driver = null)
 * @method static ManagerInterface manager(string $driver = null)
 */
class SystemJobFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'system_job_scheduler';
    }
}