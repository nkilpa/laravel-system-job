<?php

namespace nikitakilpa\SystemJob\Drivers\Mysql\Services\Impls;

use nikitakilpa\SystemJob\Drivers\Mysql\Models\SystemJob;
use nikitakilpa\SystemJob\Dto\SchedulerDto;
use nikitakilpa\SystemJob\Helpers\SystemJobStatus;
use nikitakilpa\SystemJob\Services\Interfaces\CreateInterface;

class CreateService implements CreateInterface
{
    public function create(SchedulerDto $dto): bool
    {
        $modelName = config('schedule.drivers.mysql.model');
        $model = new $modelName();
        $model->action = $dto->action;
        $model->scheduled_at = $dto->scheduled_at;
        $model->params = json_encode($dto->params);
        $model->status = SystemJobStatus::SCHEDULED;

        $model->save();

        return true;
    }
}