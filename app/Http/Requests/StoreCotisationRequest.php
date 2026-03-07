<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCotisationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // autorise l'utilisateur connecté
    }

   public function rules(): array
{
    return [
        'montant' => 'required|numeric|min:5000',
        'description' => 'nullable|string',
        'justificatif' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'date_cotisation' => 'required|date',
    ];
}
}