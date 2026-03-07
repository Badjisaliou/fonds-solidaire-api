<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cotisation;
use App\Http\Requests\StoreCotisationRequest;
use App\Http\Resources\CotisationResource;
use App\Services\CotisationService;


class CotisationController extends Controller
{
    protected $cotisationService;

    public function __construct(CotisationService $cotisationService)
    {
        $this->cotisationService = $cotisationService;
    }

    
   public function store(StoreCotisationRequest $request)
{
    $path = $request->file('justificatif')->store('justificatifs', 'public');

    $cotisation = $this->cotisationService->create([
        'montant' => $request->montant,
        'description' => $request->description,
        'justificatif' => $path,
        'date_cotisation' => $request->date_cotisation,
    ], $request->user()->id);

    return response()->json([
        'message' => 'Cotisation créée avec succès',
        'data' => new CotisationResource($cotisation)
    ], 201);
}

public function index(Request $request)
{

    $query = Cotisation::where('user_id', $request->user()->id);

    // filtre par mois (optionnel)
    if ($request->has('month')) {
        $query->whereMonth('date_cotisation', $request->month);
    }

    // filtre par année (optionnel)
    if ($request->has('year')) {
        $query->whereYear('date_cotisation', $request->year);
    }

    $cotisations = $query
        ->orderBy('date_cotisation', 'desc')
        ->get();

    return response()->json([
    'data' => $cotisations
]);

}

public function totalUser(Request $request)
{
    $total = Cotisation::where('user_id', $request->user()->id)
        ->sum('montant');

    return response()->json([
        'total' => (int) $total
    ]);
}

}