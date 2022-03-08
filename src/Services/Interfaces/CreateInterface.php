<?php

namespace nikitakilpa\SystemJob\Services\Interfaces;

use nikitakilpa\SystemJob\Dto\SchedulerDto;

interface CreateInterface
{
    public function create(SchedulerDto $dto);
}