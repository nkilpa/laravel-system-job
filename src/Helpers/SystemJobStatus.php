<?php

namespace nikitakilpa\SystemJob\Helpers;

class SystemJobStatus
{
    const SCHEDULED = 'SCHEDULED';
    const PUSHED = "PUSHED";
    const QUEUED = "QUEUED";
    const FAILED = "FAILED";
    const EXECUTED = "EXECUTED";
    const CANCELLED = 'CANCELLED';
}
