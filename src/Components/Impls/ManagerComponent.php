<?php

namespace nikitakilpa\SystemJob\Components\Impls;

use Illuminate\Support\Facades\App;
use nikitakilpa\SystemJob\Components\Interfaces\ManagerInterface;

class ManagerComponent implements ManagerInterface
{
    private string $driver;
    private mixed $manager;

    public function __construct(string $driver)
    {
        $this->driver = $driver;
        $this->manager = App::make(config('schedule.drivers.'.$this->driver.'.manage_service'), ['driver' => $this->driver]);
    }

    public function changeStatus($jobId, string $status)
    {
        $this->manager->changeStatus($jobId, $status);
    }

    public function incrementAttempt($jobId, int $count = 1)
    {
        $this->manager->incrementAttempt($jobId, $count);
    }


    public function executed($jobId)
    {
        $this->manager->execute($jobId);
    }

    public function canceled($jobId)
    {
        $this->manager->cancel($jobId);
    }
}