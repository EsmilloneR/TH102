<?php

use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\BrowseCars;
use App\Livewire\Homepage;
use App\Livewire\PickupDetail;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\VehicleDetail;
use Illuminate\Support\Facades\Route;

Route::get('/', Homepage::class);
Route::get('/browse-cars', BrowseCars::class);
Route::get('/vehicle/{id}', VehicleDetail::class);


Route::middleware('guest')->group(function(){
    Route::get('/login-page', LoginPage::class);
    Route::get('/register-page', RegisterPage::class);
});

Route::middleware('auth')->group(function(){
    Route::get('/pickup/{id}', PickupDetail::class);

    Route::get('/logout', function(){
        auth()->logout();
        return redirect('/');
    });

});

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
