<?php

namespace nikitakilpa\SystemJob\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use NeedleProject\LaravelRabbitMq\PublisherInterface;
use nikitakilpa\Core\Controllers\BaseController;
use nikitakilpa\SystemJob\Filters\SystemJobFilter;
use nikitakilpa\SystemJob\Forms\CreateForm;
use nikitakilpa\SystemJob\Drivers\Mongodb\Models\SystemJob;
use nikitakilpa\SystemJob\Services\SystemJobService;

class Controller extends BaseController
{
    public function hello(): JsonResponse
    {
        $publisher = app()->makeWith(PublisherInterface::class, ['aPublisherName']);
        $message = [
            'title' => 'Hello title',
            'body' => 'Hello, world!',
        ];
        $publisher->publish(json_encode($message));

        return response()->json([
            'message' => 'hello, system-job',
        ]);
    }

    public function create(Request $request): JsonResponse
    {
        $form = new CreateForm();
        $result = $form->create($request);

        if(!$result)
        {
            return response()->json([
                'status' => 'error',
                'data' => $form->getErrors()
            ]);
        }

        return response()->json([
            'status' => 'ok',
            'message' => 'Задача создана'
        ]);
    }

    public function pushJobs(Request $request): JsonResponse
    {
        $driver = config('schedule.default');
        if (!is_null($request->input('driver')))
        {
            $driver = $request->input('driver');
        }

        $service = new SystemJobService();
        $service->push($driver);

        return response()->json([
            'status' => 'ok'
        ]);
    }
}
