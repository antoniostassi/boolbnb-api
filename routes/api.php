<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//
use App\Http\Controllers\Api\ApartmentController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\PromotionController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\VisualizationController;

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
    'show'
]);

Route::resource('apartments', ApartmentController::class)->middleware('auth')->only([
    'store',
    'destroy'
]);

Route::resource('messages', MessageController::class)->only([
    'store',
]);

Route::resource('visualizations', VisualizationController::class)->only([
    'index',
    'store'
]);

Route::post('apartment/promotion/{apartment}', [ApartmentController::class, 'addPromotion'])->middleware('auth');
Route::match(['patch', 'put'],'apartments/{apartment}', [ApartmentController::class, 'update'])->middleware('auth');