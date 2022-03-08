<?php

namespace nikitakilpa\SystemJob\Repository\Interfaces;

use Illuminate\Support\Collection;
use nikitakilpa\SystemJob\Filters\JobFilter;

interface SystemJobRepositoryInterface
{
    public function findModelsByFilter(JobFilter $filter): Collection;
    public function findIds(JobFilter $filter): Collection;
}