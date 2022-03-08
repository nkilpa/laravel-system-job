<?php

namespace nikitakilpa\SystemJob\Repository\Implements;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use nikitakilpa\SystemJob\Repository\Interfaces\SystemJobRepositoryInterface;
use nikitakilpa\SystemJob\Models\SystemJob;
use nikitakilpa\SystemJob\Filters\JobFilter;

class SystemJobRepository implements SystemJobRepositoryInterface
{
    public function findModelsByFilter(JobFilter $filter): Collection
    {
        return SystemJob::WhereIn('status', $filter->status)
                ->whereBetween('scheduled_at', [$filter->from, $filter->to])
                ->orderBy('id', 'desc')
                ->get();
    }

    public function findIds(JobFilter $filter): Collection
    {
        return SystemJob::pluck('id');
    }
}