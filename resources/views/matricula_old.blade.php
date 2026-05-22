
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <title>Matricula</title>
</head>
<div class="bg-gray-100 p-8 bg-blue-300 ">


  <h1 class="text-5xl text-center font-bold mt-1 text-white shadow-xl  ">Pré-Matrícula</h1>
  <hr class="h-px my-4 bg-gray-900 border-0 bg-opacity-50">
  <div class="p-3">
  <p class="text-gray-600 mb-16 font-bold p-2  text-center ">Preencha todos os campos obrigatórios do formulário. </p>
  <p class="text-gray-600 font-bold mb-16 p-1 -mt-20  text-center "> Ao concluir, imprima o Protocolo e os Anexos necessários.</p>
 </div> 
  <div class="max-w-3xl mx-auto">

      <div>
        <legend class="text-lg text-center font-semibold mb-4">Dados Pessoais</legend>
      </div>

    <!-- <form class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-200 p-14 -m-16  bg-opacity-50 rounded-md shadow-xl  "> -->
  <form method="post" action="{{ url('matricula')}}" class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-200 p-2 -m-16 bg-opacity-50 rounded-md shadow-xl ">
    @csrf
    
      <!-- Primeira Coluna -->

      
    <fieldset>
      
      <div class="mb-4">
          <label for="data_nascimento" class="block text-sm font-medium text-gray-600">Data de Nascimento:</label>
          <input type="date" id="data_nascimento" name="data_nascimento" onchange="calcularIdade()" class="mt-1 p-2 w-full border rounded-md" required>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-600">Idade na Data Atual:</label>
        <input type="text" id="idade" name="idade" class="mt-1 p-2 w-full border rounded-md" readonly>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-600">Idade na Data Base 31/03/2023:</label>
        <input type="text" id="idade_data_corte" name="idade_data_corte" class="mt-1 p-2 w-full border rounded-md" readonly>
      </div>

      <div class="mb-4">
        <label for="nome_candidato" class="block text-sm font-medium text-gray-600">Nome do Candidato:</label>
        <input type="text" id="nome_candidato" name="nome_candidato"  class="mt-1 p-2 w-full border rounded-md">
      </div>

      <div class="mb-4">
        <label for="cpf_candidato" class="block text-sm font-medium text-gray-600">CPF da Criança:</label>
        <input type="number" id="cpf_candidato" name="cpf_candidato"  class="mt-1 p-2 w-full border rounded-md">
      </div>

      <div class="mb-4">
      <label class="block text-sm font-medium text-gray-600">Sexo:</label>
      <select name="sexo"  class="mt-1 p-2 w-full border rounded-md">
        <option value="">Selecionar uma opção</option>
        <option value="femenino">Femenino</option>
        <option value="masculino">Masculino</option>
        <option value="outros">Outros</option>
      </select>
      </div>

      <div class="mb-4">
      <label class="block text-sm font-medium text-gray-600">Possui irmão matriculado em CEIM do município:</label>
      <select name="irmao_creche"  class="mt-1 p-2 w-full border rounded-md">
        <option value="">Selecionar uma opção</option>
        <option value="sim">Sim</option>
        <option value="não">Não</option>
      </select>
      </div>

      <div class="mb-4">
      <label class="block text-sm font-medium text-gray-600">Possui irmão gêmeo:</label>
      <select name="irmao_gemeo" class="mt-1 p-2 w-full border rounded-md">
        <option value="">Selecionar uma opção</option>
        <option value="sim">Sim</option>
        <option value="não">Não</option>
      </select>
      </div>

      <div class="mb-4">
      <label class="block text-sm font-medium text-gray-600">Faz parte do Programa Bolsa Família:</label>
      <select name="bolsa_familia" class="mt-1 p-2 w-full border rounded-md">
        <option value="">Selecionar uma opção</option>
        <option value="sim">Sim</option>
        <option value="não">Não</option>
      </select>
      </div>

      <div class="mb-4">
      <label class="block text-sm font-medium text-gray-600">Possui Vulnerabilidade Social e Econômica:</label>
      <select name="vulneravel_social" class="mt-1 p-2 w-full border rounded-md">
        <option value="">Selecionar uma opção</option>
        <option value="sim">Sim</option>
        <option value="não">Não</option>
      </select>
      </div>
    </fieldset>
    <fieldset>
      
        
      <!-- Segunda Coluna -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-600">Distrito:</label>
        <select name="distrito" class="mt-1 p-2 w-full border rounded-md">
          <option value="">Selecionar uma opção</option>
          @foreach ($distritos as $distrito )
            <option value="{{ $distrito->id }}">{{ $distrito->distrito }}</option>            
          @endforeach
        </select>
      </div>

      <div class="mb-4">
        <label for="endereco" class="block text-sm font-medium text-gray-600" name="endereco">Endereço:</label>
        <input type="text" class="mt-1 p-2 w-full border rounded-md">
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-600">Bairro:</label>
        <select name="escola_bairro_id" class="mt-1 p-2 w-full border rounded-md">
          <option value="">Selecionar uma opção</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
        </select>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-600">Escola:</label>
        <select name="escola_nome_id" class="mt-1 p-2 w-full border rounded-md">
        <option value="">Selecionar uma opção</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">3</option>
        </select>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-600">Turma:</label>
        <select class="mt-1 p-2 w-full border rounded-md">
          <option value="">Selecionar uma opção</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
        </select>
      </div>

      <div class="mb-4">
      <label class="block text-sm font-medium text-gray-600">Possui alguma Deficiência:</label>
      <select name="portador_deficiencia" class="mt-1 p-2 w-full border rounded-md">
        <option value="">Selecionar uma opção</option>
        <option value="sim">Sim</option>
        <option value="não">Não</option>
      </select>
      </div>

      <div class="mb-4">
      <label class="block text-sm font-medium text-gray-600">Deficiências Tipo:</label>
      <div class="flex">
      <select name="deficiencias_tipo" class="mt-1 p-2 w-full border rounded-md">
        <option value="">Selecionar uma opção</option>
        <option value="não se aplica">Não se aplica</option>
        <option value="altas habilidades/superdotação">Altas Habilidades/Superdotação</option>
        <option value="autismo clássico">Autismo Clássico</option>
        <option value="autismo infantil">Autismo Infantil</option>
        <option value="baixa visão">Baixa Visão</option>
        <option value="cegueira">Cegueira</option>
        <option value="condutas típicas">Condutas Típicas</option>
        <option value="deficiência auditiva">Deficiência Auditiva</option>
        <option value="deficiência física">Deficiência Física</option>
        <option value="deficiência intelectual">Deficiência Intelectual</option>
        <option value="deficiência múltipla">Deficiência Múltipla</option>
        <option value="deficiência visual e auditiva">Deficiência Visual e Auditiva</option>
        <option value="deficiência visual parcial">Deficiência Visual Parcial</option>
        <option value="deficiência visual total">Deficiência Visual Total</option>
        <option value="epidermólise bolhosa">Epidermólise Bolhosa</option>
        <option value="síndrome de asperger">Síndrome de Asperger</option>
        <option value="síndrome de down">Síndrome de Down</option>
        <option value="síndrome de rett">Síndrome de Rett</option>
        <option value="surdez">Surdez</option>
        <option value="surdez leve ou moderada">Surdez Leve ou Moderada</option>
        <option value="surdez severa ou profunda">Surdez Severa ou Profunda</option>
        <option value="surdocegueira'">Surdocegueira</option>
        <option value="transtorno desintegrativo da infância">Transtorno Desintegrativo da Infância</option>
        <option value="outros">Outros</option>
      </select>
      </div>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-600">Nome completo do Irmão Gemeo:</label>
        <input type="text" name="nome_irmao_gemeo" id="nome_irmao_gemeo" class="mt-1 p-2 w-full border rounded-md">
      </div>

      
      <div class="mb-4">
      <label class="block text-sm font-medium text-gray-600">Faz parte do Cadastro Único:</label>
      <select name="cad_unico" class="mt-1 p-2 w-full border rounded-md">
        <option value="">Selecionar uma opção</option>
        <option value="sim">Sim</option>
        <option value="não">Não</option>
      </select>
      </div>


      <div class="mb-4">
      <label class="block text-sm font-medium text-gray-600">Carteira de Vacinação em Dia:</label>
      <select name="carteira_vacinacao" class="mt-1 p-2 w-full border rounded-md">
        <option value="">Selecionar uma opção</option>
        <option value="sim">Sim</option>
        <option value="não">Não</option>
      </select>
      </div>
    
    </fieldset>

    <filedset>
      <div>
        <legend class="text-lg text-center font-semibold mb-4">Dados do Responsável</legend>
      </div>
      
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-600">Grau de Parentesco:</label>
        <select class="mt-1 p-2 w-full border rounded-md">
          <option value="">Selecionar uma opção</option>
          <option value="mãe">Mãe</option>
          <option value="pai">Pai</option>
          <option value="responsável legal">Responsavel Legal</option>
        </select>
      </div>

      <div class="mb-4">
        <label for="nome_responsavel" class="block text-sm font-medium text-gray-600">Nome do Responsável:</label>
        <input type="text" nome="nome_responsavel" class="mt-1 p-2 w-full border rounded-md">
      </div>
    
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-600">Data de Nascimento do Responsável:</label>
        <input type="date" name="data_nasc_responsavel" class="mt-1 p-2 w-full border rounded-md">
      </div>

      <div class="mb-4">
      <label class="block text-sm font-medium text-gray-600">Mãe Menor de Idade:</label>
      <select name="mae_menor" class="mt-1 p-2 w-full border rounded-md">
        <option value="">Selecionar uma opção</option>
        <option value="sim">Sim</option>
        <option value="não">Não</option>
      </select>
      </div>
    </filedset>
    <fieldset>
      <div>
        <legend class="text-lg text-center font-semibold mb-4">.</legend>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-600">CPF do Responsável:</label>
        <input type="number" name="cpf_responsavel" class="mt-1 p-2 w-full border rounded-md">
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-600">Telefone Celular:</label>
        <input type="number" name="tel_cel_responsavel" class="mt-1 p-2 w-full border rounded-md">
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-600">Telefone para recado:</label>
        <input type="number" name="tel_fixo_responsavel" class="mt-1 p-2 w-full border rounded-md">
      </div>

      <div class="mb-4">
        <label for="email" id="email" class="block text-sm font-medium text-gray-600">E-mail do Responsável:</label>
        <input type="text" name="email_responsavel" class="mt-1 p-2 w-full border rounded-md">
      </div>

    </fieldset>

    <label for="checkbox1">
      <input type="checkbox" id="checkbox1" name="checkbox1"> Declaro sob as penas da lei, que os dados constantes neste Requerimento de inscrição são verídicos e concordo com os termos e condições estipulados.
    </label>
        <br>
    <label for="checkbox2">
      <input type="checkbox" id="checkbox2" name="checkbox2">  Concordo com os termos e condições estipulados no edital
    </label>
  
      
    <div class="form-group col-span-2 text-center pt-10 ">
      
      <button type="submit" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-2xl px-16 py-2.5 text-center me-2 mb-2 ">enviar</button>

    </div>
    
  
  </div>


  

</div>
</html>