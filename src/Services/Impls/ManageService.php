<?php

namespace nikitakilpa\SystemJob\Services\Impls;

use nikitakilpa\SystemJob\Helpers\SystemJobStatus;
use nikitakilpa\SystemJob\Services\Interfaces\ManageInterface;

class ManageService implements ManageInterface
{
    protected string $driver = '';
    protected string $modelName = '';

    public function __construct(string $driver)
    {
        $this->driver = $driver;
        $this->modelName = config('schedule.drivers.'.$this->driver.'.model');
    }

    public function changeStatus($jobId, string $status)
    {
        $model = new $this->modelName();
        $job = $model::find($jobId);
        $job->status = $status;
        $job->save();
    }

    public function incrementAttempt($jobId, int $count = 1)
    {
        $model = new $this->modelName();
        $job = $model::find($jobId);
        $job->attempts += $count;
        $job->save();
    }

    public function execute($jobId)
    {
        $model = new $this->modelName();
        $job = $model::find($jobId);
        $job->status = SystemJobStatus::EXECUTED;
        $job->executed_at = date_create();
        $job->save();
    }

    public function cancel($jobId)
    {
        $model = new $this->modelName();
        $job = $model::find($jobId);
        $job->status = SystemJobStatus::CANCELLED;
        $job->save();
    }
}