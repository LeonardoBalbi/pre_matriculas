<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classificado;

class ClassificadoController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Matricula::where('situacao_matricula', 5);

        if ($request->filled('nome')) {
            $query->where('nome_candidato', 'like', '%' . $request->nome . '%');
        }

        $matriculas = $query
            ->orderBy('nome_candidato')
            ->paginate(5)
            ->appends($request->query());

        // Retornar apenas os campos principais para o classificados
        $result = $matriculas->through(function($matricula) {
            return [
                'protocolo' => $matricula->protocolo,
                'nome_candidato' => $matricula->nome_candidato,
                'ano_letivo' => $matricula->ano_letivo,
            ];
        });

        return response()->json([
            'data' => $result,
            'current_page' => $matriculas->currentPage(),
            'last_page' => $matriculas->lastPage(),
            'per_page' => $matriculas->perPage(),
            'total' => $matriculas->total(),
        ]);
    }
}
