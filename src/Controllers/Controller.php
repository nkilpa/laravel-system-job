<?php

namespace nikitakilpa\SystemJob\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use nikitakilpa\Core\Controllers\BaseController;
use nikitakilpa\SystemJob\Filters\SystemJobFilter;
use nikitakilpa\SystemJob\Forms\CreateForm;
use nikitakilpa\SystemJob\Drivers\Mongodb\Models\SystemJob;
use nikitakilpa\SystemJob\Services\SystemJobService;

class Controller extends BaseController
{
    public function hello(): JsonResponse
    {
        return response()->json([
            'message' => 'hello',
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

    /*public function getModelsByFilter(Request $request): JsonResponse
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
    }*/

    public function pushJobs(): JsonResponse
    {
        $service = new SystemJobService();
        $service->push();

        return response()->json([
            'status' => 'ok'
        ]);
    }




    private function setupFilter(Request $request): SystemJobFilter
    {
        $filter = new SystemJobFilter();
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
