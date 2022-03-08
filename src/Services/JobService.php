<?php

namespace nikitakilpa\SystemJob\Services;

use Illuminate\Support\Facades\App;
use nikitakilpa\SystemJob\Factories\JobFactory;
use nikitakilpa\SystemJob\Helpers\JobStatus;
use nikitakilpa\SystemJob\Models\SystemJob;
use nikitakilpa\SystemJob\Repository\Interfaces\SystemJobRepositoryInterface;
use nikitakilpa\SystemJob\Filters\JobFilter;

class JobService
{
    public function push()
    {
        $filter = new JobFilter();
        $filter->status = ['SCHEDULED', 'PUSHED', 'QUEUED', 'EXECUTED', 'FAILED'];
        $filter->from = date_create('0000-00-00 00-00-00');
        $filter->to = date('Y-m-d H:i:s');

        $repository = App::make(SystemJobRepositoryInterface::class);
        $collection = $repository->findModelsByFilter($filter);

        foreach ($collection as $item)
        {
            $job = JobFactory::CreateJob($item->action);
            if($job)
            {
                $job::dispatch($item->id)->onQueue('system_jobs')->afterCommit();

                $item->status = JobStatus::PUSHED;
                $item->save();
            }
        }
    }

    public function changeStatus(SystemJob $job, string $status)
    {
        $job->status = $status;
    }

    public function incrementAttempts(SystemJob $job)
    {
        $job->attempts++;
    }
}
