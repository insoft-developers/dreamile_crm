<?php

use App\Http\Controllers\CRM\AdministrativeController;
use App\Http\Controllers\CRM\AgentPerformReportController;
use App\Http\Controllers\CRM\BranchController;
use App\Http\Controllers\CRM\BroadcastController;
use App\Http\Controllers\CRM\BroadcastDetailController;
use App\Http\Controllers\CRM\BroadcastReportController;
use App\Http\Controllers\CRM\ChatAccessController;
use App\Http\Controllers\CRM\ChatController;
use App\Http\Controllers\CRM\ChatHistoryDetailController;
use App\Http\Controllers\CRM\ChatReportController;
use App\Http\Controllers\CRM\CompanyController;
use App\Http\Controllers\CRM\ContactGroupController;
use App\Http\Controllers\CRM\CustomerController;
use App\Http\Controllers\CRM\DashboardController;
use App\Http\Controllers\CRM\EventController;
use App\Http\Controllers\CRM\FirstResponseTimeController;
use App\Http\Controllers\CRM\FollowupReportController;
use App\Http\Controllers\CRM\GroupManageController;
use App\Http\Controllers\CRM\LeadController;
use App\Http\Controllers\CRM\LeadSourceController;
use App\Http\Controllers\CRM\LevelController;
use App\Http\Controllers\CRM\PositionController;
use App\Http\Controllers\CRM\PresentationController;
use App\Http\Controllers\CRM\ProfileController;
use App\Http\Controllers\CRM\ReportController;
use App\Http\Controllers\CRM\TemplateController;
use App\Http\Controllers\CRM\TemplateDetailController;
use App\Http\Controllers\CRM\UserController;
use App\Http\Controllers\CRM\VisitReportController;

use App\Http\Controllers\TestController;
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

Route::get('/test_query', [TestController::class, 'index']);

