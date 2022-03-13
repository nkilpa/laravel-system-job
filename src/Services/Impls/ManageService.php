<?php

namespace nikitakilpa\SystemJob\Services\Impls;

use nikitakilpa\SystemJob\Helpers\SystemJobStatus;
use nikitakilpa\SystemJob\Services\Interfaces\ManageInterface;

class ManageService implements ManageInterface
{
    protected string $driver = '';

    public function __constructor(string $drive)
    {
        $this->driver = $drive;
    }

    public function changeStatus($jobId, string $status)
    {
        $model = config('schedule.drivers.'.$this->driver.'.model');
        $job = $model::find($jobId);
        $job->status = $status;
        $job->save();
    }

    public function incrementAttempt($jobId, int $count = 1)
    {
        $model = config('schedule.'.$this->driver.'.mysql.model');
        $job = $model::find($jobId);
        $job->attempts += $count;
        $job->save();
    }

    public function execute($jobId)
    {
        $model = config('schedule.'.$this->driver.'.mysql.model');
        $job = $model::find($jobId);
        $job->status = SystemJobStatus::EXECUTED;
        $job->executed_at = date_create();
        $job->save();
    }

    public function cancel($jobId)
    {
        $model = config('schedule.'.$this->driver.'.mysql.model');
        $job = $model::find($jobId);
        $job->status = SystemJobStatus::CANCELLED;
        $job->save();
    }
}