<?php

namespace nikitakilpa\SystemJob\Repository\Impls;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use nikitakilpa\SystemJob\Drivers\Mongodb\Models\SystemJob;
use nikitakilpa\SystemJob\Filters\SystemJobFilter;
use nikitakilpa\SystemJob\Repository\Interfaces\SystemJobRepositoryInterface;

class SystemJobRepository implements SystemJobRepositoryInterface
{
    public function findModelsByFilter(string $database, SystemJobFilter $filter): Collection
    {
        $model = config('schedule.drivers.'.$database.'.model');
        return $model::
                whereIn('status', $filter->status)
                ->whereDate('scheduled_at', '<=', $filter->to)
                ->orderBy('id', 'desc')
                ->get();
    }

    public function findIds(string $database, SystemJobFilter $filter): Collection
    {
        $model = config('schedule.drivers.'.$database.'.model');
        return $model::pluck('id');
    }
}