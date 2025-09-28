<?php

use App\Http\Controllers\Api\GpsController;
use App\Http\Controllers\InvoiceController;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\BrowseCars;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\CartPage;
use App\Livewire\Confirmation;
use App\Livewire\Homepage;
use App\Livewire\MyCar;
use App\Livewire\PickupDetail;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Index;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Settings;
use App\Livewire\Thankyou;
use App\Livewire\VehicleDetail;
use Illuminate\Support\Facades\Route;

Route::get('/', Homepage::class)->name('/');
Route::get('/vehicle/{id}', VehicleDetail::class)->name('vehicle-detail');
Route::get('/browse-cars/', BrowseCars::class)->name('browse-cars');

Route::middleware('guest')->group(function(){
    Route::get('/login', Login::class)->name('login');

    Route::get('/register', Register::class)->name('register');
    Route::get('/reset/{token}', ResetPassword::class)->name('password.reset');
    Route::get('/forgot', ForgotPassword::class)->name('password.request');

});

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::middleware(['auth'])->group(function () {

    Route::get('/pickup/{id}', PickupDetail::class)->name('pickup-detail');

    Route::get('/confirmation/{car}/{pickup_location}/{rental_start}/{rental_end}/{rate_day}/{total}', Confirmation::class)
    ->name('confirmation');

    Route::get('/payments/{id}/receipt', [InvoiceController::class, 'receipt'])
    ->name('payments.receipt');

    Route::get('/logout', function(){
        auth()->logout();
        return redirect('/');
    });

    Route::get('/cart-page', CartPage::class);
    Route::get('/my-car', MyCar::class);


    Route::get('/thankyou', Thankyou::class)
    ->name('thankyou');
    Route::redirect('settings', 'settings/profile');


    Route::get('/settings', Index::class)->name('settings');

    // GPS

});

require __DIR__.'/auth.php';
