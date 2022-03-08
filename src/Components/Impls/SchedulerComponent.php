<?php

namespace nikitakilpa\SystemJob\Components\Impls;

use Illuminate\Support\Facades\App;
use nikitakilpa\SystemJob\Components\Interfaces\SchedulerInterface;
use nikitakilpa\SystemJob\Dto\SchedulerDto;
use nikitakilpa\SystemJob\Services\Interfaces\BatchCreateInterface;
use nikitakilpa\SystemJob\Services\Interfaces\CreateInterface;

class SchedulerComponent implements SchedulerInterface
{
    public function scheduled(SchedulerDto $dto)
    {
        $service = App::make(CreateInterface::class);
        $service->create($dto);
    }

    public function scheduledBatch(array $items)
    {
        $service = App::make(BatchCreateInterface::class);
        $service->create($items);
    }

    public function cancel(int $id)
    {
        // TODO: Implement cancel() method.
    }
}