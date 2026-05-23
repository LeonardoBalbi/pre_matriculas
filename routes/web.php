<?php

use App\Http\Controllers\Auth\ApiLoginController;
use App\Http\Controllers\Auth\ApiRegisterController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\ProcessoSeletivoController;
use App\Http\Controllers\StatusMatriculaController;
use App\Http\Controllers\TransferController;
use App\Models\Candidato;
use App\Models\Distrito;
use App\Models\Escola;
use App\Models\Matricula;
use App\Models\StatusMatricula;
use App\Models\TipoDeficiencia;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;

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
    $storage = Storage::disk('public');

    $escolas = Escola::with(['bairro', 'distrito'])
        ->select('id', 'escola_nome', 'escola_endereco', 'escola_foto', 'escola_bairro_id', 'escola_distrito_id')
        ->get()
        ->map(function ($e) use ($storage) {
            $fotoUrl = ($e->escola_foto && $storage->exists($e->escola_foto))
                ? $storage->url($e->escola_foto)
                : null;

            return [
                'id' => $e->id,
                'nome' => $e->escola_nome,
                'endereco' => $e->escola_endereco,
                'foto_url' => $fotoUrl,
                'bairro' => $e->bairro ? $e->bairro->descricao : null,
                'distrito' => $e->distrito ? $e->distrito->distrito : null,
            ];
        });

    return view('index', compact('escolas'));
});
// Route::get('/processo-seletivo', function () {
//     return Inertia::render('EmBreve');
// })->name('processo-seletivo');

// Route::get('/processo-seletivo', function () {
//     return Inertia::render('ProcessoFechado');
// })->name('processo-seletivo');

// Route::get('/index1', [MatriculaController::class, 'index1'])->name('index1');

Route::get('/matricula', function () {
    return redirect('/pre-matricula');
});

// formulario em vue js

// Route::get('/matricula', [MatriculaController::class, 'index'])->name('matricula.2024');

Route::post('/matricula/enviar', [MatriculaController::class, 'store'])->name('matricula.2024.store');
Route::post('/matricula/consultar-bairro', [MatriculaController::class, 'bairro']);
Route::post('/matricula/consultar-escola', [MatriculaController::class, 'escola']);
Route::post('/matricula/consultar-turma', [MatriculaController::class, 'turma']);
Route::post('/matricula/buscar-por-cpf', [MatriculaController::class, 'buscarPorCpf'])->name('matricula.buscar-cpf');
Route::get(
    '/matricula/comprovante/{id}/{tipo?}',
    [MatriculaController::class, 'comprovante']
)->name('matricula.comprovante');

Route::get('/pre-matricula', function () {
    $distritos = Distrito::all();
    $deficiencias = TipoDeficiencia::all();

    $prefillName = '';
    $prefillEmail = '';

    if (session('api_user')) {
        $prefillName = session('api_user')['name'] ?? '';
        $prefillEmail = session('api_user')['email'] ?? '';
    } elseif (auth()->check()) {
        $prefillName = auth()->user()->name;
        $prefillEmail = auth()->user()->email;
    }

    return view('inscritos', compact('distritos', 'deficiencias', 'prefillName', 'prefillEmail'));
});

Route::get('/inscritos', function () {
    $distritos = Distrito::all();
    $deficiencias = TipoDeficiencia::all();

    $prefillName = '';
    $prefillEmail = '';

    if (session('api_user')) {
        $prefillName = session('api_user')['name'] ?? '';
        $prefillEmail = session('api_user')['email'] ?? '';
    } elseif (auth()->check()) {
        $prefillName = auth()->user()->name;
        $prefillEmail = auth()->user()->email;
    }

    return view('inscritos', compact('distritos', 'deficiencias', 'prefillName', 'prefillEmail'));
});

Route::get('/tutorial', function () {
    return view('tutorial');
});

Route::get('/inscritos/sucesso/{id}', function ($id) {
    return view('inscritos-sucesso', ['id' => $id]);
})->name('inscritos.sucesso');

