<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TerrainController;
use App\Http\Controllers\ReservationController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('projects', ProjectController::class);

Route::get('/utilisateur', function (Request $request) {
    return $request->utilisateur();
})->middleware('auth:sanctum');

Route::apiResource('users', AuthController::class);
Route::post('/login', [AuthController::class, 'login']);

Route::apiResource('terrains', TerrainController::class)->except(['show']);;
Route::get('/terrains/search', [TerrainController::class, 'search']);


Route::get('/reservations/telephone/{telephone}', [ReservationController::class, 'getByTelephone']);
Route::get('/reservations/terrain/{terrainId}', [ReservationController::class, 'getByTerrain']);

Route::apiResource('reservations', ReservationController::class);
