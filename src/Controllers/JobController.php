<?php

namespace nikitakilpa\SystemJob\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use nikitakilpa\Core\Controllers\BaseController;
use nikitakilpa\SystemJob\Forms\CreateForm;
use nikitakilpa\SystemJob\Repository\Interfaces\SystemJobRepositoryInterface;
use nikitakilpa\SystemJob\Filters\JobFilter;
use nikitakilpa\SystemJob\Services\JobService;

class JobController extends BaseController
{
    public function hello(): JsonResponse
    {
        return response()->json([
            'message' => 'hello',
        ]);
    }

    public function getModelsByFilter(Request $request): JsonResponse
    {
        $filter = $this->setupFilter($request);

        $repository = App::make(SystemJobRepositoryInterface::class);
        $items = $repository->findModelsByFilter($filter);

        return response()->json([
            'status' => 'ok',
            'data' => $items
        ]);
    }

    public function getIds(Request $request): JsonResponse
    {
        $filter = $this->setupFilter($request);

        $repository = App::make(SystemJobRepositoryInterface::class);
        $items = $repository->findIds($filter);

        return response()->json([
            'status' => 'ok',
            'data' => $items
        ]);
    }

    public function createJob(Request $request): JsonResponse
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

    public function pushJobs(): JsonResponse
    {
        $service = new JobService();
        $service->push();

        return response()->json([
            'status' => 'ok'
        ]);
    }




    private function setupFilter(Request $request): JobFilter
    {
        $filter = new JobFilter();
        $fields = $request->all();

        if ($request->has('status') && $fields['status'] != '')
        {
            $filter->status = array($fields['status']);
        }
        else
        {
            $filter->status = ['SCHEDULED', 'PUSHED', 'QUEUED', 'EXECUTED', 'FAILED', 'CANCELED'];
        }

        if ($request->has('from') && $fields['from'] != '')
        {
            $filter->from = date_create($request->input('from'));
        }
        else
        {
            $filter->from = date_create('0000-00-00 00-00-00');
        }

        if ($request->has('to') && $request->input('from') != '')
        {
            $filter->to = date_create($request->input('to'));
        }
        else
        {
            $filter->to = date_create('9999-12-31 23:59:59');
        }

        return $filter;
    }
}
