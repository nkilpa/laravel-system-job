<?php

namespace nikitakilpa\SystemJob\Helpers;

use Illuminate\Support\Facades\App;
use nikitakilpa\SystemJob\Components\Interfaces\ManagerInterface;
use nikitakilpa\SystemJob\Components\Interfaces\SchedulerInterface;

class SystemJobManager
{
    public function scheduler(string $driver = null)
    {
        if (is_null($driver))
        {
            $driver = config('schedule.default');
        }
        return App::makeWith(SchedulerInterface::class, ['driver' => $driver]);
    }

    public function manager(string $driver = '')
    {
        if (is_null($driver))
        {
            $driver = config('schedule.default');
        }
        return App::makeWith(ManagerInterface::class, ['driver' => $driver]);
    }
}