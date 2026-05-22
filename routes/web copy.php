<?php

use App\Http\Controllers\MatriculaController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProcessoSeletivoController;
use Illuminate\Support\Facades\Cache;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', [ProcessoSeletivoController::class, 'index']);
Route::get('/', function () {
    return view ('indexx');
});
// Route::get('/processo-seletivo', function () {
//     return Inertia::render('EmBreve');
// })->name('processo-seletivo');

// Route::get('/processo-seletivo', function () {
//     return Inertia::render('ProcessoFechado');
// })->name('processo-seletivo');

// Route::get('/index1', [MatriculaController::class, 'index1'])->name('index1');

Route::get('/matricula', [MatriculaController::class, 'index'])->name('matricula.2024');
Route::post('/matricula/enviar', [MatriculaController::class, 'store'])->name('matricula.2024.store');
Route::post('/matricula/consultar-bairro', [MatriculaController::class, 'bairro']);
Route::post('/matricula/consultar-escola', [MatriculaController::class, 'escola']);
Route::post('/matricula/consultar-turma', [MatriculaController::class, 'turma']);
Route::get('/matricula/comprovante/{id}/{tipo?}', [MatriculaController::class, 'comprovante'])->name('matricula.comprovante');


// Route::post('/matricula', [MatriculaController::class, 'matricula'])->name('matricula.store');
// Route::get('/matricula/comprovante/{id}/{tipo?}', [MatriculaController::class, 'comprovante'])->name('pre-matricula.comprovante');

//Criar um redireionamento do /processo-seletivo para https://educacao.mangaratiba.rj.gov.br/processo-seletivo
Route::get('/processo-seletivo', function () {
    return redirect()->away('https://mangaratiba.rj.gov.br/novoportal/processos-seletivos.php');
})->name('processo-seletivo');

// Route::get('/processo-seletivo-teste', [ProcessoSeletivoController::class, 'index'])->name('processo-seletivo.store');
// Route::post('/processo-seletivo-teste', [ProcessoSeletivoController::class, 'store'])->name('processo-seletivo.store');
Route::post('/processo-seletivo-xp', [ProcessoSeletivoController::class, 'storexp'])->name('processo-seletivo.storexp');
Route::get('/processo-seletivo-xp/{id}', [ProcessoSeletivoController::class, 'test'])->name('processo-seletivo.test');
Route::get('/processo-seletivo-check-vaga/{id}', [ProcessoSeletivoController::class, 'set_vagas'])->name('processo-seletivo.set_vagas');
Route::get('/processo-seletivo/sucesso', [ProcessoSeletivoController::class, 'sucesso'])->name('processo-seletivo.sucesso');

Route::get('/processo-seletivo/consulta', [ProcessoSeletivoController::class, 'consulta'])->name('processo-seletivo.consulta');
Route::post('/processo-seletivo/consulta', [ProcessoSeletivoController::class, 'checkconsulta'])->name('processo-seletivo.checkconsulta');

Route::get('/processo-seletivo/comprovante/{id}/{tipo?}', [ProcessoSeletivoController::class, 'comprovante'])->name('processo-seletivo.comprovante');

Route::get('/pre-matricula', function () {
    return redirect()->away('https://mangaratiba.rj.gov.br/pre-matricula-sme/');
})->name('pre-matricula');

Route::get('/manutencao', function () {
    if (!Cache::get('modo_manutencao', false)) {
        return redirect('/');
    }
    return view('maintenance');
})->name('manutencao');

Route::middleware(['auth'])->group(function () {
    Route::get('/toggle-manutencao', function () {
        if (!(auth()->user() && method_exists(auth()->user(), 'isSuperAdmin') && auth()->user()->isSuperAdmin())) {
            return redirect('/manutencao');
        }
        $ativo = Cache::get('modo_manutencao', false);
        return view('admin.maintenance-toggle', compact('ativo'));
    })->name('toggle-manutencao');

    Route::post('/toggle-manutencao', function () {
        if (!(auth()->user() && method_exists(auth()->user(), 'isSuperAdmin') && auth()->user()->isSuperAdmin())) {
            return redirect('/manutencao');
        }
        $ativo = request()->has('ativo');
        Cache::forever('modo_manutencao', $ativo);
        return redirect()->route('toggle-manutencao')->with('status', 'Modo manutenção ' . ($ativo ? 'ativado' : 'desativado') . '!');
    });
});

Route::get('/manutencao-status', function () {
    return response()->json(['ativo' => Cache::get('modo_manutencao', false)]);
});




