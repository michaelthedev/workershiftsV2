<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\ShiftService;

final class ShiftController extends BaseController
{
    private ShiftService $shiftService;

    public function __construct(ShiftService $shiftService)
    {
        $this->shiftService = $shiftService;
    }

    public function index(): void
    {
        $this->successResponse(
            $this->shiftService->getAll()
        );
    }

    public function create(): void
    {
        validate([
            'worker_id' => 'required|numeric',
            'start' => 'required|date:Y-m-d\TH:i'
        ]);

        $shift = $this->shiftService->create(
            workerId: (int) $this->sanitizeInput(input('worker_id')),
            start: $this->sanitizeInput(input('start'))
        );
        $this->successResponse(
            $shift->toArray(),
            201, 'Shift created successfully'
        );
    }

    public function get(int $id): void
    {
        $this->successResponse(
            $this->shiftService->get($id)->toArray()
        );
    }

    public function update(int $id): void
    {
        validate([
            'worker_id' => 'required|numeric',
            'start' => 'required|date:Y-m-d\TH:i'
        ]);

        $shift = $this->shiftService->update(
            id: $id,
            workerId: (int) $this->sanitizeInput(input('worker_id')),
            start: $this->sanitizeInput(input('start'))
        );
        $this->successResponse(
            $shift->toArray(),
            200,
            'Shift updated successfully'
        );
    }

    public function delete(int $id): void
    {
        $this->shiftService->delete($id);
        $this->successResponse([],
            200,
            'Shift deleted successfully'
        );
    }
}