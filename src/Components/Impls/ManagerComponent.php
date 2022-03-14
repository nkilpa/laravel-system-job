<?php

namespace nikitakilpa\SystemJob\Components\Impls;

use Illuminate\Support\Facades\App;
use nikitakilpa\SystemJob\Components\Interfaces\ManagerInterface;
use nikitakilpa\SystemJob\Services\Interfaces\ManageInterface;

class ManagerComponent implements ManagerInterface
{
    private string $driver;
    private mixed $manager;

    public function __construct(string $driver)
    {
        $this->driver = $driver;
        $this->manager = App::makeWith(ManageInterface::class, ['driver' => $this->driver]);
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