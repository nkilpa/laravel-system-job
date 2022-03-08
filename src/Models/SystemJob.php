<?php

namespace nikitakilpa\SystemJob\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->created_at = date_create();
        $this->attempts = 0;
    }
}
