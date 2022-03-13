<?php

namespace nikitakilpa\SystemJob\Drivers\Mongodb\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Nette\Utils\Json;

/**
 * Class SystemJob
 * @package nikitakilpa\SystemJob\Models
 *
 * @property int $id
 * @property string $action
 * @property json $params
 * @property string $scheduled_at
 * @property string $created_at
 * @property string $executed_at
 * @property string $attempts
 * @property string $event_id
 * @property string $status
 * @property string $deleted_at
 * @property string $updated_at
 */
class SystemJob extends Model
{
    use SoftDeletes;

    protected $connection = 'mongodb';
    protected $collection = 'system_jobs';

    protected $fillable = [
        'action',
        'params',
        'scheduled_at',
        'status'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->created_at = date_create();
        $this->attempts = 0;
    }
}
