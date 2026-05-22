<template>
<div>
  <Preloader v-if="showPreloader" />
  <div v-show="!showPreloader" class="py-5 px-2 min-h-screen" style="background-image: linear-gradient(225deg,#429edc,#00629e);" >
     <h1 class="text-5xl text-center font-bold mt-1 text-white shadow-xl  ">Pré-Matrícula</h1>
     <div >
        <img class="h-20 mx-auto p-2" src="/img/smeel-branco.png" alt="">
    </div>
  <div class="p-1">
  <p class="text-white mb-16 font-bold p-2  text-center ">Preencha todos os campos obrigatórios do formulário. </p>
  <p class="text-white font-bold mb-5 p-1 -mt-20  text-center "> Ao concluir, imprima o Protocolo e os Anexos necessários.</p>
 </div>
  <div class="max-w-3xl mx-auto">
    <div class="bg-gray-200 rounded-md shadow-xl bg-opacity-50">
      <div v-if="form_sucesso">

            <div class="p-20">
              <h1 class="text-center font-medium mb-4 mx-auto text-white">PARABÉNS</h1>

                <img src="/img/check.png" alt="" class="h-20 mx-auto">

                <h1 class="mx-auto text-center p-5 text-white">INSCRIÇÃO PRE-MATÍCULA CONCLUÍDA COM SUCESSO!</h1>


                <div class="flex items-center justify-center "> <!-- Ajuste a altura conforme necessário -->
                  <div class="flex justify-center w-60">
                      <a :href="route('matricula.comprovante', [candidato, 'd'])">
                          <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                              <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z"/></svg>
                              <span>Download</span>
                          </button>
                      </a>
                      &nbsp;
                      <a :href="route('matricula.comprovante', [candidato, 'p'])" target="_blank">
                          <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                              <span>Imprimir</span>
                          </button>
                      </a>
                  </div>
              </div>

            </div>

      </div>
      <div v-if="!form_sucesso">
          <form @submit.prevent="submit()" >

            <div class="w-full pt-5">
                <legend class="text-lg text-center font-semibold mb-4 text-white">Dados do Candidato</legend>
            </div>

            <div class="md:grid grid-cols-2 md:p-10 p-5 gap-4"> <!-- Inicio -->

              <div class="mb-4">
                  <label for="data_nascimento" id="data_nascimento" class="block text-sm font-medium text-gray-600">Data de Nascimento:</label>
                  <input type="date" id="data_nascimento" v-model="matricula.data_nascimento" class="mt-1 p-2 w-full border rounded-md" required>
                  <div style="color: red;" v-if="errors.data_nascimento">{{ errors.data_nascimento[0] }}</div>
                  <div style="color: rgb(255, 255, 255);" v-if="aviso_data_corte != ''">{{ aviso_data_corte }}</div>
              </div>

              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600">Idade na Data Atual:</label>
                <input type="text" id="idade" v-model="matricula.idade" class="mt-1 p-2 w-full border rounded-md" readonly>
                <div style="color: red;" v-if="errors.idade">{{ errors.idade[0] }}</div>
              </div>

              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600">Idade na Data Base 31/03/{{ anoLetivoAtual }}:</label>
                <input type="text" id="idade_data_corte" v-model="matricula.idade_data_corte" class="mt-1 p-2 w-full border rounded-md" readonly>
                <div style="color: red;" v-if="errors.idade_data_corte">{{ errors.idade_data_corte[0] }}</div>
              </div>

              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600">Turma:</label>
                <input v-model="matricula.turma_especie" type="text" class="mt-1 p-2 w-full border rounded-md bg-gray-100" disabled />
              </div>

              <div class="mb-4">
                <label for="nome_candidato" class="block text-sm font-medium text-gray-600">Nome do Candidato:</label>
                <input type="text" id="nome_candidato" v-model="matricula.nome_candidato"  class="mt-1 p-2 w-full border rounded-md">
                <div style="color: red;" v-if="errors.nome_candidato">{{ errors.nome_candidato[0] }}</div>
              </div>

              <div class="mb-4">
                <label for="cpf_candidato" class="block text-sm font-medium text-gray-600">CPF da Criança:</label>
                <input type="text" id="cpf_candidato" v-model="matricula.cpf_candidato"  class="mt-1 p-2 w-full border rounded-md">
                <div style="color: red;" v-if="errors.cpf_candidato">{{ errors.cpf_candidato[0] }}</div>
            </div>

              <div class="mb-4">
              <label class="block text-sm font-medium text-gray-600">Sexo:</label>
              <select v-model="matricula.sexo"  class="mt-1 p-2 w-full border rounded-md">
                <option value="">Selecionar uma opção</option>
                <option value="feminino">Feminino</option>
                <option value="masculino">Masculino</option>
                <option value="outros">Outros</option>
              </select>
              <div style="color: red;" v-if="errors.sexo">{{ errors.sexo[0] }}</div>
              </div>

              <div class="mb-4">
              <label class="block text-sm font-medium text-gray-600">Possui irmão matriculado em CEIM do município:</label>
              <select v-model="matricula.irmao_creche"  class="mt-1 p-2 w-full border rounded-md">
                <option value="">Selecionar uma opção</option>
                <option value="sim">Sim</option>
                <option value="não">Não</option>
              </select>
              <div style="color: red;" v-if="errors.irmao_creche">{{ errors.irmao_creche[0] }}</div>
              </div>

              <div class="mb-4">
              <label class="block text-sm font-medium text-gray-600">Possui irmão gêmeo:</label>
              <select v-model="matricula.irmao_gemeo" class="mt-1 p-2 w-full border rounded-md">
                <option value="">Selecionar uma opção</option>
                <option value="sim">Sim</option>
                <option value="não">Não</option>
              </select>
              <div style="color: red;" v-if="errors.irmao_gemeo">{{ errors.irmao_gemeo[0] }}</div>
              </div>

              <div v-if="show_irmao_gemeo" class="mb-4">
                <label class="block text-sm font-medium text-gray-600">Nome completo do Irmão Gemeo:</label>
                <input type="text" v-model="matricula.nome_irmao_gemeo" id="nome_irmao_gemeo" class="mt-1 p-2 w-full border rounded-md">
                <div style="color: red;" v-if="errors.nome_irmao_gemeo">{{ errors.nome_irmao_gemeo[0] }}</div>
            </div>

              <div  class="mb-4">
              <label class="block text-sm font-medium text-gray-600">Faz parte do Programa Bolsa Família:</label>
              <select v-model="matricula.bolsa_familia" class="mt-1 p-2 w-full border rounded-md">
                <option value="">Selecionar uma opção</option>
                <option value="sim">Sim</option>
                <option value="não">Não</option>
              </select>
              <div style="color: red;" v-if="errors.bolsa_familia">{{ errors.bolsa_familia[0] }}</div>
              </div>

              <div class="mb-4">
              <label class="block text-sm font-medium text-gray-600">Possui Vulnerabilidade Social e Econômica:</label>
              <select v-model="matricula.vulneravel_social" class="mt-1 p-2 w-full border rounded-md">
                <option value="">Selecionar uma opção</option>
                <option value="sim">Sim</option>
                <option value="não">Não</option>
              </select>
              <div style="color: red;" v-if="errors.vulneravel_social">{{ errors.vulneravel_social[0] }}</div>
              </div>


              <!-- Segunda Coluna -->
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600">Distrito:</label>
                <select v-model="matricula.distrito_id" class="mt-1 p-2 w-full border rounded-md">
                  <option value="">Selecionar uma opção</option>
                  <option  v-for="distrito in distritos" :key="distrito.id" :value="distrito.id">{{ distrito.distrito }}</option>

                </select>
                <div style="color: red;" v-if="errors.distrito_id">{{ errors.distrito_id[0] }}</div>
              </div>

              <div class="mb-4">
                <label for="endereco" class="block text-sm font-medium text-gray-600" >Endereço:</label>
                <input type="text" class="mt-1 p-2 w-full border rounded-md" v-model="matricula.endereco">
                <div style="color: red;" v-if="errors.endereco">{{ errors.endereco[0] }}</div>
              </div>

              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600">Bairro:</label>
                <select v-model="matricula.escola_bairro_id" class="mt-1 p-2 w-full border rounded-md">
                  <option value="">Selecionar uma opção</option>
                  <option v-for="bairro in set_bairros" :key="bairro.id" :value="bairro.id">{{bairro.escola_bairro_id}}</option>

                </select>
                <div style="color: red;" v-if="errors.escola_bairro_id">{{ errors.escola_bairro_id[0] }}</div>
              </div>


              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600">Escola:</label>
                <select v-model="matricula.escola_nome_id" class="mt-1 p-2 w-full border rounded-md" @change="buscarEscolaTurmaPorTipo">
                  <option value="">Selecionar uma opção</option>
                  <option v-for="escola in set_escolas" :key="escola.id" :value="escola.id">{{escola.escola_nome}}</option>
                </select>
                <div style="color: red;" v-if="errors.escola_nome_id">{{ errors.escola_nome_id[0] }}</div>
                <div v-if="resultadoEscolaTurma">
                  <span class="text-green-700 font-semibold">Resultado: escola_id = {{ resultadoEscolaTurma.escola_id }}, turma_id = {{ resultadoEscolaTurma.turma_id }}</span>
                </div>
              </div>

              <!-- Campo Turma -->
              <!--
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600">Turma:</label>
                <select class="mt-1 p-2 w-full border rounded-md" v-model="matricula.turma_id">
                  <option value="">Selecionar uma opção</option>
                  <option v-for="turma in set_turmas" :key="turma.id" :value="turma.id">{{turma.tipo_descricao}}</option>

                </select>
                <div style="color: red;" v-if="errors.turma_id">{{ errors.turma_id[0] }}</div>
              </div>
              -->

              <div class="mb-4">
              <label class="block text-sm font-medium text-gray-600">Possui alguma Deficiência:</label>
              <select v-model="matricula.portador_deficiencia" class="mt-1 p-2 w-full border rounded-md">
                <option value="">Selecionar uma opção</option>
                <option value="sim">Sim</option>
                <option value="não">Não</option>
              </select>
              <div style="color: red;" v-if="errors.portador_deficiencia">{{ errors.portador_deficiencia[0] }}</div>
              </div>

              <div v-if="show_deficiencias" class="mb-4">
              <label class="block text-sm font-medium text-gray-600">Deficiências Tipo:</label>
              <div class="flex">
              <select v-model="matricula.deficiencias_tipo" class="mt-1 p-2 w-full border rounded-md">
                <option value="">Selecionar uma opção</option>
                <option v-for="item in deficiencias" :key="item.id" :value="item.id">{{ item.tipo_deficiencia }}</option>

              </select>
              <div style="color: red;" v-if="errors.deficiencias_tipo">{{ errors.deficiencias_tipo[0] }}</div>
              </div>
              </div>




              <div class="mb-4">
              <label class="block text-sm font-medium text-gray-600">Faz parte do Cadastro Único:</label>
              <select v-model="matricula.cad_unico" class="mt-1 p-2 w-full border rounded-md">
                <option value="">Selecionar uma opção</option>
                <option value="sim">Sim</option>
                <option value="não">Não</option>
              </select>
              <div style="color: red;" v-if="errors.cad_unico">{{ errors.cad_unico[0] }}</div>
              </div>


              <div class="mb-4">
              <label class="block text-sm font-medium text-gray-600">Carteira de Vacinação em Dia:</label>
              <select v-model="matricula.carteira_vacinacao" class="mt-1 p-2 w-full border rounded-md">
                <option value="">Selecionar uma opção</option>
                <option value="sim">Sim</option>
                <option value="não">Não</option>
              </select>
              <div style="color: red;" v-if="errors.carteira_vacinacao">{{ errors.carteira_vacinacao[0] }}</div>
              </div>
            </div><!-- Final -->
            <div>
              <legend class="text-lg text-center font-semibold mb-4 text-white">Dados do Responsável</legend>
            </div>
            <div class="md:grid grid-cols-2 md:p-10 p-5 gap-4"> <!-- Inicio -->

              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600">Grau de Parentesco:</label>
                <select class="mt-1 p-2 w-full border rounded-md" v-model="matricula.grau_parentesco">
                  <option value="">Selecionar uma opção</option>
                  <option value="mãe">Mãe</option>
                  <option value="pai">Pai</option>
                  <option value="responsável legal">Responsavel Legal</option>
                </select>
                <div style="color: red;" v-if="errors.grau_parentesco">{{ errors.grau_parentesco[0] }}</div>
              </div>

              <div class="mb-4">
                <label for="nome_responsavel" class="block text-sm font-medium text-gray-600">Nome do Responsável:</label>
                <input type="text" v-model="matricula.nome_responsavel" class="mt-1 p-2 w-full border rounded-md">
                <div style="color: red;" v-if="errors.nome_responsavel">{{ errors.nome_responsavel[0] }}</div>
              </div>

              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600">Data de Nascimento do Responsável:</label>
                <input type="date" v-model="matricula.data_nasc_responsavel" class="mt-1 p-2 w-full border rounded-md">
                <div style="color: red;" v-if="errors.data_nasc_responsavel">{{ errors.data_nasc_responsavel[0] }}</div>
              </div>

              <div class="mb-4">
              <label class="block text-sm font-medium text-gray-600">Mãe Menor de Idade:</label>
              <select v-model="matricula.mae_menor" class="mt-1 p-2 w-full border rounded-md">
                <option value="">Selecionar uma opção</option>
                <option value="sim">Sim</option>
                <option value="não">Não</option>
              </select>
              <div style="color: red;" v-if="errors.mae_menor">{{ errors.mae_menor[0] }}</div>
              </div>


              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600">CPF do Responsável:</label>
                <input type="text" v-model="matricula.cpf_responsavel" class="mt-1 p-2 w-full border rounded-md">
                <div style="color: red;" v-if="errors.cpf_responsavel">{{ errors.cpf_responsavel[0] }}</div>
              </div>

              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600">Telefone Celular:</label>
                <input type="number" v-model="matricula.tel_cel_responsavel" class="mt-1 p-2 w-full border rounded-md">
                <div style="color: red;" v-if="errors.tel_cel_responsavel">{{ errors.tel_cel_responsavel[0] }}</div>
              </div>

              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600">Telefone para recado:</label>
                <input type="number" v-model="matricula.tel_fixo_responsavel" class="mt-1 p-2 w-full border rounded-md">
                <div style="color: red;" v-if="errors.tel_fixo_responsavel">{{ errors.tel_fixo_responsavel[0] }}</div>
              </div>

              <div class="mb-4">
                <label for="email" id="email" class="block text-sm font-medium text-gray-600">E-mail do Responsável:</label>
                <input type="text" v-model="matricula.email_responsavel" class="mt-1 p-2 w-full border rounded-md">
                <div style="color: red;" v-if="errors.email_responsavel">{{ errors.email_responsavel[0] }}</div>
              </div>

            </div> <!-- Final -->

            <div class="mv-4 pl-10">
              <a href="pdf/Edital_02_de_2024-Cadastro_dos_CEIMs_para_2025.pdf" target="_blank" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg  font-medium rounded-lg text-1xl px-2 py-2.5 text-center me-2 mb-2">Acessar Edital</a>
            </div>

            <div class="md:grid grid-cols-2 md:p-10 p-5 gap-4"> <!-- Inicio -->

            <label for="declaro">
              <input type="checkbox" id="declaro" v-model="matricula.declaro"> Declaro sob as penas da lei, que os dados constantes neste Requerimento de inscrição são verídicos e concordo com os termos e condições estipulados.
              <div style="color: red;" v-if="errors.declaro">{{ errors.declaro[0] }}</div>
            </label>
                <br>
            <label for="edital">
              <input type="checkbox" id="edital" v-model="matricula.edital">  Concordo com os termos e condições estipulados no edital
              <div style="color: red;" v-if="errors.edital">{{ errors.edital[0] }}</div>
            </label>


            <div class="form-group col-span-2 text-center pt-10 ">

            <button v-if="btn_enviar" type="submit" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-2xl px-16 py-2.5 text-center me-2 mb-2 ">
                Enviar
            </button>

            </div>
            </div>

          </form>
      </div>
      </div>
  </div>

  </div>
