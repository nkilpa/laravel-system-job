<?php

namespace nikitakilpa\SystemJob\Services\Impls;

use Illuminate\Support\Facades\DB;
use nikitakilpa\SystemJob\Helpers\SystemJobStatus;
use nikitakilpa\SystemJob\Models\SystemJob;
use nikitakilpa\SystemJob\Services\Interfaces\BatchCreateInterface;

class BatchCreateService implements BatchCreateInterface
{
    public function create(array $items): bool
    {
        $models = [];

        foreach ($items as $item)
        {
            $model = new SystemJob();
            $model->action = $item->action;
            $model->scheduled_at = $item->scheduled_at;
            $model->params = json_encode($item->params);
            $model->status = SystemJobStatus::SCHEDULED;
            $models[] = $model->getAttributes();
        }

        Db::table('system_jobs')->insert($models);

        return true;
    }
}