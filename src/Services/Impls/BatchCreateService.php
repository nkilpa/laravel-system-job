<?php

namespace nikitakilpa\SystemJob\Services\Impls;

use nikitakilpa\SystemJob\Helpers\SystemJobStatus;
use nikitakilpa\SystemJob\Services\Interfaces\BatchCreateInterface;

class BatchCreateService implements BatchCreateInterface
{
    protected string $driver = '';

    public function __construct($driver)
    {
        $this->driver = $driver;
    }

    public function create(array $items): bool
    {
        $models = [];

        foreach ($items as $item)
        {
            $modelName = config('schedule.drivers.'.$this->driver.'.model');
            $model = new $modelName();
            $model->action = $item->action;
            $model->scheduled_at = $item->scheduled_at;
            $model->params = json_encode($item->params);
            $model->status = SystemJobStatus::SCHEDULED;
            $model->updated_at = date_create();
            $models[] = $model->getAttributes();
        }

        config('schedule.drivers.'.$this->driver.'.model')::insert($models);

        return true;
    }
}