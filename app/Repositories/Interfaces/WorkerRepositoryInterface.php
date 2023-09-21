<?php

namespace App\Repositories\Interfaces;

use App\Models\Worker;
use Illuminate\Database\Eloquent\Collection;

interface WorkerRepositoryInterface
{
    /**
     * Find a worker by id
     * @param int $id
     * @return Worker|null
     */
    public function findById(int $id);

    public function getAll();
}