<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StrataController;
use App\Http\Controllers\Api\SpeciesController;
use App\Http\Controllers\Api\GenderController;
use App\Http\Controllers\Api\PersonController;
use App\Http\Controllers\Api\StatsController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/v1/info')->group(function () {
    Route::get('/strata', [StrataController::class, 'index']);
    Route::get('/species', [SpeciesController::class, 'index']);
    Route::get('/genders', [GenderController::class, 'index']);
    Route::get('/persons', [PersonController::class, 'index']);
});

Route::get('/v1/stats/age', [StatsController::class, 'age']);
Route::get('/v1/stats/count', [StatsController::class, 'count']);