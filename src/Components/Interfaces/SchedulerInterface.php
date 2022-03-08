<?php

namespace nikitakilpa\SystemJob\Components\Interfaces;

use nikitakilpa\SystemJob\Dto\SchedulerDto;

interface SchedulerInterface
{
    public function scheduled(SchedulerDto $dto);
    public function scheduledBatch(array $items);
    public function cancel(int $id);
}