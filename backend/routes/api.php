<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\StandController as AdminStandController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Creator\PaymentController as CreatorPaymentController;
use App\Http\Controllers\Creator\StandController as CreatorStandController;
use App\Http\Controllers\Tickets\TicketPurchaseController;
use App\Http\Controllers\Payments\PaymentWebhookController;

Route::get('/test', function () {
    return response()->json(['message' => 'Hello from Laravel API']);
});

/**
 * ========================
 * ADMIN ROUTES
 * ========================
 */
Route::middleware(['auth:sanctum', 'isAdmin'])->prefix('admin')->group(function () {
    // Utilisateurs
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::post('/users', [UserController::class, 'store']);
    Route::patch('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    // Événements
    Route::get('/events/pending', [EventController::class, 'pending']);
    Route::patch('/events/{id}/approve', [EventController::class, 'approve']);
    Route::patch('/events/{id}/reject', [EventController::class, 'reject']);
    Route::patch('/events/{id}/finish', [EventController::class, 'finish']);

    // Stands
    Route::get('/stands/pending', [AdminStandController::class, 'pending']);
    Route::patch('/stands/{id}/pre-approve', [AdminStandController::class, 'preApprove']);
    Route::patch('/stands/{id}/reject', [AdminStandController::class, 'reject']);

    // Paiements de tickets
    Route::get('/payments/tickets', [AdminPaymentController::class, 'tickets']);
    Route::get('/payments/stats',   [AdminPaymentController::class, 'stats']);
    Route::post('/payments/{paiement_id}/refund', [AdminPaymentController::class, 'refund']);
});

/**
 * ========================
 * CRÉATEUR ROUTES
 * ========================
 */
Route::middleware(['auth:sanctum', 'role:createur'])->prefix('creator')->group(function () {
    // Stands
    Route::patch('/stands/{id}/approve', [CreatorStandController::class, 'approve']);
    Route::patch('/stands/{id}/reject', [CreatorStandController::class, 'reject']);

    // Paiements de tickets
    Route::get('/payments/tickets', [CreatorPaymentController::class, 'tickets']);
    Route::get('/payments/stats',   [CreatorPaymentController::class, 'stats']);
});

/**
 * ========================
 * ACHAT DE TICKETS
 * ========================
 */
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/tickets/buy', [TicketPurchaseController::class, 'buy']);
});

/**
 * ========================
 * PAIEMENTS CALLBACKS
 * ========================
 */
Route::post('/payments/webhook', [PaymentWebhookController::class, 'handle'])
    ->name('payments.webhook');

// (Optionnel) route mock checkout
Route::get('/payments/mock/checkout', fn () => response()->json(['ok' => true]))
    ->name('payments.mock.checkout');


