<?php

namespace nikitakilpa\SystemJob\Services\Impls;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use nikitakilpa\SystemJob\Helpers\JobStatus;
use nikitakilpa\SystemJob\Models\SystemJob;
use nikitakilpa\SystemJob\Services\Interfaces\CreateJobInterface;
use nikitakilpa\Core\Traits\MessageTrait;

class CreateJobService implements CreateJobInterface
{
    use MessageTrait;

    public function rules()
    {
        return [
            'action' => ['required', 'string'],
            'scheduled_at' => ['required', 'date']
        ];
    }

    public function create(string $action, string $scheduled_at = null)
    {
        $validator = Validator::make([$action, $scheduled_at], $this->rules());

        if ($validator->fails())
        {
            $this->addErrors($validator->errors());
            return false;
        }

        $validatedData = $validator->validated();

        $systemJob = new SystemJob();
        $systemJob->action = $validatedData["action"];
        $systemJob->scheduled_at = $validatedData["scheduled_at"];
        $systemJob->attempts = 0;
        $systemJob->status = JobStatus::SCHEDULED;

        $systemJob->save();

        return true;
    }
}