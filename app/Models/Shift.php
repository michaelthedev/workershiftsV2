<?php

namespace App\Models;

use DateTimeImmutable;

class Shift
{
    public string $id;
    public string $workerId;
    public DateTimeImmutable $start;
    public DateTimeImmutable $end;


}