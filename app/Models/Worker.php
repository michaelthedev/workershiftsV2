<?php

namespace App\Models;

class Worker
{
    public string $id;
    public string $name;
    public array $shifts;

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function addShift($shift)
    {
        $this->shifts[] = $shift;
    }
}