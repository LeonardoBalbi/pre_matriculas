<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Vagas;
use App\Models\Candidato;
use App\Models\CandidatoXp;
use App\Models\VagasXp;
use App\Models\VagasXpPlus;
use App\Http\Requests\CandidatoRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;


class ProcessoSeletivoController extends Controller
{
    public function index()
    {
        $vagas = Vagas::select('id', 'num_edital', 'titulo')->where('status', 'publicado')->get();

       
        // return Inertia::render('ProcessoFechado');
        return Inertia::render('ProcessoSeletivo' , ['vagas' => $vagas]);
    }

    public function set_vagas($id){
        $vaga = Vagas::find($id)->select('id')->first();
        $vagasXp = VagasXp::where('id_vagas', $vaga->id)->select('id', 'titulo')->get();     

        foreach($vagasXp as $key => $value){
            $vagasXp[$key]['plus'] = VagasXpPlus::where('id_vagas_xps', $value['id'])->select('id', 'titulo')->get();
        }         

        return response()->json($vagasXp);
        // dd($vagasXp);
    }


    public function store(CandidatoRequest $request){
        
        $candidato = Candidato::create([
            'id_vagas' => $request->id_vagas,
            'nome' => $request->nome,
            'cpf' => $request->cpf,
             'local' => $request->local,
            'data_nasc' => $request->data_nasc,
            'cor_raca' => $request->cor_raca,
            'nacionalidade' => $request->nacionalidade,
            'naturalidade' => $request->naturalidade,
            'sexo' => $request->sexo,
            'estado_civil' => $request->estado_civil,
            'deficiencia' => $request->deficiencia,
            'tipo_deficiencia' => $request->tipo_deficiencia,
            'nome_pai' => $request->nome_pai,
            'nome_mae' => $request->nome_mae,
            'escolaridade' => $request->escolaridade,
            'rg' => $request->rg,
            'rg_emissor' => $request->rg_emissor,
            'rg_estado' => $request->rg_estado,
            'rg_data_emissao' => $request->rg_data_emissao,
            'cep' => $request->cep,
            'endereco' => $request->endereco,
            'numero' => $request->numero,
            'complemento' => $request->complemento,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'uf' => $request->uf,
            'telefone' => $request->telefone,
            'celular' => $request->celular,
            'email' => $request->email,    
        ]);

        $id_cand = $candidato->id;     
        $id_vaga_t = $request->id_vagas;
        
        $vaga = Vagas::find($id_vaga_t)->select('id')->first();
        $vagasXp = VagasXp::where('id_vagas', $vaga->id)->select('id', 'titulo')->get();     

        foreach($vagasXp as $key => $value){
            $vagasXp[$key]['plus'] = VagasXpPlus::where('id_vagas_xps', $value['id'])->select('id', 'titulo')->get();
        }    

        Inertia::share('candidato', $id_cand);
        Inertia::share('vagasXp', $vagasXp); 

        $id_candidato = base64_encode($id_cand);

        // return Inertia::render('ProcessoSeletivoXp', ['candidato' => $id_cand, 'vagasXp' => $vagasXp]);
        return Inertia::render('Sucesso', ['candidato' => $id_candidato]);
    }

    public function storexp(Request $request){


        $data = $request->all(); // Substitua isso pela forma como você recebe o array

        // Extraindo o id_candidato
        $id_candidato = $data['id'];

        // Removendo a chave 'id' do array
        unset($data['id']);

        $total_pontos = 0;

        // Percorrendo as chaves e valores restantes no array
        foreach ($data as $id_vagas_xp => $id_vagas_xp_plus) {
            // Criando e salvando o registro no banco de dados
            $registro = new CandidatoXp();
            $registro->id_candidato = $id_candidato;
            $registro->id_vagas_xp = $id_vagas_xp;
            $registro->id_vagas_xp_plus = $id_vagas_xp_plus;
            $registro->save();

            $vagas_xp_plus = VagasXpPlus::find($id_vagas_xp_plus);
            $total_pontos += $vagas_xp_plus->pontos;

        }

        $candidato = Candidato::find($id_candidato);
        $candidato->pontos = $total_pontos;
        $candidato->save();


        $id_candidato = base64_encode($id_candidato);

        Inertia::share('candidato', $id_candidato);


        return Inertia::render('Sucesso', ['candidato' => $id_candidato]);
        // return redirect()->route('processo-seletivo.sucesso', ['candidato' => $id_candidato]);
        
        
    }

    public function sucesso (){
        return Inertia::render('Sucesso');
    }

    public function comprovante($id, $tipo = 'd')
    {
        $id = base64_decode($id);

        $candidato = Candidato::find($id);
        $vaga = Vagas::find($candidato->id_vagas);

        #pegar no banco de dados (candidatos xps) e (vagas xps) e (vagas xps plus)
        $candidato_xps = DB::table('candidato_xps')->where('id_candidato', $candidato->id)
        ->join('vagas_xps', 'candidato_xps.id_vagas_xp', '=', 'vagas_xps.id')
        ->join('vagas_xp_pluses', 'candidato_xps.id_vagas_xp_plus', '=', 'vagas_xp_pluses.id')
        ->select('vagas_xps.titulo as titulo', 'vagas_xp_pluses.titulo as xp_plus', 'vagas_xp_pluses.pontos as pontos')
        ->get();
       
        // dd($candidato_xps);

        $pdf = PDF::loadView('pdfs.comprovante.processo-seletivo', compact('candidato', 'vaga', 'candidato_xps'));

        $nome_file = "PROCESSO SIMPLIFICADO Nº 002/2025 - " . mb_strtoupper($candidato->nome, 'UTF-8') . ".pdf";

        if($tipo == 'd'){
            return $pdf->download($nome_file);
        }else{
            return $pdf->stream($nome_file);
        }
   
    }


    public function consulta()
    {
        return Inertia::render('ProtocoloInscricao');
    }


    public function checkconsulta(Request $request)
   {
        dd($request->all());        
    }
}
