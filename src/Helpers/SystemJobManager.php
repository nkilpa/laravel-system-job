<?php

namespace nikitakilpa\SystemJob\Helpers;

use Illuminate\Support\Facades\App;

class SystemJobManager
{
    public function scheduler(string $db)
    {
        return App::make(config('schedule.services.'.$db));
    }
}