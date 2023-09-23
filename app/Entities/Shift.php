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

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getWorkerId(): int
    {
        return $this->workerId;
    }

    public function setWorkerId(int $workerId): void
    {
        $this->workerId = $workerId;
    }

    public function getStart(): DateTimeImmutable
    {
        return $this->start;
    }

    public function setStart(DateTimeImmutable $start): void
    {
        $this->start = $start;
    }

    public function getEnd(): DateTimeImmutable
    {
        return $this->end;
    }

    public function setEnd(DateTimeImmutable $end): void
    {
        $this->end = $end;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'worker_id' => $this->workerId,
            'start' => $this->start->format('Y-m-d\TH:i'),
            'end' => $this->end->format('Y-m-d\TH:i')
        ];
    }
}