<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;

class DashboardController extends Controller
{

    private $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function global()
    {
        return response()->json([
            'total' => (int)$this->dashboardService->totalGlobal()
        ]);
    }

    public function mensuel()
    {
        return response()->json(
            $this->dashboardService->cotisationsParMois()
        );
    }
}