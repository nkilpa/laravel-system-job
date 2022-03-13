<?php

namespace nikitakilpa\SystemJob\Components\Interfaces;

interface ManagerInterface
{
    public function changeStatus($jobId, string $status);

    public function incrementAttempt($jobId, int $count = 1);

    public function executed($jobId);

    public function canceled($jobId);
}