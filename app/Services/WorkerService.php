<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\Worker;
use App\Repositories\ShiftRepository;
use App\Repositories\WorkerRepository;
use Pecee\SimpleRouter\Exceptions\HttpException;

final class WorkerService
{
    private WorkerRepository $workerRepository;
    private ShiftRepository $shiftRepository;

    public function __construct(WorkerRepository $workerRepository, ShiftRepository $shiftRepository)
    {
        $this->workerRepository = $workerRepository;
        $this->shiftRepository = $shiftRepository;
    }

    public function getAll(): array
    {
        return $this->workerRepository->getAll();
    }

    public function get(int $id): Worker
    {
        $worker = $this->workerRepository->get($id);
        if (!$worker) {
            throw new HttpException('Worker not found', 404);
        }

        $worker->setShifts(
            $this->shiftRepository->findByWorker($worker->getId())
        );

        return $worker;
    }

    /**
     * @throws HttpException
     */
    public function create(string $name, string $email): ?Worker
    {
        // check if worker email already exists
        if ($this->workerRepository->emailExists($email)) {
            throw new HttpException('Worker already exists', 400);
        }

        $worker = new Worker();
        $worker->setName($name);
        $worker->setEmail($email);

        $workerId = $this->workerRepository->create($worker);
        if (!$workerId) {
            throw new HttpException('Failed to create worker', 500);
        }

        $worker->setId($workerId);
        return $worker;
    }

    public function update(int $id, string $name): ?Worker
    {
        $worker = $this->workerRepository->get($id);
        if (!$worker) {
            throw new HttpException('Worker not found', 404);
        }

        $worker->setName($name);
        if (!$this->workerRepository->update($worker)) {
            throw new HttpException('Failed to update worker', 500);
        }

        return $worker;
    }

    public function delete(int $id): void
    {
        if (!$this->workerRepository->exists($id)) {
            throw new HttpException('Worker not found', 404);
        }

        if (!$this->workerRepository->delete($id)) {
            throw new HttpException('Failed to delete worker', 500);
        }
    }
}