<?php

namespace nikitakilpa\SystemJob\Dto;

class SchedulerDto
{
    public string $action = '';
    public string $scheduled_at = '';
    public array $params = [];
}