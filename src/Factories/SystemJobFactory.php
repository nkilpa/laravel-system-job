<?php

namespace nikitakilpa\SystemJob\Factories;

use Exception;
use Illuminate\Support\Facades\App;

class SystemJobFactory
{
    public static function CreateJob($action): mixed
    {
        try
        {
            return App::make($action);
        }
        catch (Exception $e)
        {
            return false;
        }
    }
}
