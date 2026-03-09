<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CotisationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'montant' => $this->montant,
            'description' => $this->description,
            'statut' => $this->statut,
            'date_cotisation' => $this->date_cotisation,
            'date' => $this->date_cotisation,
        ];
    }
}
