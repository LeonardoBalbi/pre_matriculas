<?php

require_once 'vendor/autoload.php';

use App\Models\Matricula;

// Teste simples para verificar se o campo turma_especie está sendo salvo
try {
    $matricula = new Matricula();
    $matricula->turma_especie = 'BERÇÁRIO A';
    $matricula->nome_candidato = 'Teste Turma';
    $matricula->cpf_candidato = '12345678901';
    $matricula->data_nascimento = '2023-01-01';
    $matricula->sexo = 'masculino';
    $matricula->escola_nome_id = 1;
    $matricula->carteira_vacinacao = 'sim';
    $matricula->nome_responsavel = 'Responsável Teste';
    $matricula->data_nasc_responsavel = '1990-01-01';
    $matricula->cpf_responsavel = '12345678902';
    $matricula->email_responsavel = 'teste@teste.com';
    $matricula->tel_cel_responsavel = '1234567890';
    $matricula->declaro = true;
    $matricula->edital = true;
    $matricula->ano_letivo = 2025;
    
    echo "Tentando salvar...\n";
    $matricula->save();
    
    echo "Salvo com sucesso!\n";
    echo "ID: " . $matricula->id . "\n";
    echo "Turma espécie: " . $matricula->turma_especie . "\n";
    echo "Protocolo: " . $matricula->protocolo . "\n";
    
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
} 