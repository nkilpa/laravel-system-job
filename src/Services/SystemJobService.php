<?php

namespace nikitakilpa\SystemJob\Services;

use Illuminate\Bus\Dispatcher;
use Illuminate\Support\Facades\App;
use nikitakilpa\SystemJob\Factories\SystemJobFactory;
use nikitakilpa\SystemJob\Filters\SystemJobFilter;
use nikitakilpa\SystemJob\Helpers\SystemJobStatus;
use nikitakilpa\SystemJob\Repository\Interfaces\SystemJobRepositoryInterface;

class SystemJobService
{
    public function push(string $driver = null)
    {
        if ($driver == null)
        {
            $driver = config('schedule.default');
        }

        $queue = config('schedule.drivers.'.$driver.'.queue');

        $filter = new SystemJobFilter();
        $filter->status = ['SCHEDULED', 'PUSHED', 'QUEUED', 'EXECUTED', 'FAILED'];
        $filter->from = date_create('0001-01-01 00:00:00');
        $filter->to = date_create();

        $repository = App::make(SystemJobRepositoryInterface::class);
        $collection = $repository->findModelsByFilter($driver, $filter);

        foreach ($collection as $item)
        {
            $job = SystemJobFactory::CreateJob($item->action, $item->id, $driver, json_decode($item->params, true));
            if($job)
            {
                $job->onConnection('rabbitmq')->onQueue($queue)->afterCommit();
                $item->event_id = app(Dispatcher::class)->dispatch($job);
                $item->status = SystemJobStatus::PUSHED;
                $item->save();
            }
        }
    }

    /*$result = $job::dispatch($item->id, $driver, json_decode($item->params, true))
                                    ->onConnection('rabbitmq')->onQueue($queue)->afterCommit();*/

    /*public function changeStatus(int $jobId, string $status): SystemJob
    {
        $jobId->status = $status;
        return $jobId;
    }

    public function incrementAttempt(SystemJob $job, int $count = 1): SystemJob
    {
        $job->attempts += $count;
        return $job;
    }

    public function executed(int $jobId)
    {
        $this->changeStatus($jobId, SystemJobStatus::EXECUTED);
        $job->executed_at = date("Y-m-d H:i:s");
        return $job;
    }

    public function failed(int $jobId)
    {
        $job = $this->changeStatus($jobId, SystemJobStatus::EXECUTED);
        return $job;
    }

    public function cancelled(int $jobId)
    {
        $job = $this->changeStatus($jobId, SystemJobStatus::CANCELLED);
        return $job;
    }*/
}
