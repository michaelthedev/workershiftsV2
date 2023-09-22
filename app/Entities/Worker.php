<?php

declare(strict_types=1);

namespace App\Entities;

final class Worker
{
    private int $id;
    private string $name;
    private string $email;
    private array $shifts = [];

    public function __construct()
    {}

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
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