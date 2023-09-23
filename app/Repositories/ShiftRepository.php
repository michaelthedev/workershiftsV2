<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Shift;

final class ShiftRepository extends BaseRepository
{
    public function get(int $id): ?object
    {
        $query = $this->runQuery(
            query: "SELECT * FROM shifts WHERE id = :id",
            params: [
                'id' => $id
            ]
        );

        $data = $query->fetchObject();
        if (!$data) {
            return null;
        }

        $shift = new Shift();
        $shift->setId((int) $data->id);
        $shift->setWorkerId($data->worker_id);

        $shift->setStart(\DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data->start));
        $shift->setEnd(\DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data->end));

        return $shift;
    }

    public function exists(int $id): bool
    {
        $query = $this->runQuery(
            query: "SELECT * FROM shifts WHERE id = :id",
            params: [
                'id' => $id
            ]
        );
        return $query->rowCount() > 0;
    }

    public function findByWorker(int $workerId): array
    {
        $query = $this->runQuery(
            query: "SELECT * FROM shifts WHERE worker_id = :worker_id",
            params: [
                'worker_id' => $workerId
            ]
        );

        return $query->fetchAll();
    }

    public function findByWorkerAndDate(int $workerId, string $date): object|bool
    {
        $query = $this->runQuery(
            query: "SELECT * FROM shifts WHERE worker_id = :worker_id AND DATE(start) = :date",
            params: [
                'worker_id' => $workerId,
                'date' => $date
            ]
        );
        return $query->fetchObject();
    }

    public function getAll(): array
    {
        $query = $this->runQuery(
            query: "SELECT * FROM shifts"
        );
        return $query->fetchAll();
    }

    public function create(Shift $shift): ?int
    {
        $query = $this->runQuery(
            query: "INSERT INTO shifts (worker_id, start, end) VALUES (:worker_id, :start, :end)",
            params: [
                'worker_id' => $shift->getWorkerId(),
                'start' => $shift->getStart()->format('Y-m-d H:i'),
                'end' => $shift->getStart()->modify('+8 hours')->format('Y-m-d H:i')
            ]
        );

        return ($query->rowCount() > 0)
            ? (int) $this->getDb()->lastInsertId()
            : null;
    }

    public function update(Shift $shift): bool
    {
        $query = $this->runQuery(
            query: "UPDATE shifts SET worker_id = :worker_id, start = :start, end = :end WHERE id = :id",
            params: [
                'id' => $shift->getId(),
                'worker_id' => $shift->getWorkerId(),
                'start' => $shift->getStart()->format('Y-m-d H:i'),
                'end' => $shift->getStart()->modify('+8 hours')->format('Y-m-d H:i')
            ]
        );

        return $query->rowCount() > 0;
    }

    public function delete(int $id): bool
    {
        $query = $this->runQuery(
            query: "DELETE FROM shifts WHERE id = :id",
            params: [
                'id' => $id
            ]
        );

        return $query->rowCount() > 0;
    }
}