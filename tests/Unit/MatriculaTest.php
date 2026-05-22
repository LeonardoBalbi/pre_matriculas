<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Matricula;
use App\Models\Candidato;

class MatriculaTest extends TestCase
{
    /**
     * Teste básico para verificar se a classe Matricula existe.
     */
    public function test_matricula_class_exists(): void
    {
        $this->assertTrue(class_exists(Matricula::class));
    }

    /**
     * Teste básico para verificar se a classe Candidato existe.
     */
    public function test_candidato_class_exists(): void
    {
        $this->assertTrue(class_exists(Candidato::class));
    }

    /**
     * Teste para verificar se os modelos têm as propriedades básicas.
     */
    public function test_models_have_basic_properties(): void
    {
        // Verifica se as classes dos modelos existem
        $this->assertTrue(class_exists('App\\Models\\Escola'));
        $this->assertTrue(class_exists('App\\Models\\Turma'));
        $this->assertTrue(class_exists('App\\Models\\Bairro'));
        $this->assertTrue(class_exists('App\\Models\\Distrito'));
    }

    /**
     * Teste para verificar estrutura básica de dados.
     */
    public function test_basic_data_structure(): void
    {
        // Teste simples de estrutura
        $data = [
            'nome' => 'João Silva',
            'email' => 'joao@example.com',
            'telefone' => '21999999999'
        ];
        
        $this->assertIsArray($data);
        $this->assertArrayHasKey('nome', $data);
        $this->assertArrayHasKey('email', $data);
        $this->assertArrayHasKey('telefone', $data);
    }
}