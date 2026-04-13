<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

use App\Http\Controllers\LocaleController;
use App\Livewire\Licenses\{Index as LicensesIndex, Form as LicensesForm};
use App\Livewire\Doctors\{Index as DoctorsIndex, Form as DoctorsForm};
use App\Livewire\States\{Index as StatesIndex, Form as StatesForm};
use App\Livewire\Users\{Index as UsersIndex, Form as UsersForm};
use App\Livewire\Users\UpcomingCelebrations;
use App\Livewire\Attendance\Tracker;

/*
|--------------------------------------------------------------------------
| 🔓 ÚNICA RUTA PÚBLICA
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'))->name('home');

/*
|--------------------------------------------------------------------------
| 🔐 ZONA PROTEGIDA SOLO CON MIDDLEWARE
|--------------------------------------------------------------------------
*/
Route::middleware([
    'auth',
    'verified',
])->group(function () {




    Route::match(['get', 'post'], '/lang/{locale}', [LocaleController::class, 'switch'])->name('lang.switch');

    // Dashboard
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::view('/time_difference', 'time_difference')->name('time_difference');
    Route::view('/pricing', 'pricing')->name('pricing');
    Route::view('/measurement_converter', 'measurement_converter')->name('measurement_converter');
    Route::view('/qr', 'qr')->name('qr.index');

    // Settings
    Route::redirect('/settings', '/settings/profile');
    Volt::route('/settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('/settings/password', 'settings.password')->name('settings.password');
    Volt::route('/settings/appearance', 'settings.appearance')->name('settings.appearance');

    // Licenses
    Route::get('/licenses', LicensesIndex::class)->name('licenses.index');
    Route::view('/licenses/create', 'livewire.licenses.creates')->name('licenses.create');
    Route::get('/licenses/{license}/edit', LicensesForm::class)
        ->whereNumber('license')
        ->name('licenses.edit');

    // Users
    Route::get('/users', UsersIndex::class)->name('users.index');
    Route::view('/users/create', 'livewire.users.creates')->name('users.create');
    Route::get('/users/{user}/edit', UsersForm::class)
        ->whereNumber('user')
        ->name('users.edit');
    Route::get('/users/celebrations', UpcomingCelebrations::class)
        ->name('users.celebrations');

    // Attendance
    Route::get('/my-attendance', Tracker::class)->name('attendance.tracker');

    // Doctors
    Route::get('/doctors', DoctorsIndex::class)->name('doctors.index');
    Route::view('/doctors/create', 'livewire.doctors.creates')->name('doctors.create');
    Route::get('/doctors/{doctor}/edit', DoctorsForm::class)
        ->whereNumber('doctor')
        ->name('doctors.edit');

    // States
    Route::get('/states', StatesIndex::class)->name('states.index');
    Route::view('/states/create', 'livewire.states.creates')->name('states.create');
    Route::get('/states/{state}/edit', StatesForm::class)
        ->whereNumber('state')
        ->name('states.edit');
});

/*
|--------------------------------------------------------------------------
| 🚫 BLOQUEO TOTAL A RUTAS DESCONOCIDAS
|--------------------------------------------------------------------------
*/
Route::fallback(fn () => abort(404));

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
