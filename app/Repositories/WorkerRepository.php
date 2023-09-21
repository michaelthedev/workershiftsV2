<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Worker;
use App\Repositories\DTO\WorkerDTO;
use App\Repositories\Interfaces\WorkerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class WorkerRepository implements WorkerRepositoryInterface
{
    public function findById(int $id)
    {
    }

    public function getAll()
    {

    }

    public function create(string $name)
    {

    }
}