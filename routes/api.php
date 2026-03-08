<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CotisationController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/cotisations', [CotisationController::class, 'store']);
    Route::get('/cotisations', [CotisationController::class, 'index']);
    Route::get('/cotisations/total-annuel', [CotisationController::class, 'totalAnnuel']);
    Route::get('/cotisations/total-user', [CotisationController::class, 'totalUser']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/dashboard/global', [DashboardController::class, 'global']);
    Route::get('/dashboard/mensuel', [DashboardController::class, 'mensuel']);
    Route::get('/user', function (Request $request) {
    return $request->user();
   
});
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/test', function () {
    return response()->json([
        "status" => "API Laravel fonctionne",
        "server_time" => now()
    ]);
});

use App\Models\User;

Route::get('/users-test', function () {
    return User::all();
});