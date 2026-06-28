<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ConversationController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\CRM\WhatsappController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/whatsapp/webhook', [WhatsappController::class, 'verify']);

Route::post('/whatsapp/webhook', [WhatsappController::class, 'receive']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::prefix('conversations')->group(function () {

        Route::get('/', [ConversationController::class, 'index']);

        Route::get('/{conversation}', [ConversationController::class, 'show']);

        Route::get('/{conversation}/messages', [ConversationController::class, 'messages']);

        Route::post('/{conversation}/take', [ConversationController::class, 'take']);

        Route::post('/{conversation}/assign', [ConversationController::class, 'assign']);

        Route::post('/{conversation}/resolve', [ConversationController::class, 'resolve']);

        Route::post('/{conversation}/reopen', [ConversationController::class, 'reopen']);
    });
});
