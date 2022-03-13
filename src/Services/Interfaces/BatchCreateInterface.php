<?php

namespace nikitakilpa\SystemJob\Services\Interfaces;

interface BatchCreateInterface
{
    public function create(array $items): bool;
}