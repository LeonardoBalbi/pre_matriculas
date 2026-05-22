<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Matricula;
use Carbon\Carbon;

class MatriculaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('pt_BR');

        $escolas = [
            1 => 'Escola Municipal Modelo',
            2 => 'Centro Educacional Nova Geração',
        ];

        $turmas = [1, 2];
        $bairros = [1, 2];
        $turmaEspecies = ['BERÇÁRIO A', 'BERÇÁRIO B', 'Nível 1', 'Nível 2'];

        Matricula::withoutEvents(function () use ($faker, $escolas, $turmas, $bairros, $turmaEspecies) {
        for ($i = 0; $i < 30; $i++) {
            $dn = Carbon::now()->subYears($faker->numberBetween(4, 6))->subDays($faker->numberBetween(0, 365));

            $sexo = $faker->randomElement(['masculino', 'feminino']);
            $irmaoCreche = $faker->randomElement(['sim', 'não']);
            $irmaoGemeo = $faker->randomElement(['sim', 'não']);
            $carteiraVacinacao = $faker->randomElement(['sim', 'não']);
            $cartaoSus = $faker->randomElement(['sim', 'não']);
            $bolsaFamilia = $faker->randomElement(['sim', 'não']);
            $cadUnico = $faker->randomElement(['sim', 'não']);
            $vulneravelSocial = $faker->randomElement(['sim', 'não']);
            $portadorDeficiencia = $faker->randomElement(['sim', 'não']);
            $grauParentesco = $faker->randomElement(['pai', 'mãe', 'responsável legal']);

            $escolaId = $faker->randomElement([1, 2]);
            $turmaId = $faker->randomElement($turmas);
            $bairroId = $faker->randomElement($bairros);
            $turmaEspecie = $faker->randomElement($turmaEspecies);

            $nomeCrianca = $faker->firstName($sexo === 'masculino' ? 'male' : 'female') . ' ' . $faker->lastName();
            $nomeResponsavel = $faker->name();

            Matricula::create([
                'protocolo' => (int) (Carbon::now()->format('YmdHis') . sprintf('%03d', $i)),
                'ano_letivo' => 2025,
                'data_nascimento' => $dn->format('Y-m-d'),
                'nome_candidato' => $nomeCrianca,
                'cpf_candidato' => $faker->numerify('###########'),
                'idade' => (string) $dn->diffInYears(Carbon::now()),
                'escola_nome_id' => $escolaId,
                'escola_nome' => $escolas[$escolaId] ?? null,
                'turma_id' => $turmaId,
                'sexo' => $sexo,
                'irmao_creche' => $irmaoCreche,
                'irmao_gemeo' => $irmaoGemeo,
                'nome_irmao_gemeo' => $irmaoGemeo === 'sim' ? ($faker->firstName() . ' ' . $faker->lastName()) : null,
                'carteira_vacinacao' => $carteiraVacinacao,
                'cartao_sus' => $cartaoSus,
                'bolsa_familia' => $bolsaFamilia,
                'cad_unico' => $cadUnico,
                'vulneravel_social' => $vulneravelSocial,
                'portador_deficiencia' => $portadorDeficiencia,
                'deficiencias_tipo' => $portadorDeficiencia === 'sim' ? $faker->numberBetween(1, 3) : null,
                'distrito_id' => 1,
                'endereco' => $faker->streetAddress(),
                'escola_bairro_id' => $bairroId,
                'grau_parentesco' => $grauParentesco,
                'nome_responsavel' => $nomeResponsavel,
                'email_responsavel' => $faker->safeEmail(),
                'data_nasc_responsavel' => Carbon::now()->subYears($faker->numberBetween(25, 45))->format('Y-m-d'),
                'cpf_responsavel' => $faker->numerify('###########'),
                'rg_responsavel' => (string) $faker->numberBetween(1000000, 9999999),
                'mae_menor' => $faker->randomElement(['sim', 'não']),
                'escolaridade_id' => null,
                'tel_fixo_responsavel' => $faker->phoneNumber(),
                'tel_cel_responsavel' => $faker->cellphoneNumber(),
                'pedido_transferencia' => null,
                'aceite_edital' => 's',
                'acao_judicial_candidato' => null,
                'candidato_remanescente' => null,
                'tipo_formulario' => 'online',
                'data_inscricao' => Carbon::now(),
                'data_reat_inscricao' => null,
                'inscricao_reativada' => null,
                'usr_login' => 'seeder',
                'declaro' => true,
                'edital' => true,
                'turma_especie' => $turmaEspecie,
            ]);
        }
        });
    }
}
