<?php

namespace nikitakilpa\SystemJob\Repository\Interfaces;

use Illuminate\Support\Collection;
use nikitakilpa\SystemJob\Filters\SystemJobFilter;

interface SystemJobRepositoryInterface
{
    public function findModelsByFilter(string $driver, SystemJobFilter $filter): Collection;
    public function findIds(string $driver, SystemJobFilter $filter): Collection;
}