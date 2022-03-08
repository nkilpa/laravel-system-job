<?php

namespace nikitakilpa\SystemJob\Forms;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use nikitakilpa\Core\Traits\MessageTrait;
use nikitakilpa\SystemJob\Dto\SchedulerDto;
use nikitakilpa\SystemJob\Facades\SystemJobFacade;

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

    public function create(Request $request): bool
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails())
        {
            $this->addErrors($validator->errors());
            return false;
        }

        $validatedData = $validator->validated();

        $dto = new SchedulerDto();
        $dto->action = $validatedData["action"];
        $dto->scheduled_at = $validatedData["scheduled_at"];

        SystemJobFacade::scheduler('mysql')->scheduled($dto);

        return true;
    }
}