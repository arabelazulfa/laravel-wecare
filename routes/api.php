<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParticipationController;
use App\Http\Controllers\EventReviewController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ReportController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('participations', ParticipationController::class);
    Route::apiResource('event-reviews', EventReviewController::class);
    Route::apiResource('chats', ChatController::class)
        ->only(['index', 'store', 'show', 'destroy']);
    Route::apiResource('reports', ReportController::class)
        ->only(['index', 'store', 'show', 'destroy']);
});
