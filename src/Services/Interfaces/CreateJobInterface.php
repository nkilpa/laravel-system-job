<?php

namespace nikitakilpa\SystemJob\Services\Interfaces;

interface CreateJobInterface
{
    public function create(string $action, string $scheduled_at);
}