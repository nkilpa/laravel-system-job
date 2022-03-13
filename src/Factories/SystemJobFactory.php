<?php

namespace nikitakilpa\SystemJob\Factories;

use Exception;
use Illuminate\Support\Facades\App;

class SystemJobFactory
{
    public static function CreateJob($action, $jobId, $driver, $params): mixed
    {
        try
        {
            return App::makeWith($action, ['jobId' => $jobId, 'driver' => $driver, 'params' => $params]);
        }
        catch (Exception $e)
        {
            return false;
        }
    }
}
