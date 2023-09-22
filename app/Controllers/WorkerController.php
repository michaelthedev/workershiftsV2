<?php

namespace App\Controllers;

use App\Entities\Worker;
use App\Services\WorkerService;

final class WorkerController extends BaseController
{
    private WorkerService $workerService;

    public function __construct(WorkerService $service)
    {
        $this->workerService = $service;
    }

    public function index(): void
    {
        response()->json([
            'error' => false,
            'message' => 'success',
            'data' => $this->workerService->getAll()
        ]);
    }

    public function create()
    {
        validate([
            'name' => 'required'
        ]);

        $worker = $this->workerService->create(
            name: input('name')
        );

        var_dump($worker);
        if ($worker) {
            response()->json([
                'error' => false,
                'message' => 'success',
                'data' => $worker->toArray()
            ]);
        } else {
            response()->json([
                'error' => true,
                'message' => 'Failed to create worker',
                'data' => []
            ]);
        }
    }
}