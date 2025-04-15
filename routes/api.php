<?php

use Illuminate\Http\Request;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::prefix('attendees')->group(function () {
    Route::post('/', [AttendeeController::class, 'store']);
    Route::put('/{id}', [AttendeeController::class, 'update']);
    Route::delete('/{id}', [AttendeeController::class, 'destroy']);
});

Route::prefix('bookings')->group(function () {
    Route::post('/', [BookingController::class, 'store']);
    Route::delete('/{id}', [BookingController::class, 'destroy']);
});

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('events')->group(function () {
        Route::get('/', [EventController::class, 'index']);
        Route::post('/', [EventController::class, 'store']);
        Route::get('/{id}', [EventController::class, 'show']);
        Route::put('/{id}', [EventController::class, 'update']);
        Route::delete('/{id}', [EventController::class, 'destroy']);
    });
});