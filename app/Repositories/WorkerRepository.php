<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Worker;

class WorkerRepository extends BaseRepository
{
    public function get(int $id)
    {
        $query = $this->getDb()->prepare("SELECT * FROM workers WHERE id = :id");
        $query->execute([
            'id' => $id
        ]);

        $data = $query->fetchObject();
        if ($data) {
            $worker = new Worker(
                id: $data->id,
                name: $data->name
            );
        }
        return $worker ?? null;
    }

    public function getAll(): array
    {
        $query = $this->getDb()->prepare("SELECT * FROM workers");
        $query->execute();
        return $query->fetchAll();
    }

    public function create(string $name)
    {

    }
}