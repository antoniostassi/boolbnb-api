<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//
use App\Http\Controllers\Api\ApartmentController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\PromotionController;
use App\Http\Controllers\Api\MessageController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('services', ServiceController::class)->only([
    'index'
]);

Route::resource('promotions', PromotionController::class)->only([
    'index'
]);

Route::resource('apartments', ApartmentController::class)->only([
    'index',
    'show',
    'store',
    'update',
    'destroy'
]);

Route::resource('messages', MessageController::class)->only([
    'store',
]);
