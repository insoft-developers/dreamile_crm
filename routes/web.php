<?php

use App\Http\Controllers\CRM\AdministrativeController;
use App\Http\Controllers\CRM\BranchController;
use App\Http\Controllers\CRM\ChatController;
use App\Http\Controllers\CRM\CompanyController;
use App\Http\Controllers\CRM\DashboardController;
use App\Http\Controllers\CRM\EventController;
use App\Http\Controllers\CRM\LeadController;
use App\Http\Controllers\CRM\LeadSourceController;
use App\Http\Controllers\CRM\LevelController;
use App\Http\Controllers\CRM\PositionController;
use App\Http\Controllers\CRM\UserController;
use App\Http\Controllers\ProfileController;
use App\Models\LeadSource;
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

    Route::resource('/lead_source', LeadSourceController::class);
    Route::get('/lead_source_table', [LeadSourceController::class, 'table'])->name('lead.source.table');

    Route::resource('/event', EventController::class);
    Route::get('/event_table', [EventController::class, 'table'])->name('event.table');

    Route::resource('/chat', ChatController::class);

    Route::resource('/lead', LeadController::class);
    Route::get('/lead_table', [LeadController::class, 'table'])->name('lead.table');
    Route::get('/api/event', [LeadController::class, 'event']);
    Route::post('/visit_add', [LeadController::class, 'visitAdd'])->name('visit.add');
    Route::get('/get_visit_data/{id}', [LeadController::class, 'visitData']);
    Route::get('/followup_data/{id}', [LeadController::class, 'followupData']);
    Route::post('/follow_add', [LeadController::class, 'followAdd'])->name('follow.add');
    Route::get('/followup_edit/{id}', [LeadController::class, 'followEdit']);
    Route::post('/follow_update', [LeadController::class, 'followUpdate'])->name('follow.update');


    Route::get('/api/province', [AdministrativeController::class, 'province']);
    Route::get('/api/regency/{provinceCode}', [AdministrativeController::class, 'regency']);
    Route::get('/api/district/{regencyCode}', [AdministrativeController::class, 'district']);
    Route::get('/api/village/{districtCode}', [AdministrativeController::class, 'village']);

    


});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
