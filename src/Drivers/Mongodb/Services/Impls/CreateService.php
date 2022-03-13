<?php

namespace nikitakilpa\SystemJob\Drivers\Mongodb\Services\Impls;

use nikitakilpa\SystemJob\Drivers\Mongodb\Models\SystemJob;
use nikitakilpa\SystemJob\Dto\SchedulerDto;
use nikitakilpa\SystemJob\Helpers\SystemJobStatus;
use nikitakilpa\SystemJob\Services\Interfaces\CreateInterface;

class CreateService implements CreateInterface
{
    public function create(SchedulerDto $dto): bool
    {
        $model = config('schedule.drivers.mongodb.model');

        $job = $model::create([
            'action' => $dto->action,
            'scheduled_at' => $dto->scheduled_at,
            'params' => json_encode($dto->params),
            'status' => SystemJobStatus::SCHEDULED,
        ]);

        if (!$job)
        {
            return false;
        }

        return true;
    }
}