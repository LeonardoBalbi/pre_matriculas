<?php

namespace Rhyltonn\SomaPontosFields;


use Laravel\Nova\Fields\Text;
use App\Models\CandidatoXp;
use App\Models\VagasXpPlus;
use App\Models\Candidato;

class SomaPontosFields extends Text
{
    
    public function withCalculo($candidato_id)
    {
        return $this->resolveUsing(function () use ($candidato_id) {
            $candidatoXp = CandidatoXp::where('id_candidato', $candidato_id)->get();
            $pontos = 0;
            foreach ($candidatoXp as $candidato) {

                $candidatoXpPlus = VagasXpPlus::where('id', $candidato->id_vagas_xp_plus)->first();

                $pontos += $candidatoXpPlus->pontos;
            }

            #update Candidato coluna pontos
            $candidato = Candidato::where('id', $candidato_id)->first();
            $candidato->pontos = $pontos;
            $candidato->save();

            return $pontos;
        });
    }
    
}
