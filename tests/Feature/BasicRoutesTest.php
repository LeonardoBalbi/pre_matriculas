<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BasicRoutesTest extends TestCase
{
    /**
     * Teste para verificar se a página inicial carrega corretamente.
     */
    public function test_homepage_loads_successfully(): void
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
    }

    /**
     * Teste para verificar se a rota de matrícula existe.
     */
    public function test_matricula_route_exists(): void
    {
        $response = $this->get('/matricula');
        
        // Deve retornar 200 (sucesso) ou 302 (redirecionamento)
        $this->assertContains($response->getStatusCode(), [200, 302]);
    }

    /**
     * Teste para verificar se a rota de processo seletivo redireciona corretamente.
     */
    public function test_processo_seletivo_redirects(): void
    {
        $response = $this->get('/processo-seletivo');
        
        $response->assertStatus(302);
        $response->assertRedirect('https://mangaratiba.rj.gov.br/novoportal/processos-seletivos.php');
    }

    /**
     * Teste para verificar se a rota de pré-matrícula redireciona corretamente.
     */
    public function test_pre_matricula_loads_successfully(): void
    {
        $response = $this->get('/pre-matricula');
        
        $response->assertStatus(200);
    }

    /**
     * Teste para verificar se a API de status de manutenção funciona.
     */
    public function test_maintenance_status_api(): void
    {
        $response = $this->get('/manutencao-status');
        
        $response->assertStatus(200);
        $response->assertJsonStructure(['ativo']);
    }
}
