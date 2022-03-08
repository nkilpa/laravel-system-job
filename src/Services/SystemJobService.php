<?php

namespace nikitakilpa\SystemJob\Services;

use Illuminate\Support\Facades\App;
use nikitakilpa\SystemJob\Factories\SystemJobFactory;
use nikitakilpa\SystemJob\Filters\SystemJobFilter;
use nikitakilpa\SystemJob\Helpers\SystemJobStatus;
use nikitakilpa\SystemJob\Models\SystemJob;
use nikitakilpa\SystemJob\Repository\Interfaces\SystemJobRepositoryInterface;

class SystemJobService
{
    public function push()
    {
        $filter = new SystemJobFilter();
        $filter->status = ['SCHEDULED', 'PUSHED', 'QUEUED', 'EXECUTED', 'FAILED'];
        $filter->from = date_create('0000-00-00 00-00-00');
        $filter->to = date('Y-m-d H:i:s');

        $repository = App::make(SystemJobRepositoryInterface::class);
        $collection = $repository->findModelsByFilter($filter);

        foreach ($collection as $item)
        {
            $job = SystemJobFactory::CreateJob($item->action);
            if($job)
            {
                $job::dispatch($item->id)->onQueue('system_jobs')->afterCommit();

                $item->status = SystemJobStatus::PUSHED;
                $item->save();
            }
        }
    }

    public static function changeStatus(SystemJob $job, string $status): SystemJob
    {
        $job->status = $status;
        return $job;
    }

    public static function incrementAttempts(SystemJob $job, int $count = 1): SystemJob
    {
        $job->attempts += $count;
        return $job;
    }

    public static function setExecutedAt(SystemJob $job)
    {
        $job->executed_at = date("Y-m-d H:i:s");
        return $job;
    }
}
