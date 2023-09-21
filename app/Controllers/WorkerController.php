<?php

namespace App\Controllers;

use App\Models\Worker;
use App\Repositories\Interfaces\WorkerRepositoryInterface;
use App\Repositories\WorkerRepository;

final class WorkerController
{
    private WorkerRepositoryInterface $workerRepository;

    public function __construct()
    {
        $this->workerRepository = new WorkerRepository();
    }

    public function index(): void
    {
        response()->json([
            'error' => false,
            'message' => 'success',
            'data' => $this->workerRepository->getAll()
        ]);
    }

    public function create()
    {
        validate([
            'name' => 'required'
        ]);

        $name = input('name');
        $worker = new Worker();
        $worker->setName($name);

        response()->json([
            'error' => false,
            'message' => 'success',
            'data' => $worker
        ]);
    }
}