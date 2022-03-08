<?php

use Illuminate\Support\Str;

$dto1 = new \nikitakilpa\SystemJob\Dto\SchedulerDto();
$dto1->action = 'TEXT_RANDOM';
$dto1->scheduled_at = '2022-03-09 09:00:00';
$dto1->params = ['text' => Str::random(10)];

$dto2 = new \nikitakilpa\SystemJob\Dto\SchedulerDto();
$dto2->action = 'NUMBER_RANDOM';
$dto2->scheduled_at = '2022-03-09 09:00:00';
$dto2->params = ['number' => rand(0, 100)];

$items = [$dto1, $dto2];

\nikitakilpa\SystemJob\Facades\SystemJobFacade::scheduler('mysql')->scheduledBatch($items);
