<?php

namespace nikitakilpa\SystemJob\Services\Impls;

use nikitakilpa\SystemJob\Dto\SchedulerDto;
use nikitakilpa\SystemJob\Helpers\SystemJobStatus;
use nikitakilpa\SystemJob\Models\SystemJob;
use nikitakilpa\SystemJob\Services\Interfaces\CreateInterface;

class CreateService implements CreateInterface
{
    public function create(SchedulerDto $dto): bool
    {
        $systemJob = new SystemJob();
        $systemJob->action = $dto->action;
        $systemJob->scheduled_at = $dto->scheduled_at;
        $systemJob->params = json_encode($dto->params);
        $systemJob->status = SystemJobStatus::SCHEDULED;

        $systemJob->save();

        return true;
    }
}