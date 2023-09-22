<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\Worker;
use App\Repositories\WorkerRepository;

final class WorkerService
{
    private WorkerRepository $workerRepository;
    private RedisService $redisService;

    public function __construct()
    {
        $this->redisService = new RedisService();
        $this->workerRepository = new WorkerRepository();
    }

    public function getAll(): array
    {
        if ($this->redisService->isEnabled) {
            return $this->getAllFromCacheOrDb();
        } else {
            return $this->workerRepository->getAll();
        }
    }

    private function getAllFromCacheOrDb(): array
    {
        if (!$this->redisService->has('workers::all')) {
            $workers = $this->workerRepository->getAll();
            $this->redisService->set('workers::all', json_encode($workers));
        }

        return json_decode($this->redisService->get('workers::all'));
    }

    public function create(string $name): ?Worker
    {
        $worker = new Worker();
        $worker->setName($name);

        $workerId = $this->workerRepository->create($worker);
        if ($workerId) {
            $worker->setId($workerId);
            return $worker;
        }
    }
}