<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\StatusMatriculaController;
use App\Http\Controllers\WhatsAppWebhookController;

use App\Models\StatusMatricula;

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



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('throttle:700,1')->group(function () {
    Route::get('/escolas', [MatriculaController::class, 'escolaApiAll']);
    Route::get('/escola/{id}', [MatriculaController::class, 'escolaApiGet']);

    Route::get('/turmas/{escola}', [MatriculaController::class, 'turmaApiAll']);
    Route::get('/turma/{id}', [MatriculaController::class, 'turmaApiGet']);
    Route::get('/turma_form/{id}', [MatriculaController::class, 'turmaApiFormGet']);
});

Route::get('status', [StatusMatriculaController::class, 'index']);

Route::get('classificados', [\App\Http\Controllers\ClassificadoController::class, 'index']);

Route::post('whatsapp/webhook', [WhatsAppWebhookController::class, 'handleWebhook']);
Route::get('whatsapp/webhook/status', [WhatsAppWebhookController::class, 'status']);
Route::get('whatsapp/webhook/verify', [WhatsAppWebhookController::class, 'verify']);
