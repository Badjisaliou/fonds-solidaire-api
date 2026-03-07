<?php

namespace App\Services;

use App\Models\Cotisation;

class CotisationService
{
    public function create(array $data, int $userId): Cotisation
    {
        return Cotisation::create([
            'user_id' => $userId,
            'montant' => $data['montant'],
            'description' => $data['description'] ?? null,
            'justificatif' => $data['justificatif'],
            'date_cotisation' => $data['date_cotisation'],
            'statut' => 'en_attente'
        ]);
    }

    public function calculateAnnualTotal(int $userId, int $year): array
    {
        $total = Cotisation::where('user_id', $userId)
            ->whereYear('date_cotisation', $year)
            ->where('statut', 'validee')
            ->sum('montant');

        return [
            'objectif_annuel' => 240000,
            'total_cotise' => $total,
            'reste_a_cotiser' => 240000 - $total
        ];
    }
}