Route::get('/pre-matricula/sucesso/{id}', function ($id) {
    return view('inscritos-sucesso', ['id' => $id]);
})->name('pre-matricula.sucesso');

Route::get('/email-teste', function () {
    $destinatarios = User::role('admin_edu')->pluck('email')->filter()->all();
    if (empty($destinatarios)) {
        return response()->json(['ok' => false, 'error' => 'Nenhum usuário admin_edu com e-mail cadastrado'], 400);
    }
    try {
        foreach ($destinatarios as $email) {
            Mail::raw('Teste de e-mail do sistema de pré-matrícula.', function ($m) use ($email) {
                $m->to($email)->subject('Teste de e-mail - Pré-matrícula');
            });
        }

        return response()->json(['ok' => true, 'sent_to' => $destinatarios], 200);
    } catch (Throwable $e) {
        return response()->json(['ok' => false, 'error' => $e->getMessage()], 500);
    }
})->middleware(['auth', 'can:accessAdminPanel']);

// Route::get('/matricula', function () {
//     return redirect()->away('https://mangaratiba.rj.gov.br/pre-matricula/comunicado.html');
// })->name('matricula');

// Route::post('/matricula', [MatriculaController::class, 'matricula'])->name('matricula.store');
// Route::get('/matricula/comprovante/{id}/{tipo?}', [MatriculaController::class, 'comprovante'])->name('pre-matricula.comprovante');

// Criar um redireionamento do /processo-seletivo para https://educacao.mangaratiba.rj.gov.br/processo-seletivo
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

Route::get('/manutencao', function () {
    if (! Cache::get('modo_manutencao', false)) {
        return redirect('/');
    }

    return view('maintenance');
})->name('manutencao');

Route::middleware(['auth'])->group(function () {
    Route::get('/toggle-manutencao', function () {
        if (! (auth()->user() && method_exists(auth()->user(), 'isSuperAdmin') && auth()->user()->isSuperAdmin())) {
            return redirect('/manutencao');
        }
        $ativo = Cache::get('modo_manutencao', false);

        return view('admin.maintenance-toggle', compact('ativo'));
    })->name('toggle-manutencao');

    Route::post('/toggle-manutencao', function () {
        if (! (auth()->user() && method_exists(auth()->user(), 'isSuperAdmin') && auth()->user()->isSuperAdmin())) {
            return redirect('/manutencao');
        }
        $ativo = request()->has('ativo');
        Cache::forever('modo_manutencao', $ativo);

        return redirect()->route('toggle-manutencao')->with('status', 'Modo manutenção '.($ativo ? 'ativado' : 'desativado').'!');
    });
});

Route::get('/manutencao-status', function () {
    return response()->json(['ativo' => Cache::get('modo_manutencao', false)]);
});

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', function () {
    $data = request()->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'string', 'min:6', 'confirmed'],
    ]);
    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
    ]);

    return redirect('/login');
});

Route::get('/register/pre-matricula', function () {
    return view('register-pre-matricula');
})->name('register.pre-matricula');

Route::post('/register/pre-matricula', function () {
    $cpf = preg_replace('/\D+/', '', request('cpf'));
    request()->merge(['cpf' => $cpf]);
    $data = request()->validate([
        'nome' => ['required', 'string', 'max:255'],
        'cpf' => ['required', 'size:11', 'unique:candidatos,cpf'],
    ]);
    $candidato = Candidato::create([
        'nome' => $data['nome'],
        'cpf' => $data['cpf'],
        'local' => 'Mangaratiba',
    ]);

    return redirect()->route('register.pre-matricula')->with('status', 'Pré-matrícula criada com sucesso. Protocolo: '.$candidato->id);
});

