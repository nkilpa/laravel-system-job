<?php

namespace nikitakilpa\SystemJob\Components\Interfaces;

use nikitakilpa\SystemJob\Dto\SchedulerDto;

interface SchedulerInterface
{
    public function scheduled(SchedulerDto $dto): bool;
    public function scheduledBatch(array $items): bool;
}