<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Worker;
use Pecee\SimpleRouter\Exceptions\HttpException;

class WorkerRepository extends BaseRepository
{
    public function get(int $id)
    {
        $query = $this->runQuery(
            query: "SELECT * FROM workers WHERE id = :id",
            params: [
                'id' => $id
            ]
        );

        $data = $query->fetchObject();
        if (!$data) return null;

        $worker = new Worker();
        $worker->setId((int) $data->id);
        $worker->setName($data->name);
        $worker->setEmail($data->email);
        return $worker;
    }

    public function exists(int $id): bool
    {
        $query = $this->runQuery(
            query: "SELECT * FROM workers WHERE id = :id",
            params: [
                'id' => $id
            ]
        );
        return $query->rowCount() > 0;
    }

    public function emailExists(string $email): bool
    {
        $query = $this->runQuery(
            query: "SELECT * FROM workers WHERE email = :email",
            params: [
                'email' => $email
            ]
        );
        return $query->rowCount() > 0;
    }

    public function getAll(): array
    {
        $query = $this->runQuery(
            query: "SELECT * FROM workers"
        );
        return $query->fetchAll();
    }

    public function create(Worker $worker): ?int
    {
        $query = $this->runQuery(
            query: "INSERT INTO workers (name, email) VALUES (:name, :email)",
            params: [
                'name' => $worker->getName(),
                'email' => $worker->getEmail()
            ]
        );

        return ($query->rowCount() > 0)
            ? (int) $this->getDb()->lastInsertId()
            : null;
    }

    public function update(Worker $worker): bool
    {
        $query = $this->runQuery(
            query: "UPDATE workers SET name = :name WHERE id = :id",
            params: [
                'id' => $worker->getId(),
                'name' => $worker->getName()
            ]
        );

        return $query->rowCount() > 0;
    }

    public function delete(int $id): bool
    {
        $query = $this->runQuery(
            query: "DELETE FROM workers WHERE id = :id",
            params: [
                'id' => $id
            ]
        );

        return $query->rowCount() > 0;
    }
}