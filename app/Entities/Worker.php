<?php

declare(strict_types=1);

namespace App\Entities;

final class Worker
{
    private int $id;
    private string $name;
    private array $shifts = [];

    public function __construct(int $id = null, string $name = null, array $shifts = [])
    {
        $this->id = $id;
        $this->name = $name;
        $this->shifts = $shifts;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function addShift($shift): void
    {
        $this->shifts[] = $shift;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}