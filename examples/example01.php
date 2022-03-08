<?php

use Illuminate\Support\Str;

$dto = new \nikitakilpa\SystemJob\Dto\SchedulerDto();
$dto->action = 'TEXT_RANDOM';
$dto->scheduled_at = '2022-03-09 09:00:00';
$dto->params = ['text' => Str::random(10)];

\nikitakilpa\SystemJob\Facades\SystemJobFacade::scheduler('mysql')->scheduled($dto);
