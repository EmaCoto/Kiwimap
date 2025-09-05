<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\Licenses\{Index as LicensesIndex, Form as LicensesForm};

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::middleware(['auth','verified'])->group(function () {
    Route::get('/licenses', LicensesIndex::class)->name('licenses.index');

    // create DEBE ir antes del comodín:
    Route::view('/licenses/create', 'livewire.licenses.creates')->name('licenses.create');

    // Comodín SOLO para edit y restringido a números
    Route::get('/licenses/{license}/edit', LicensesForm::class)
        ->whereNumber('license')
        ->name('licenses.edit');
});

require __DIR__.'/auth.php';
