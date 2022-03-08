<?php

namespace nikitakilpa\SystemJob\Helpers;

class JobStatus
{
    const SCHEDULED = 'SCHEDULED';
    const PUSHED = "PUSHED";
    const QUEUED = "QUEUED";
    const FAILED = "FAILED";
    const EXECUTED = "EXECUTED";
    const CANCELED = 'CANCELED';
}
