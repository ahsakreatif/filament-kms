<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecommendationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Recommendation routes
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('recommendations')->group(function () {
        Route::get('/threads', [RecommendationController::class, 'getRecommendedThreads']);
        Route::get('/top-tags', [RecommendationController::class, 'getUserTopTags']);
        Route::get('/similar-users', [RecommendationController::class, 'getSimilarUsers']);
        Route::get('/preferences', [RecommendationController::class, 'getUserPreferences']);
    });
});