Route::get('/chat-access/{token}', [ChatAccessController::class, 'index']);

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
    Route::get('/event/export/excel', [EventController::class, 'exportExcel']);
    Route::get('/event/export/pdf', [EventController::class, 'exportPDF']);

    Route::resource('/chat', ChatController::class);

    Route::resource('/lead', LeadController::class);
    Route::get('/lead_table', [LeadController::class, 'table'])->name('lead.table');
    Route::get('/api/event', [LeadController::class, 'event']);
    Route::get('/api/presentation', [LeadController::class, 'presentation']);
    Route::post('/visit_add', [LeadController::class, 'visitAdd'])->name('visit.add');
    Route::get('/get_visit_data/{id}', [LeadController::class, 'visitData']);
    Route::get('/followup_data/{id}', [LeadController::class, 'followupData']);
    Route::post('/follow_add', [LeadController::class, 'followAdd'])->name('follow.add');
    Route::get('/followup_edit/{id}', [LeadController::class, 'followEdit']);
    Route::post('/follow_update', [LeadController::class, 'followUpdate'])->name('follow.update');
    Route::get('/lead/export/excel', [LeadController::class, 'exportExcel']);
    Route::get('/lead/export/pdf', [LeadController::class, 'exportPDF']);
    Route::post('/convert', [LeadController::class, 'convert']);
    Route::get('/presentation/attribute', [LeadController::class, 'presentationAttribute']);
    Route::get('lead_detail/pdf/{id}', [LeadController::class, 'exportDetailPdf']);



    Route::resource('/customer', CustomerController::class);
    Route::get('/customer_table', [CustomerController::class, 'table'])->name('customer.table');
    Route::get('/customer/export/excel', [CustomerController::class, 'exportExcel']);
    Route::get('/customer/export/pdf', [CustomerController::class, 'exportPDF']);
    Route::post('/downgrade', [CustomerController::class, 'downgrade']);

    Route::resource('/presentation', PresentationController::class);
    Route::get('/presentation_table', [PresentationController::class, 'table'])->name('presentation.table');
    Route::get('/presentation/export/excel', [PresentationController::class, 'exportExcel']);
    Route::get('/presentation/export/pdf', [PresentationController::class, 'exportPDF']);
    Route::get('/presentation_download_template', [PresentationController::class, 'downloadTemplate'])->name('presentation.template');
    Route::post('/presentation_import_data', [PresentationController::class, 'import'])->name('presentation.import');




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


    Route::get('/lead_report', [ReportController::class, 'lead']);
    Route::get('/report/lead/data', [ReportController::class, 'leadReportData']);

    Route::get('/agent_perform_report', [AgentPerformReportController::class, 'index']);
    Route::get('/agent_perform_table', [AgentPerformReportController::class, 'table'])->name('agent.perform.table');
    Route::get('/agent_perform/export/excel', [AgentPerformReportController::class, 'exportExcel']);
    Route::get('/agent_perform/export/pdf', [AgentPerformReportController::class, 'exportPDF']);



    Route::get('/broadcast_report', [ReportController::class, 'broadcast']);
    Route::get('/followup_report', [ReportController::class, 'followup']);
    Route::get('/conversion_report', [ReportController::class, 'conversion']);
    Route::get('/admin_performance_report', [ReportController::class, 'admin_performance']);

    Route::get('/first_response_time', [FirstResponseTimeController::class, 'index']);
    Route::get('/first_response_table', [FirstResponseTimeController::class, 'table'])->name('first.response.table');
    Route::get('/frt/export/excel', [FirstResponseTimeController::class, 'exportExcel']);
    Route::get('/frt/export/pdf', [FirstResponseTimeController::class, 'exportPDF']);
    Route::get('/first_response_time/{id}', [FirstResponseTimeController::class, 'show']);
    Route::get('/first_response_detail_table', [FirstResponseTimeController::class, 'detailTable'])->name('first.response.detail.table');
    Route::get('/frt_detail/export/excel', [FirstResponseTimeController::class, 'exportDetailExcel']);
    Route::get('/frt_detail/export/pdf', [FirstResponseTimeController::class, 'exportDetailPDF']);

    Route::get('/message_report', [ChatReportController::class, 'index']);
    Route::get('/chat_report_table', [ChatReportController::class, 'table'])->name('chat.report.table');
    Route::get('/chat/export/excel', [ChatReportController::class, 'exportExcel']);
    Route::get('/chat/export/pdf', [ChatReportController::class, 'exportPDF']);

    Route::get('/message_detail_report/{id}', [ChatHistoryDetailController::class, 'index']);
    Route::get('/chat_detail_table', [ChatHistoryDetailController::class, 'table'])->name('chat.detail.table');
    Route::get('/chat_detail/export/excel', [ChatHistoryDetailController::class, 'exportExcel']);
    Route::get('/chat_detail/export/pdf', [ChatHistoryDetailController::class, 'exportPDF']);


    Route::get('/broadcast_report', [BroadcastReportController::class, 'index']);
    Route::get('/broadcast_report_table', [BroadcastReportController::class, 'table'])->name('broadcast.report.table');
    Route::get('/broadcast_report/export/excel', [BroadcastReportController::class, 'exportExcel']);
    Route::get('/broadcast_report/export/pdf', [BroadcastReportController::class, 'exportPDF']);
    
    Route::get('/broadcast_detail_report/{id}', [BroadcastDetailController::class, 'index']);
    Route::get('/broadcast_detail_report_table', [BroadcastDetailController::class, 'table'])->name('broadcast.detail.report.table');
    Route::get('/broadcast_detail_report/export/excel', [BroadcastDetailController::class, 'exportExcel']);
    Route::get('/broadcast_detail_report/export/pdf', [BroadcastDetailController::class, 'exportPDF']);

    Route::get('/followup_report', [FollowupReportController::class, 'index']);
    Route::get('/followup_report_table', [FollowupReportController::class, 'table'] )->name('followup.report.table');
    Route::get('/followup_report/export/excel', [FollowupReportController::class, 'exportExcel']);
    Route::get('/followup_report/export/pdf', [FollowupReportController::class, 'exportPDF']);

    Route::get('/visit_report', [VisitReportController::class, 'index']);
    Route::get('/visit_report_table', [VisitReportController::class, 'table'])->name('visit.report.table');
    Route::get('/visit_report/export/excel', [VisitReportController::class, 'exportExcel']);
    Route::get('/visit_report/export/pdf', [VisitReportController::class, 'exportPDF']);

    Route::get('/view_profile', [ProfileController::class, 'index']);
    Route::post('/user_profile_update', [ProfileController::class, 'update'])->name('user.profile.update');


});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
