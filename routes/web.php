
<?php

use App\Http\Controllers\Auth\AboutPageSettingController;
use App\Http\Controllers\Auth\ConstructionDetailsController;
use App\Http\Controllers\Auth\ConstructionDetailsPageSettingController;
use App\Http\Controllers\Auth\ContractController;
use App\Http\Controllers\Auth\ContractSettingController;
use App\Http\Controllers\Auth\ContractTableController;
use App\Http\Controllers\Auth\DashboardController;
use App\Http\Controllers\Auth\HomePageSettingController;
use App\Http\Controllers\Auth\IndexController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\TeamController;
use App\Http\Controllers\Auth\TransportDetailsController;
use App\Http\Controllers\Auth\TravelAndToursDetailsController;
use App\Http\Controllers\Auth\TravelAndToursPageSettingController;
use App\Http\Controllers\Auth\TruckDetailsPageSettingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Public home page
Route::get('/', [IndexController::class, 'showIndex'])->name('index');

// Logout
Route::post('/logout', function () {
    Auth::logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login');
})->middleware('auth')->name('logout');

// Public pages
// Route::get('/aboutus', function () {
//     return view('aboutus');
// })->name('aboutus');
Route::get('/aboutus', [AboutPageSettingController::class, 'about'])
    ->name('aboutus');

Route::get('/team', [TeamController::class, 'showTeam'])
    ->name('team');
Route::get('/transportDetails', [TransportDetailsController::class, 'showTransportDetails'])
    ->name('transportDetails');
Route::get('/constructionDetails', [ConstructionDetailsController::class, 'showConstructionDetails'])
    ->name('constructionDetails');
Route::get('/travelAndToursDetals', [TravelAndToursDetailsController::class, 'showTravelAndToursDetails'])
    ->name('travelAndToursDetals');

// Login routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
        ->name('register.form');

    Route::post('/register/store', [RegisterController::class, 'store'])
        ->name('register.store');
});

// Public contract pages
Route::get('/contracts', [ContractController::class, 'showContracts'])
    ->name('contracts');

Route::post('/contract-submit', [ContractController::class, 'storeContract'])
    ->name('contract.store');

// Protected admin pages
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'showDashboard'])
        ->name('admin.dashboard');

    Route::get('/contracts-table', [ContractTableController::class, 'showContractsTable'])
        ->name('contractsTable');

    Route::delete('/contracts-table/{contract}', [ContractTableController::class, 'destroy'])
        ->name('contractsTable.destroy');

});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/home-settings', [HomePageSettingController::class, 'index'])
        ->name('admin.home-settings.index');

    Route::put('/admin/home-settings', [HomePageSettingController::class, 'update'])
        ->name('admin.home-settings.update');

    Route::get('/admin/about-settings', [AboutPageSettingController::class, 'index'])
        ->name('admin.about-settings.index');

    Route::put('/admin/about-settings', [AboutPageSettingController::class, 'update'])
        ->name('admin.about-settings.update');

    Route::get('/admin/contract-settings', [ContractSettingController::class, 'index'])
        ->name('admin.contract-settings.index');

    Route::put('/admin/contract-settings', [ContractSettingController::class, 'update'])
        ->name('admin.contract-settings.update');

    Route::get('/admin/truck-details-settings', [TruckDetailsPageSettingController::class, 'index'])
        ->name('admin.truckDetails-settings.index');

    Route::put('/admin/truck-details-settings', [TruckDetailsPageSettingController::class, 'update'])
        ->name('admin.truckDetails-settings.update');

    Route::get('/admin/construction-details-settings', [ConstructionDetailsPageSettingController::class, 'index'])
        ->name('admin.constructionDetails-settings.index');

    Route::put('/admin/construction-details-settings', [ConstructionDetailsPageSettingController::class, 'update'])
        ->name('admin.constructionDetails-settings.update');

    Route::get('/admin/travel-details-settings', [TravelAndToursPageSettingController::class, 'index'])
        ->name('admin.travelDetails-settings.index');

    Route::put('/admin/travel-details-settings', [TravelAndToursPageSettingController::class, 'update'])
        ->name('admin.travelDetails-settings.update');
});
