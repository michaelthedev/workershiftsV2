<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\Shift;
use App\Repositories\ShiftRepository;
use App\Repositories\WorkerRepository;
use DateTimeImmutable;
use Pecee\SimpleRouter\Exceptions\HttpException;

final class ShiftService
{
    private ShiftRepository $shiftRepository;
    private WorkerRepository $workerRepository;

    public function __construct(ShiftRepository $shiftRepository, WorkerRepository $workerRepository)
    {
        $this->shiftRepository = $shiftRepository;
        $this->workerRepository = $workerRepository;
    }

    public function getAll(): array
    {
        return $this->shiftRepository->getAll();
    }

    public function get(int $id): Shift
    {
        $shift = $this->shiftRepository->get($id);
        if (!$shift) {
            throw new HttpException('Shift not found', 404);
        }

        return $shift;
    }

    /**
     * @throws HttpException
     */
    public function create(int $workerId, string $start): ?Shift
    {
        // check if worker exists
        if (!$this->workerRepository->exists($workerId)) {
            throw new HttpException('Worker not found', 404);
        }

        $start = DateTimeImmutable::createFromFormat('Y-m-d\TH:i', $start);

        if (!$this->isValidShift($start)) {
            throw new HttpException('Allowed shift ranges are 0-8, 8-16, 16-24');
        }

        if ($this->isShiftConflict($workerId, $start)) {
            throw new HttpException('Worker already has a shift on selected date');
        }

        $shift = new Shift();
        $shift->setWorkerId($workerId);
        $shift->setStart($start);

        $shiftId = $this->shiftRepository->create($shift);
        if (!$shiftId) {
            throw new HttpException('Failed to create shift', 500);
        }

        return $this->get($shiftId);
    }

    public function update(int $id, int $workerId, string $start): ?Shift
    {
        $shift = $this->shiftRepository->get($id);
        if (!$shift) {
            throw new HttpException('Shift not found', 404);
        }

        $start = DateTimeImmutable::createFromFormat('Y-m-d\TH:i', $start);

        if (!$this->isValidShift($start)) {
            throw new HttpException('Allowed shift ranges are 0-8, 8-16, 16-24');
        }

        if ($this->isShiftConflict($workerId, $start)) {
            throw new HttpException('Worker already has a shift on selected date');
        }

        $shift->setWorkerId($workerId);
        $shift->setStart($start);

        if (!$this->shiftRepository->update($shift)) {
            throw new HttpException('Failed to update shift', 500);
        }

        return $this->get($id);
    }

    private function isShiftConflict(int $workerId, DateTimeImmutable $start): bool
    {
        $date = $start->format('Y-m-d');
        return !empty(
            $this->shiftRepository
                ->findByWorkerAndDate($workerId, $date)
        );
    }

    private function isValidShift(DateTimeImmutable $start): bool
    {
        $hour = (int) $start->format('H');
        return in_array($hour, [0, 8, 16]);
    }

    public function delete(int $id): void
    {
        if (!$this->shiftRepository->exists($id)) {
            throw new HttpException('Worker not found', 404);
        }

        if (!$this->shiftRepository->delete($id)) {
            throw new HttpException('Failed to delete worker', 500);
        }
    }
}