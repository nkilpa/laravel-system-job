<?php

namespace nikitakilpa\SystemJob\Filters;

use DateTime;

class SystemJobFilter
{
    public mixed $status;
    public DateTime $from;
    public DateTime $to;

    public function __construct(
        $status = ['SCHEDULED', 'PUSHED', 'QUEUED', 'EXECUTED', 'FAILED', 'CANCELED'],
        $from = '0001-01-01 00:00:00',
        $to = '9999-12-31 23:59:59')
    {
        $this->status = $status;
        $this->from = date_create($from);
        $this->to = date_create($to);;
    }
}
