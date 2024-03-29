<?php

namespace nikitakilpa\SystemJob\Components\Impls;

use Illuminate\Support\Facades\App;
use nikitakilpa\SystemJob\Components\Interfaces\SchedulerInterface;
use nikitakilpa\SystemJob\Dto\SchedulerDto;
use nikitakilpa\SystemJob\Services\Interfaces\BatchCreateInterface;

class SchedulerComponent implements SchedulerInterface
{
    private string $driver;

    public function __construct(string $driver)
    {
        $this->driver = $driver;
    }

    public function scheduled(SchedulerDto $dto): bool
    {
        $service = App::make(config('schedule.drivers.'.$this->driver.'.create_service'));
        return $service->create($dto);
    }

    public function scheduledBatch(array $items): bool
    {
        $service = App::makeWith(BatchCreateInterface::class, ['driver' => $this->driver]);
        return $service->create($items);
    }
}