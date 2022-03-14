<?php

namespace nikitakilpa\SystemJob\Services;

use Illuminate\Bus\Dispatcher;
use Illuminate\Support\Facades\App;
use nikitakilpa\Core\Traits\MessageTrait;
use nikitakilpa\SystemJob\Factories\SystemJobFactory;
use nikitakilpa\SystemJob\Filters\SystemJobFilter;
use nikitakilpa\SystemJob\Helpers\SystemJobStatus;
use nikitakilpa\SystemJob\Repository\Interfaces\SystemJobRepositoryInterface;

class SystemJobService
{
    public function push(string $driver = null): bool
    {
        if ($driver == null)
        {
            $driver = config('schedule.default');
        }

        $queue = config('schedule.drivers.'.$driver.'.queue');
        $broker = config('schedule.drivers.'.$driver.'.broker');

        $filter = new SystemJobFilter();
        $filter->status = ['SCHEDULED', 'PUSHED', 'QUEUED', 'EXECUTED', 'FAILED'];
        $filter->to = date_create();

        $repository = App::make(SystemJobRepositoryInterface::class);
        $collection = $repository->findModelsByFilter($driver, $filter);

        foreach ($collection as $item)
        {
            $job = SystemJobFactory::CreateJob($driver, $item->action, $item->id, json_decode($item->params, true));

            if($job)
            {
                $job->onConnection($broker)->onQueue($queue)->afterCommit();
                $item->event_id = app(Dispatcher::class)->dispatch($job);
                $item->status = SystemJobStatus::PUSHED;
                $item->save();
            }
        }

        return true;
    }
}
