<?php

namespace nikitakilpa\SystemJob\Services\Interfaces;

interface ManageInterface
{
    public function changeStatus($jobId, string $status);

    public function incrementAttempt($jobId, int $count = 1);

    public function execute($jobId);

    public function cancel($jobId);
}