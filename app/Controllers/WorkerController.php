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
        $this->successResponse(
            $this->workerService->getAll()
        );
    }

    public function get(int $id): void
    {
        $this->successResponse(
            $this->workerService->get($id)->toArray()
        );
    }

    public function create()
    {
        validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $worker = $this->workerService->create(
            name: $this->sanitizeInput(input('name')),
            email: $this->sanitizeInput(input('email')),
        );
        $this->successResponse($worker->toArray(), 201, 'Worker created successfully');
    }

    public function update(int $id)
    {
        validate([
            'name' => 'required'
        ]);

        $worker = $this->workerService->update(
            id: $id,
            name: $this->sanitizeInput(input('name'))
        );
        $this->successResponse($worker->toArray(), 200, 'Worker updated successfully');
    }

    }
}