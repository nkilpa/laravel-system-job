<?php

namespace nikitakilpa\SystemJob\Search;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use JetBrains\PhpStorm\Pure;
use nikitakilpa\SystemJob\Filters\SystemJobFilter;
use nikitakilpa\SystemJob\Repository\Interfaces\SystemJobRepositoryInterface;

class SystemJobSearch
{
    public function getModelsByFilter(array $fields): array
    {
        $filter = $this->setupFilter($fields);
        $repository = App::make(SystemJobRepositoryInterface::class);
        return $repository->findModelsByFilter($filter);
    }

    public function getIds(array $fields): array
    {
        $filter = $this->setupFilter($fields);
        $repository = App::make(SystemJobRepositoryInterface::class);
        return $repository->findIds($filter);
    }

    #[Pure] private function setupFilter(array $fields): SystemJobFilter
    {
        $filter = new SystemJobFilter();

        if (!is_null($fields['status']) && $fields['status'] != '')
        {
            $filter->status = array($fields['status']);
        }

        if (!is_null($fields['from']) && $fields['from'] != '')
        {
            $filter->from = date_create($fields['from']);
        }

        if (!is_null($fields['to']) && $fields['from'] != '')
        {
            $filter->to = date_create($fields['to']);
        }

        return $filter;
    }
}