<?php

namespace nikitakilpa\SystemJob\Factories;

use Exception;
use Illuminate\Support\Facades\App;

class JobFactory
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
