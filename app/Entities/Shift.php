<?php

declare(strict_types=1);

namespace App\Entities;

use DateTimeImmutable;

final class Shift
{
    private int $id;
    private int $workerId;
    private DateTimeImmutable $start;
    private DateTimeImmutable $end;

    public function getId(): int
    {
        return $this->id;
    }

    public function getWorkerId(): int
    {
        return $this->workerId;
    }

    public function getStart(): DateTimeImmutable
    {
        return $this->start;
    }

    public function getEnd(): DateTimeImmutable
    {
        return $this->end;
    }

}