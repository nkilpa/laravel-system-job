<?php

namespace nikitakilpa\SystemJob\Forms;

use Illuminate\Support\Facades\Validator;
use nikitakilpa\SystemJob\Helpers\JobStatus;
use nikitakilpa\SystemJob\Models\SystemJob;
use nikitakilpa\Core\Traits\MessageTrait;

class CreateForm
{
    use MessageTrait;

    public function rules()
    {
        return [
            'action' => ['required', 'string'],
            'scheduled_at' => ['required', 'date']
        ];
    }

    public function create($request)
    {
        $validator = Validator::make($request->all(), $this->rules());

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