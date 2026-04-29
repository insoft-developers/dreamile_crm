<?php

use App\Http\Controllers\CRM\BranchController;
use App\Http\Controllers\CRM\CompanyController;
use App\Http\Controllers\CRM\DashboardController;
use App\Http\Controllers\CRM\LevelController;
use App\Http\Controllers\CRM\PositionController;
use App\Http\Controllers\CRM\UserController;
use App\Http\Controllers\ProfileController;
use App\Models\Position;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');
    Route::get('/', [DashboardController::class, 'index']);
    Route::resource('/company', CompanyController::class);
    Route::get('/company_table', [CompanyController::class, 'table'])->name('company.table');
    Route::resource('/branch', BranchController::class);
    Route::get('/branch_table', [BranchController::class, 'table'])->name('branch.table');
    Route::resource('/user', UserController::class);
    Route::get('/user_table', [UserController::class, 'table'])->name('user.table');
    Route::post('/user_activate', [UserController::class, 'activate']);

    Route::resource('/position', PositionController::class);
    Route::get('/position_table', [PositionController::class, 'table'])->name('position.table');
    Route::resource('/level', LevelController::class);
    Route::get('/level_table', [LevelController::class, 'table'])->name('level.table');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
