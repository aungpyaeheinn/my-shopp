<?php

use App\Livewire\Component\PaymentSlipComponent;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/order-requests', PaymentSlipComponent::class)->name('payment-slips');
});

require __DIR__ . '/settings.php';
