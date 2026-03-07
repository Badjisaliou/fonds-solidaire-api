<?php

namespace App\Services;

use App\Models\Cotisation;
use Illuminate\Support\Facades\DB;

class DashboardService
{

    // Somme globale de toutes les cotisations
    public function totalGlobal()
    {
        return Cotisation::sum('montant');
    }

    // Cotisations par mois
    public function cotisationsParMois()
    {
        return Cotisation::select(
                DB::raw('MONTH(date_cotisation) as mois'),
                DB::raw('SUM(montant) as total')
            )
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();
    }
}