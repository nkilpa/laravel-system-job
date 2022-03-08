<?php

namespace nikitakilpa\SystemJob\Repository\Impls;

use Illuminate\Support\Collection;
use nikitakilpa\SystemJob\Filters\SystemJobFilter;
use nikitakilpa\SystemJob\Models\SystemJob;
use nikitakilpa\SystemJob\Repository\Interfaces\SystemJobRepositoryInterface;

class SystemJobRepository implements SystemJobRepositoryInterface
{
    public function findModelsByFilter(SystemJobFilter $filter): Collection
    {
        return SystemJob::WhereIn('status', $filter->status)
                ->whereBetween('scheduled_at', [$filter->from, $filter->to])
                ->orderBy('id', 'desc')
                ->get();
    }

    public function findIds(SystemJobFilter $filter): Collection
    {
        return SystemJob::pluck('id');
    }
}