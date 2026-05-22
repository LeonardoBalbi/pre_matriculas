<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Pré-Matrícula</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class=" bg-opacity-95 font-sans text-base ">

    <h1 class="text-3xl font-bold text-center p-8">Pré-Matrícula</h1>
    <p class="text-center " >Preencha todos os campos obrigatórios do formulário. Ao concluir, imprima o Protocolo e os Anexos necessários.</p>

    <div class="bg-white rounded shadow-md p-8">
    <h1 class="text-2xl font-bold mb-6">Formulário de Inscrição de Pré-Matrícula</h1>

    <form action="#" method="post" class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <!-- <div class="container mx-auto p-4 bg-white rounded shadow-md">

        <h1 class="text-2xl mt-3 text-center">Formulário de Inscrição de Pré-Matrícula</h1>

        <form action="#" method="post" class="grid grid-cols-1 md:grid-cols-2 gap-4 bg p-12 m-10 bg-blue-500 bg-opacity-50   rounded-f"> -->

            <div class="form-group mb-4 flex flex-col md:flex-row">
                <label for="dataNascimento" class="block w-full md:w-1/4 mb-2 md:mb-0 pr-0 md:pr-4">Data de Nascimento:</label>
                <input type="date" id="dataNascimento" name="dataNascimento" onchange="calcularIdade()"
                    required
                    class="w-full md:w-1/2 p-2 border border-gray-300 rounded">
            </div>
         

            <!-- ... Outros campos ... -->

            <div class="form-group mb-2 flex flex-col md:flex-row">
                <label for="idadeAtual" class="block w-full mb-1    md:w-1/4 h-2 mb-4 md:mb-2 pr-0 md:pr-4 ">Idade na Data Atual:</label>
                <input type="text" id="idadeAtual" name="idadeAtual" readonly
                    class="w-full md:w-1/2 p-2 border border-gray-300 rounded">
            </div>
            <!-- <div class="form-group mb-4 flex flex-col md:flex-row">
                <label for="idadeBase" class="block w-full md:w-1/2 mb-2 md:mb-0 pr-0 md:pr-4">Idade na Data Base 31/03/2023:</label>
                <input type="text" id="idadeBase" name="idadeBase" required
                    class="w-full md:w-1/2 p-2 border border-gray-300 rounded">
            </div> -->


            <!-- ... Outros campos ... -->

            <div class="form-group mb-4 flex flex-col md:flex-row">
                <label for="nomeCandidato" class="block w-full md:w-1/4 mb-2 md:mb-0 pr-0 md:pr-4">Nome do Candidato:</label>
                <input placeholder=" Digite o Nome Candidato" type="text" id="nomeCandidato" name="nomeCandidato" required
                    class="w-full md:w-1/2 p-2 border border-gray-300 rounded">
            </div>


   


            <!-- ... Outros campos ... -->

            <div class="form-group mb-4 flex flex-col md:flex-row">
                <label for="sexo" class="block w-full md:w-1/4 mb-2 md:mb-0 pr-0 md:pr-4">Sexo:</label>
                <div class="flex items-center w-full md:w-1/2 space-x-4">
                    <input type="radio" id="sexoM" name="sexo" value="Masculino" required
                        class="border border-gray-300 rounded">
                    <label for="sexoM">Masculino</label>
                    <input type="radio" id="sexoF" name="sexo" value="Feminino" required
                        class="border border-gray-300 rounded">
                    <label for="sexoF">Feminino</label>
                </div>
            </div>

        
            <!-- ... Outros campos ... -->

          
            <!-- ... Outros campos ... -->

            <div class="form-group mb-4 flex flex-col md:flex-row">
                <label for="irmaoMatriculado" class="block w-full md:w-1/2 mb-2 md:mb-0 pr-0 md:pr-4">Possui irmão matriculado em CEIM do município:</label>
                <select id="irmaoMatriculado" name="irmaoMatriculado" required class="w-full md:w-1/2 p-2 border border-gray-300 rounded">
                    <option value="Selecione uma Opção">Selecione uma Opção</option>
                    <option value="Sim">Sim</option>
                    <option value="Não">Não</option>
                </select>
            </div>

            <!-- ... Outros campos ... -->


            <div class="form-group mb-4 flex flex-col md:flex-row">
                <label for="deficiencia" class="block w-full md:w-1/4 mb-2 md:mb-0 pr-0 md:pr-4">Possui alguma Deficiência?</label>
                <select id="deficiencia" name="deficiencia" required class="w-full md:w-1/2 p-2 border border-gray-300 rounded">
                    <option value="Selecione uma Opção">Selecione uma Opção</option>
                    <option value="Sim">Sim</option>
                    <option value="Não">Não</option>
                </select>
            </div>

            <div class="form-group mb-4 flex flex-col md:flex-row">
                <label for="tipoDeficiencia" class="block w-full md:w-1/4 mb-2 md:mb-0 pr-0 md:pr-4">Informe o tipo de Deficiência:</label>
                <input placeholder=" Informe o tipo de Deficiência:" type="text" id="tipodeficiencia" name="tipodeficiencia" required
                class="w-full md:w-1/2 p-2 border border-gray-300 rounded">
              </div>


              <div class="form-group mb-4 flex flex-col md:flex-row">
                <label for="irmaogemeo" class="block w-full md:w-1/4 mb-2 md:mb-0 pr-0 md:pr-4">Possui Irmao gemeo:</label>
                <select id="irmaogemeo" name="irmaogemeo" required class="w-full md:w-1/2 p-2 border border-gray-300 rounded">
                    <option value="Selecione uma Opção">Selecione uma Opção</option>
                    <option value="Sim">Sim</option>
                    <option value="Não">Não</option>
                </select>
              </div>


              <div class="form-group mb-4 flex flex-col md:flex-row">
                <label for="bolsafamilia" class="block w-full   md:w-1/4 mb-2 h-1/2 md:mb-0 pr-0 md:pr-4">Faz parte do Programa Bolsa Família?</label>
                <select id="bolsafamilia" name="bolsafamilia" required class="w-full md:w-1/2 p-2 border border-gray-300 rounded">
                    <option value="Selecione uma Opção">Selecione uma Opção</option>
                    <option value="Sim">Sim</option>
                    <option value="Não">Não</option>
                </select>
              </div>
              
              <div class="form-group mb-4 flex flex-col md:flex-row">
                <label for="cadastroUnico" class="block w-full md:w-1/4 mb-2 md:mb-0 pr-0 md:pr-4">Faz parte do Cadastro Unico?</label>
                <select id="cadastroUnico" name="cadastroUnico" required class="w-full md:w-1/2  h-1/2 p-2 border border-gray-300 rounded">
                    <option value="Selecione uma Opção">Selecione uma Opção</option>
                    <option value="Sim">Sim</option>
                    <option value="Não">Não</option>
                </select>
              </div>

              <div class="form-group mb-4 flex flex-col md:flex-row">
                <label for="vulnerabilidade " class="block w-full md:w-1/4 h-1/2 mb-2 md:mb-0 pr-0 md:pr-4">Possui Vulnerabilidade Social e Econômica:</label>
                <select id="vulnerabilidade" name="vulnerabilidade" required class="w-full md:w-1/2 h-1/2 p-2 border border-gray-300 rounded">
                    <option value="Selecione uma Opção">Selecione uma Opção</option>
                    <option value="Sim">Sim</option>
                    <option value="Não">Não</option>
                </select>
              </div>

              <div class="form-group mb-4 flex flex-col md:flex-row">
                <label for="vacinação" class="block w-full md:w-1/4 mb-2 md:mb-0 pr-0 md:pr-4">Carteira de Vacinação em Dia:</label>
                <select id="vacinação" name="vacinação" required class="w-full md:w-1/2 h-1/2 p-2 border border-gray-300 rounded">
                    <option value="Selecione uma Opção">Selecione uma Opção</option>
                    <option value="Sim">Sim</option>
                    <option value="Não">Não</option>
                </select>
              </div>
              

              <div class="form-group mb-4 flex flex-col md:flex-row">
                <label for="estado" class="block w-full md:w-1/4 mb-2 md:mb-0 pr-0 md:pr-4">estado:</label>
                <input type="text" id="estado" name="estado" required value="RJ - Rio de Janeiro" readonly
                    class="w-full md:w-1/2 p-2 border border-gray-300 rounded">
            </div>

            <div class="form-group mb-4 flex flex-col md:flex-row">
                <label for="município" class="block w-full md:w-1/4 mb-2 md:mb-0 pr-0 md:pr-4">Município:</label>
                <input type="text" id="município" name="município" required value="Mangratiba" readonly
                    class="w-full md:w-1/2 p-2 border border-gray-300 rounded">
            </div>

            <div class="form-group mb-4 flex flex-col md:flex-row">
                <label for="distrito" class="block w-full md:w-1/4 mb-2 md:mb-0 pr-0 md:pr-4">Distrito:</label>
                <input type="text" id="distrito" name="distrito" required 
                    class="w-full md:w-1/2 p-2 border border-gray-300 rounded">
            </div>

            <div class="form-group mb-4 flex flex-col md:flex-row">
                <label  for="endereço" class="block w-full md:w-1/4 mb-2 md:mb-0 pr-0 md:pr-4">Endereço:</label>
                <input placeholder=" Digite o Endereço"  type="text" id="endereço" name="endereço" 
                    class="w-full md:w-1/2 p-2 border border-gray-300 rounded">
            </div>

            <div class="form-group mb-4 flex flex-col md:flex-row">
                <label  for="bairro" class="block w-full md:w-1/4 mb-2 md:mb-0 pr-0 md:pr-4">Bairro:</label>
                <input placeholder=" Digite o bairro"  type="text" id="bairro" name="bairro" 
                    class="w-full md:w-1/2 p-2 border border-gray-300 rounded">
            </div>

            <div class="form-group mb-4 flex flex-col md:flex-row">
                <label for="turma" class="block w-full md:w-1/4 mb-2 md:mb-0 pr-0 md:pr-4">Turma</label>
                <select id="turma" name="turma" required class="w-full md:w-1/2  p-2 border border-gray-300 rounded">
                    <option value="Selecione uma Opção">Selecione uma Opção</option>
                    <option value="Sim">Sim</option>
                    <option value="Não">Não</option>
                </select>
              </div>

              <div class="form-group mb-4 flex flex-col md:flex-row">
                <label for="parentesco " class="block w-full md:w-1/4  mb-2 md:mb-0 pr-0 md:pr-4">Grau de Parentesco</label>
                <select id="parentesco" name="parentesco" required class="w-full md:w-1/2  p-2 border border-gray-300 rounded">
                    <option value="Selecione uma Opção">Selecione uma Opção</option>
                    <option value="pai">Pai</option>
                    <option value="mae">Mae</option>
                    <option value="resposavel">responsavel legal</option>
                </select>
              </div>

              <div class="form-group mb-4 flex flex-col md:flex-row">
                <label for=" responsavel " class="block w-full md:w-1/4  mb-2 md:mb-0 pr-0 md:pr-4">Nome do Responsavel</label>
                <input placeholder=" Nome do Responsavel"  type="text" id="responsavel" name="responsavel" 
                    class="w-full md:w-1/2 p-2 border border-gray-300 rounded">
              </div>


              <div class="form-group mb-4 flex flex-col md:flex-row">
                <label for="dataNascimentores" class="block w-full md:w-1/4 mb-2 md:mb-0 pr-0 md:pr-4">Data de Nascimento do Responsanvel:</label>
                <input type="date" id="dataNascimentores" name="dataNascimento" onchange="calcularIdade()"
                    required
                    class="w-full h-10 md:w-1/2 p-2 border border-gray-300 rounded">
            </div>


            <div class="form-group mb-4 flex flex-col md:flex-row">
                <label for=" responsavelCPF " class="block w-full md:w-1/4  mb-2 md:mb-0 pr-0 md:pr-4">CPF do Responsavel</label>
                <input placeholder=" CPF do Responsavel"  type="text" id="responsavelCPF" name="responsavelCPF" 
                    class="w-full h-10 md:w-1/2 p-2 border border-gray-300 rounded">
              </div>


              <div class="form-group">
                <label for=">Telefone_Celular:">Telefone Celular:</label>
                <input type="text" id="distrito" name="distrito" required>
            </div>
            <div class="form-group">
                <label for=">E-mail_responsável::">E-mail do responsável:</label>
                <input type="text" id="distrito" name="distrito" required>
            </div>

            <div class="form-group">
                <label for="Maemenor">Mãe Menor de Idade:
                </label>
                <select id="Maemenor" name="vulnerabilidade" required>
                    <option value="Selecione uma Opção">Selecione uma Opção</option>
                    <option value="sim">sim</option>
                    <option value="nao">nao</option>

                </select>
            </div>


            <div class="form-group col-span-2 text-center pt-10">
                <input type="submit" value="Enviar"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer">
            </div>
       
            </div>

            <!-- Botão de Envio -->
           
        </form>
    </div>

    

</body>

</html>
