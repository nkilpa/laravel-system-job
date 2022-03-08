<?php

namespace nikitakilpa\SystemJob\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SystemJobRequest extends FormRequest
{
    public function rules()
    {
        return [
            'action' => ['required', 'string'],
            'scheduled_at' => ['required', 'date']
        ];
    }
}