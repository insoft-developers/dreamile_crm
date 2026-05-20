<?php

use App\Http\Controllers\CRM\AdministrativeController;
use App\Http\Controllers\CRM\BranchController;
use App\Http\Controllers\CRM\BroadcastController;
use App\Http\Controllers\CRM\ChatController;
use App\Http\Controllers\CRM\CompanyController;
use App\Http\Controllers\CRM\ContactGroupController;
use App\Http\Controllers\CRM\CustomerController;
use App\Http\Controllers\CRM\DashboardController;
use App\Http\Controllers\CRM\EventController;
use App\Http\Controllers\CRM\GroupManageController;
use App\Http\Controllers\CRM\LeadController;
use App\Http\Controllers\CRM\LeadSourceController;
use App\Http\Controllers\CRM\LevelController;
use App\Http\Controllers\CRM\PositionController;
use App\Http\Controllers\CRM\TemplateController;
use App\Http\Controllers\CRM\TemplateDetailController;
use App\Http\Controllers\CRM\UserController;
use App\Http\Controllers\ProfileController;
use App\Models\ContactGroup;
use App\Models\LeadSource;
use App\Models\Position;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Svg\Tag\Group;

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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [DashboardController::class, 'index']);
    Route::resource('/company', CompanyController::class)->middleware('super');
    Route::get('/company_table', [CompanyController::class, 'table'])->name('company.table');
    Route::resource('/branch', BranchController::class)->middleware('super');
    Route::get('/branch_table', [BranchController::class, 'table'])->name('branch.table');
    Route::resource('/user', UserController::class)->middleware('super');
    Route::get('/user_table', [UserController::class, 'table'])->name('user.table');
    Route::post('/user_activate', [UserController::class, 'activate']);

    // Route::resource('/position', PositionController::class);
    // Route::get('/position_table', [PositionController::class, 'table'])->name('position.table');
    Route::resource('/level', LevelController::class)->middleware('super');
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
    Route::get('/lead/export/excel', [LeadController::class, 'exportExcel']);
    Route::get('/lead/export/pdf', [LeadController::class, 'exportPDF']);
    Route::post('/convert', [LeadController::class, 'convert']);

    Route::resource('/customer', CustomerController::class);
    Route::get('/customer_table', [CustomerController::class, 'table'])->name('customer.table');
    Route::get('/customer/export/excel', [CustomerController::class, 'exportExcel']);
    Route::get('/customer/export/pdf', [CustomerController::class, 'exportPDF']);
    Route::post('/downgrade', [CustomerController::class, 'downgrade']);



    Route::get('/api/province', [AdministrativeController::class, 'province']);
    Route::get('/api/regency/{provinceCode}', [AdministrativeController::class, 'regency']);
    Route::get('/api/district/{regencyCode}', [AdministrativeController::class, 'district']);
    Route::get('/api/village/{districtCode}', [AdministrativeController::class, 'village']);

    Route::resource('/broadcast', BroadcastController::class);
    Route::get('/broadcast_table', [BroadcastController::class, 'table'])->name('broadcast.table');

    Route::post('broadcast/start/{id}', [BroadcastController::class, 'start']);
    Route::post('broadcast/retry/{id}', [BroadcastController::class, 'retry']);

    Route::resource('/broadcast_template', TemplateController::class);
    Route::get('/template_table', [TemplateController::class, 'table'])->name('template.table');

    Route::resource('/template_detail', TemplateDetailController::class);
    Route::get('/template_detail_table', [TemplateDetailController::class, 'table'])->name('template.detail.table');

    Route::resource('/contact_group', ContactGroupController::class);
    Route::get('/contact_group_table', [ContactGroupController::class, 'table'])->name('contact.group.table');

    Route::resource('/group_manage', GroupManageController::class);
    Route::get('/group_manage_table', [GroupManageController::class, 'table'])->name('group.manage.table');

    Route::post('/heartbeat', [DashboardController::class, 'hearbeat']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