</div>
</template>


<script>
import axios from 'axios';
import Preloader from '../../components/Preloader.vue';

export default {
  components: {
    Preloader
  },
  props: ['distritos', 'deficiencias'],
  data() {
    return {
      showPreloader: true,
      show_deficiencias: false,
      show_irmao_gemeo: false,
      set_bairros: {},
      set_escolas: {},
      set_turmas: {},
      form_sucesso: false,
      aviso_data_corte: '',
      btn_enviar: true,
      candidato: '',
      resultadoEscolaTurma: null,
      matricula: {
        data_nascimento: '',
        idade: '',
        idade_data_corte: '',
        nome_candidato: '',
        cpf_candidato: '',
        sexo: '',
        irmao_creche: '',
        irmao_gemeo: '',
        bolsa_familia: '',
        vulneravel_social: '',
        distrito_id: '',
        endereco: '',
        escola_bairro_id: '',
        grau_parentesco: '',
        escola_nome_id: '',
        turma_id: '',
        turma_especie: '',
        portador_deficiencia: '',
        deficiencias_tipo: '',
        nome_irmao_gemeo: '',
        cad_unico: '',
        carteira_vacinacao: '',
        nome_responsavel: '',
        data_nasc_responsavel: '',
        mae_menor: '',
        cpf_responsavel: '',
        tel_cel_responsavel: '',
        tel_fixo_responsavel: '',
        email_responsavel: '',
        declaro: false,
        edital: false,
        ano_letivo: new Date().getFullYear(),
      },
      errors: {},
    };
  },
  computed: {
    anoLetivoAtual() {
      // Sempre usar o ano atual
      return new Date().getFullYear();
    }
  },
  mounted() {
    setTimeout(() => {
      this.showPreloader = false;
    }, 5000); // Show preloader for 3.5 seconds
  },

      watch: {
        'matricula.portador_deficiencia': function (val) {
          if (val == 'sim') {
            this.show_deficiencias = true;
          }else{
            this.show_deficiencias = false;
          }
        },

        'matricula.irmao_gemeo': function (val) {
          if (val == 'sim') {
            this.show_irmao_gemeo = true;
          }else{
            this.show_irmao_gemeo = false;
          }
        },

        'matricula.data_nascimento': function (val) {
    if (!val) {
        this.aviso_data_corte = 'Data de nascimento não pode ser vazia.';
        this.btn_enviar = false;
        this.matricula.turma_especie = "Não atribuída";
        return;
    }

    const dataNascimento = new Date(val);
    const dataAtual = new Date();

    // Cálculo da idade em meses
    let anos = dataAtual.getFullYear() - dataNascimento.getFullYear();
    let meses = dataAtual.getMonth() - dataNascimento.getMonth();
    let dias = dataAtual.getDate() - dataNascimento.getDate();
    if (dias < 0) {
        meses--;
        dias += new Date(dataAtual.getFullYear(), dataAtual.getMonth(), 0).getDate();
    }
    if (meses < 0) {
        anos--;
        meses += 12;
    }
    const totalMeses = anos * 12 + meses;

    this.matricula.idade = anos;

    // Cálculo da idade na data de corte (31/03 do ano atual)
    const anoLetivo = dataAtual.getFullYear(); // Sempre usar o ano atual
    const dataCorte = new Date(anoLetivo, 2, 31); // 31/03 do ano atual

    // Calcular a diferença corretamente
    let anosCorte = dataCorte.getFullYear() - dataNascimento.getFullYear();
    let mesesCorte = dataCorte.getMonth() - dataNascimento.getMonth();
    let diasCorte = dataCorte.getDate() - dataNascimento.getDate();

    // Ajustar se os dias são negativos
    if (diasCorte < 0) {
        mesesCorte--;
        // Obter o último dia do mês anterior à data de corte
        const ultimoDiaMesAnterior = new Date(dataCorte.getFullYear(), dataCorte.getMonth(), 0).getDate();
        diasCorte += ultimoDiaMesAnterior;
    }

    // Ajustar se os meses são negativos
    if (mesesCorte < 0) {
        anosCorte--;
        mesesCorte += 12;
    }

    // Ajustar para obter o resultado desejado (subtrair 1 dia)
    diasCorte--;
    if (diasCorte < 0) {
        mesesCorte--;
        diasCorte = new Date(dataCorte.getFullYear(), dataCorte.getMonth() - 1, 0).getDate() - 2;
        if (mesesCorte < 0) {
            anosCorte--;
            mesesCorte = 11;
        }
    }

    // Se a data de nascimento é posterior à data de corte, a idade deve ser 0
    if (dataNascimento > dataCorte) {
        anosCorte = 0;
        mesesCorte = 0;
        diasCorte = 0;
    }

    // Formatar idade na data de corte como "X anos, Y meses e Z dias"
    let idadeCorteTexto = '';
    if (anosCorte > 0) {
        idadeCorteTexto += anosCorte + (anosCorte === 1 ? ' ano' : ' anos');
    }
    if (mesesCorte > 0) {
        if (idadeCorteTexto) idadeCorteTexto += ', ';
        idadeCorteTexto += mesesCorte + (mesesCorte === 1 ? ' mês' : ' meses');
    }
    if (diasCorte > 0) {
        if (idadeCorteTexto) idadeCorteTexto += ' e ';
        idadeCorteTexto += diasCorte + (diasCorte === 1 ? ' dia' : ' dias');
    }

    this.matricula.idade_data_corte = idadeCorteTexto || '0 dias';

    // Atualiza a turma automaticamente
    this.matricula.turma_especie = this.definirTurma(val);

    // Lógica para exibir ou ocultar o botão Enviar baseada na data de corte (31/03)
    const totalMesesCorte = anosCorte * 12 + mesesCorte;

    // Removida a validação de idade mínima de 6 meses na data de corte
    // Agora apenas verifica se excede a idade máxima
    if (anosCorte > 3 || (anosCorte === 3 && (mesesCorte > 11 || diasCorte > 29))) {
        this.btn_enviar = false;
        this.aviso_data_corte = 'A criança deve ter no máximo 3 anos e 11 meses 29 dias na data base (31/03).';
    } else {
        this.btn_enviar = true;
        this.aviso_data_corte = '';
    }
},
        'matricula.cpf_candidato': function (val) {
            var cpf = val;
            if(this.matricula.cpf_candidato.length >= 11){
                if (this.validarCpf(cpf)) {
                     this.errors.cpf_candidato = '';
                }else{
                    this.errors.cpf_candidato = ['CPF Inválido'];

                }
            }else{
                this.errors.cpf_candidato = ['Digitar 11 dígitos'];
            }
        },

        'matricula.cpf_responsavel': function (val) {
            var cpf_res = val;
            if(this.matricula.cpf_responsavel.length >= 11){
                if (this.validarCpf(cpf_res)) {
                     this.errors.cpf_responsavel = '';
                }else{
                    this.errors.cpf_responsavel = ['CPF Inválido'];
                }
            }else{
                this.errors.cpf_responsavel = ['Digitar 11 dígitos'];
            }
        },

        'matricula.distrito_id': function (val) {
          this.consultarBairro();
        },

        'matricula.escola_bairro_id': function (val) {
          this.consultarEscola();
        },

        'matricula.escola_nome_id': function (val) {
          this.consultarTurma();
        },


      },

  methods: {
        async buscarEscolaTurmaPorTipo() {
          // Busca escola_id e turma_id a partir do tipo de turma (matricula.turma_especie)
          if (!this.matricula.turma_especie) {
            this.resultadoEscolaTurma = null;
            return;
          }
          try {
            const response = await axios.post('/matricula/escola-turma-por-tipo', {
              turma_especie: this.matricula.turma_especie
            });
            this.resultadoEscolaTurma = response.data;
          } catch (error) {
            this.resultadoEscolaTurma = null;
          }
        },
        // função que calcula a turma


        definirTurma(dataNascimento) {
          if (!dataNascimento) return "Não atribuída";

          const nascimento = new Date(dataNascimento);
          const hoje = new Date();

          // Data de corte: 31/03 do ano atual
          const anoAtual = hoje.getFullYear();
          const dataCorte = new Date(anoAtual, 2, 31); // Março = 2 (0-based)

          // Idade em meses na data de corte
          let idadeMesesCorte =
            (dataCorte.getFullYear() - nascimento.getFullYear()) * 12 +
            (dataCorte.getMonth() - nascimento.getMonth());

          if (nascimento.getDate() > dataCorte.getDate()) {
            idadeMesesCorte -= 1;
          }

          // Faixas de nascimento baseadas no corte
          const datas = {
            bercarioA_ini: new Date(anoAtual - 1, 2, 31), // 31/03/(anoAtual-1)
            bercarioA_fim: dataCorte,                    // 31/03/anoAtual

            bercarioB_ini: new Date(anoAtual - 2, 2, 31), // 01/04/(anoAtual-2)
            bercarioB_fim: new Date(anoAtual - 1, 2, 31),// 31/03/(anoAtual-1)

            nivel1_ini: new Date(anoAtual - 3, 2, 31),    // 01/04/(anoAtual-3)
            nivel1_fim: new Date(anoAtual - 2, 2, 31),   // 31/03/(anoAtual-2)

            nivel2_ini: new Date(anoAtual - 4, 2, 31),    // 01/04/(anoAtual-4)
            nivel2_fim: new Date(anoAtual - 3, 2, 31),   // 31/03/(anoAtual-3)
          };

          // Regras com OU (idade OU data de nascimento)
          if (
            (idadeMesesCorte >= 6 && idadeMesesCorte <= 11) ||
            (nascimento >= datas.bercarioA_ini && nascimento <= datas.bercarioA_fim)
          ) {
            return "BERÇÁRIO A";
          }
          else if (
            (idadeMesesCorte >= 12 && idadeMesesCorte <= 23) ||
            (nascimento >= datas.bercarioB_ini && nascimento <= datas.bercarioB_fim)
          ) {
            return "BERÇÁRIO B";
          }
          else if (
            (idadeMesesCorte >= 24 && idadeMesesCorte <= 35) ||
            (nascimento >= datas.nivel1_ini && nascimento <= datas.nivel1_fim)
          ) {
            return "Nível 1";
          }
          else if (
            (idadeMesesCorte >= 36 && idadeMesesCorte <= 47) ||
            (nascimento >= datas.nivel2_ini && nascimento <= datas.nivel2_fim)
          ) {
            return "Nível 2";
          }

          return "Não atribuída";
        },

        resetMatricula() {
            this.matricula = {
                data_nascimento: '',
                idade: '',
                idade_data_corte: '',
                nome_candidato: '',
                cpf_candidato: '',
                sexo: '',
                irmao_creche: '',
                irmao_gemeo: '',
                bolsa_familia: '',
                vulneravel_social: '',
                distrito_id: '',
                endereco: '',
                escola_bairro_id: '',
                grau_parentesco: '',
                escola_nome_id: '',
                turma_id: '',
                turma_especie: '',
                portador_deficiencia: '',
                deficiencias_tipo: '',
                nome_irmao_gemeo: '',
                cad_unico: '',
                carteira_vacinacao: '',
                nome_responsavel: '',
                data_nasc_responsavel: '',
                mae_menor: '',
                cpf_responsavel: '',
                tel_cel_responsavel: '',
                tel_fixo_responsavel: '',
                email_responsavel: '',
                declaro: false,
                edital: false,
                ano_letivo: new Date().getFullYear(),
            };
      },

      scrollToTop() {
        window.scrollTo({
            top: 0,
            left: 0,
            behavior: 'smooth'
        });
    },


    verificarDataCorte(dataNascimento) {
        // Função removida: não faz mais validação de data de corte
    },


        async submit() {
      try {
        // Garante que ano_letivo é um número inteiro
        this.matricula.ano_letivo = Number(this.matricula.ano_letivo);
        const csrfToken = window.Laravel.csrfToken;

        const enviar = await axios.post('/matricula/enviar', this.matricula, {
          headers: {
            'X-CSRF-Token': csrfToken, // Inclui o token CSRF no cabeçalho da solicitação
          },
        });

        console.log('Resposta do backend:', enviar.data);
        if (enviar.status === 200 && enviar.data && enviar.data.id) {
          this.candidato = enviar.data.id;
          this.form_sucesso = true;
          console.log('Sucesso: =================');
          console.log('ID do candidato (base64):', this.candidato);
          window.location.href = `/matricula/comprovante/${this.candidato}/d`;
        } else {
          this.form_sucesso = false;
          this.candidato = '';
          console.error('Resposta inesperada ou id ausente:', enviar);
        }

        console.log('Resposta do backend:', enviar);
        console.log('CSRF token:', csrfToken);

        // Você pode fazer algo com a resposta 'enviar' aqui, se necessário.
      } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
          this.errors = error.response.data.errors;
          this.scrollToTop();
          console.error('Erros de validação:', this.errors);
        } else {
          this.scrollToTop();
          console.error('Erro inesperado:', error);
        }
      }
        },


        async consultarBairro() {
            try {
                const response = await axios.post('/matricula/consultar-bairro', {
                distrito: this.matricula.distrito_id,
                });



                // Verifique se 'response.data' contém os dados desejados
                console.log(response.data);

                // Armazene a resposta na variável 'set_bairros'
                this.set_bairros = response.data.data; // Acesso aos dados pode variar dependendo da estrutura

                // Use 'this.set_bairros' conforme necessário
                console.log(this.set_bairros);
            } catch (error) {
                console.error('Erro ao consultar bairro:', error);
            }
        },




    async consultarEscola() {
      try {
        // Envia também o tipo de turma desejado (matricula.turma_especie)
        const response = await axios.post('/matricula/consultar-escola', {
          bairro_id: this.matricula.escola_bairro_id,
          turma_especie: this.matricula.turma_especie
        });
        let escolas = response.data.data;
        this.set_escolas = escolas;
        console.log(this.set_escolas);
      } catch (error) {
        console.error('Erro ao consultar escola:', error);
      }
    },

        async consultarTurma() {
            try {
                const response = await axios.post('/matricula/consultar-turma', {
                turma: this.matricula.escola_nome_id,
                });

                // Verifique se 'response.data' contém os dados desejados
                console.log(response.data);

                // Armazene a resposta na variável 'set_turmas'
                this.set_turmas = response.data.data; // Acesso aos dados pode variar dependendo da estrutura

                // Use 'this.set_turmas' conforme necessário
                console.log(this.set_turmas);
            } catch (error) {
                console.error('Erro ao consultar bairro:', error);
            }
        },


        validarCpf(cpf) {
            cpf = cpf.replace(/[^\d]+/g,''); // remove todos os caracteres não numéricos
            if (cpf === '') { // verifica se o CPF está em branco
            return false;
            }
            // verifica se o CPF tem 11 dígitos
            if (cpf.length !== 11) {
            return false;
            }
            // verifica se todos os dígitos do CPF são iguais (ex: 00000000000)
            if (/^([0-9])\1+$/.test(cpf)) {
            return false;
            }
            // calcula os dígitos verificadores do CPF
            let soma = 0;
            for (let i = 0; i < 9; i++) {
            soma += parseInt(cpf.charAt(i)) * (10 - i);
            }
            let resto = 11 - (soma % 11);
            let dv1 = (resto > 9 ? 0 : resto);
            soma = 0;
            for (let i = 0; i < 10; i++) {
            soma += parseInt(cpf.charAt(i)) * (11 - i);
            }
            resto = 11 - (soma % 11);
            let dv2 = (resto > 9 ? 0 : resto);
            // verifica se os dígitos verificadores do CPF são válidos
            if (dv1 !== parseInt(cpf.charAt(9)) || dv2 !== parseInt(cpf.charAt(10))) {
            return false;
            }
            // verifica se o CPF é válido segundo a Receita Federal
            let cpfCompleto = cpf.substr(0, 9) + dv1 + dv2;
            let numerosInvalidos = ['00000000000', '11111111111', '22222222222', '33333333333', '44444444444', '55555555555', '66666666666', '77777777777', '88888888888', '99999999999'];
            if (numerosInvalidos.includes(cpfCompleto)) {
            return false;
            }
            let somaCpf = 0;
            for (let i = 0; i < 9; i++) {
            somaCpf += parseInt(cpfCompleto.charAt(i)) * (10 - i);
            }
            resto = 11 - (somaCpf % 11);
            if ((resto === 10) || (resto === 11)) {
            resto = 0;
            }
            if (resto !== parseInt(cpfCompleto.charAt(9))) {
            return false;
            }
            somaCpf = 0;
            for (let i = 0; i < 10; i++) {
            somaCpf += parseInt(cpfCompleto.charAt(i)) * (11 - i);
            }
            resto = 11 - (somaCpf % 11);
            if ((resto === 10) || (resto === 11)) {
            resto = 0;
            }
            if (resto !== parseInt(cpfCompleto.charAt(10))) {
            return false;
            }
            // se chegou até aqui, o CPF é válido
            return true;
        }
      }


  }

</script>

  <style>

  </style>