// Rotas de Autentica��o API (Consumindo Projeto A)
Route::get('/api/register', [ApiRegisterController::class, 'create'])->name('apiregister');
Route::post('/api/register', [ApiRegisterController::class, 'store'])->name('apiregister.store');
// login api pia
Route::get('/api/login', [ApiLoginController::class, 'create'])->name('register.login');
Route::post('/api/login', [ApiLoginController::class, 'store'])->name('register.login.store');
Route::post('/api/logout', [ApiLoginController::class, 'destroy'])->name('api.logout');

// status da pre-matricula
// Route::get('pre-matricula/status', function () {
//     $matricula = null;

//     // Buscar por protocolo ou CPF
//     if (request('protocolo')) {
//         $matricula = Matricula::with('statusMatricula')
//             ->where('protocolo', request('protocolo'))
//             ->first();
//     } elseif (request('cpf')) {
//         $cpf = preg_replace('/\D+/', '', request('cpf'));
//         $matricula = Matricula::with('statusMatricula')
//             ->whereRaw("REPLACE(REPLACE(REPLACE(cpf_candidato, '.', ''), '-', ''), ' ', '') = ?", [$cpf])
//             ->orderBy('created_at', 'desc')
//             ->first();
//     }

//     // Formatar data de inscrição se existir
//     $dataInscricao = null;
//     if ($matricula && $matricula->data_inscricao) {
//         $dataInscricao = \Carbon\Carbon::parse($matricula->data_inscricao)->format('d/m/Y');
//     }

//     return view('register-pre-matricula-status', [
//         'status' => $matricula && $matricula->statusMatricula
//             ? $matricula->statusMatricula->status_matricula
//             : null,

//     ]);
// })->name('register.pre-matricula.status');

Route::get('pre-matricula/status', [StatusMatriculaController::class, 'index'])->name('register.pre-matricula.status');
Route::post('pre-matricula/confirmar/{id}', [StatusMatriculaController::class, 'confirmar'])->name('pre-matricula.confirmar');
Route::get('pre-matricula/confirmar/{id}', [StatusMatriculaController::class, 'confirmar'])->middleware('signed')->name('pre-matricula.confirmar.get');
Route::post('pre-matricula/enviar-whatsapp/{id}', [StatusMatriculaController::class, 'enviarWhatsapp'])->name('pre-matricula.enviar_whatsapp');
Route::get('pre-matricula/testar-whatsapp/{id}', [StatusMatriculaController::class, 'testarWhatsapp'])
    ->middleware(['auth', 'can:accessAdminPanel'])
    ->name('pre-matricula.testar_whatsapp');
Route::get('pre-matricula/abrir-whatsapp/{id}', [StatusMatriculaController::class, 'abrirWhatsapp'])->name('pre-matricula.abrir_whatsapp');
Route::get('api/matricula/status/{protocolo}', [StatusMatriculaController::class, 'apiStatusByProtocol'])->name('api.matricula.status');

Route::get('transfer/approve/{id}', [TransferController::class, 'approve'])->middleware('signed')->name('transfer.approve');
Route::get('transfer/reject/{id}', [TransferController::class, 'reject'])->middleware('signed')->name('transfer.reject');

// Rotas auxiliares do painel Filament.
Route::middleware(['auth', 'can:accessAdminPanel'])->group(function () {
    Route::get('/admin/transfer/approve/{id}', function ($id) {
        return redirect(URL::signedRoute('transfer.approve', ['id' => $id]));
    })->name('admin.transfer.approve');
    Route::get('/admin/transfer/reject/{id}', function ($id) {
        return redirect(URL::signedRoute('transfer.reject', ['id' => $id]));
    })->name('admin.transfer.reject');
    Route::get('/admin/transfer/approve-direct/{id}', [TransferController::class, 'approveDirect'])->name('admin.transfer.approve-direct');
    Route::get('/admin/transfer/reject-direct/{id}', [TransferController::class, 'rejectDirect'])->name('admin.transfer.reject-direct');
    Route::get('/admin/whatsapp/open/{id}', [StatusMatriculaController::class, 'abrirWhatsapp'])->name('admin.whatsapp.open');
});
