<template>

    <div class="py-5 px-2 min-h-screen" style="background-image: linear-gradient(225deg,#429edc,#00629e);">

    <div >
        <img class="h-20 mx-auto" src="/img/logo-pmm-branco.png" alt="">
    </div>

    <div class="pt-10 sm:w-auto  md:w-3/3 lg:w-3/4 mx-auto">




    <form @submit.prevent="submit" class="bg-gray-100 p-6" >

    <h1 class="text-center font-medium mb-4 mx-auto">Cadastro de candidatos </h1>

    <div>
        <a href="https://www.mangaratiba.rj.gov.br/processosseletivos/_webapp/_lib/file/doc/arquivos/Comunicado.pdf
" target="_blank" rel="noopener noreferrer">

            <button type="button" @click="handleButtonClick" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded"> ! COMUNICADO IMPORTANTE !</button>
        </a>
        <div style="color: red;" v-if="errors.btn">{{ errors.btn }}</div>
    </div>

    <br>

    <div class="grid md:grid-cols-2 gap-4">
  <div>
    <label for="id_vagas" class="block text-gray-700 font-medium mb-2">Selecionar Vaga</label>
    <select id="id_vagas" v-model="set_vagas" class="w-full p-2 border border-gray-300 rounded-md">
      <option value="">Selecione...</option>
      <option v-for="vaga in vagas" :value="vaga.id">{{ vaga.titulo }}</option>
    </select>
    <div style="color: red;" v-if="errors.id_vagas">{{ errors.id_vagas }}</div>
  </div>

  <div v-if="locaisDisponiveis.length">
    <label for="local" class="block text-gray-700 font-medium mb-2">Local</label>
    <select v-model="form.local" id="local" class="w-full p-2 border border-gray-300 rounded-md">
      <option value="">Selecione um local</option>
      <option v-for="local in locaisDisponiveis" :key="local" :value="local">{{ local }}</option>
    </select>
  </div>
</div>
    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label for="nome" class="block text-gray-700 font-medium mb-2">Nome completo:</label>
            <input type="text" id="nome" v-model="form.nome" class="w-full p-2 border border-gray-300 rounded-md" >
            <div style="color: red;" v-if="errors.nome">{{ errors.nome }}</div>
        </div>
        <div>
            <label for="cpf" class="block text-gray-700 font-medium mb-2">CPF:  <b style="color: red" v-if="cpf_alert">Seu CPF está inválido, por favor, revisar!</b></label>
            <input type="tel" id="cpf" v-model="set_cpf" class="w-full p-2 border border-gray-300 rounded-md"  >
            <div style="color: red;" v-if="errors.cpf">{{ errors.cpf }}</div>
        </div>
    </div>
    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label for="data_nasc" class="block text-gray-700 font-medium mb-2">Data de nascimento:</label>
            <input type="date" id="data_nasc" v-model="form.data_nasc" class="w-full p-2 border border-gray-300 rounded-md" >
            <div style="color: red;" v-if="errors.data_nasc">{{ errors.data_nasc }}</div>
        </div>
        <div>
            <label for="cor_raca" class="block text-gray-700 font-medium mb-2">Cor/Raça:</label>
            <select id="cor_raca" v-model="form.cor_raca" class="w-full p-2 border border-gray-300 rounded-md" >
                <option value="">Selecione...</option>
                <option value="Branca">Branca</option>
                <option value="Preta">Preta</option>
                <option value="Amarela">Amarela</option>
                <option value="Parda">Parda</option>
                <option value="Indígena">Indígena</option>
            </select>
            <div style="color: red;" v-if="errors.cor_raca">{{ errors.cor_raca }}</div>
        </div>
    </div>
    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label for="nacionalidade" class="block text-gray-700 font-medium mb-2">Nacionalidade:</label>
            <input type="text" id="nacionalidade" v-model="form.nacionalidade" class="w-full p-2 border border-gray-300 rounded-md" >
            <div style="color: red;" v-if="errors.nacionalidade">{{ errors.nacionalidade }}</div>
        </div>
        <div>
            <label for="naturalidade" class="block text-gray-700 font-medium mb-2">Naturalidade:</label>
            <input type="text" id="naturalidade" v-model="form.naturalidade" class="w-full p-2 border border-gray-300 rounded-md" >
            <div style="color: red;" v-if="errors.naturalidade">{{ errors.naturalidade }}</div>
        </div>
    </div>
    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label for="sexo" class="block text-gray-700 font-medium mb-2">Sexo:</label>
            <select id="sexo" v-model="form.sexo" class="w-full p-2 border border-gray-300 rounded-md" >
                <option value="">Selecione...</option>
                <option value="Masculino">Masculino</option>
                <option value="Feminino">Feminino</option>
                <option value="Outro">Outro</option>
              </select>
              <div style="color: red;" v-if="errors.sexo">{{ errors.sexo }}</div>
    </div>
    <div>
        <label for="estado_civil" class="block text-gray-700 font-medium mb-2">Estado civil:</label>
        <select id="estado_civil" v-model="form.estado_civil" class="w-full p-2 border border-gray-300 rounded-md" >
            <option value="">Selecione...</option>
            <option value="Solteiro(a)">Solteiro(a)</option>
            <option value="Casado(a)">Casado(a)</option>
            <option value="Divorciado(a)">Divorciado(a)</option>
            <option value="Viúvo(a)">Viúvo(a)</option>
            <option value="Separado(a)">Separado(a)</option>
        </select>
        <div style="color: red;" v-if="errors.estado_civil">{{ errors.estado_civil }}</div>
    </div>
    </div>
    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label for="deficiencia" class="block text-gray-700 font-medium mb-2">Possui deficiência?</label>
            <div class="flex items-center">
                <input type="radio" id="deficiencia_sim" v-model="deficiencia" value="Sim" class="mr-2" >
                <label for="deficiencia_sim" class="text-gray-700 font-medium">Sim</label>
            </div>
            <div class="flex items-center">
                <input type="radio" id="deficiencia_nao" v-model="deficiencia" value="Não" class="mr-2" >
                <label for="deficiencia_nao" class="text-gray-700 font-medium">Não</label>
            </div>
            <div style="color: red;" v-if="errors.deficiencia">{{ errors.deficiencia }}</div>
        </div>
        <div>
            <label for="tipo_deficiencia" class="block text-gray-700 font-medium mb-2">Tipo de deficiência:</label>
            <input type="text" id="tipo_deficiencia" v-model="form.tipo_deficiencia" class="w-full p-2 border border-gray-300 rounded-md" :disabled="this.t_def == false" :required="this.t_def==true">
            <div style="color: red;" v-if="errors.tipo_deficiencia">{{ errors.tipo_deficiencia }}</div>
        </div>
    </div>
    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label for="nome_pai" class="block text-gray-700 font-medium mb-2">Nome do pai:</label>
            <input type="text" id="nome_pai" v-model="form.nome_pai" class="w-full p-2 border border-gray-300 rounded-md">
            <div style="color: red;" v-if="errors.nome_pai">{{ errors.nome_pai }}</div>
        </div>
        <div>
            <label for="nome_mae" class="block text-gray-700 font-medium mb-2">Nome da mãe:</label>
            <input type="text" id="nome_mae" v-model="form.nome_mae" class="w-full p-2 border border-gray-300 rounded-md" >
            <div style="color: red;" v-if="errors.nome_mae">{{ errors.nome_mae }}</div>
        </div>
    </div>
    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label for="escolaridade" class="block text-gray-700 font-medium mb-2">Escolaridade:</label>
            <select id="escolaridade" v-model="form.escolaridade" class="w-full p-2 border border-gray-300 rounded-md" >
                <option value="">Selecione...</option>
                <option value="fundamental_incompleto">Fundamental incompleto</option>
                <option value="fundamental_completo">Fundamental completo</option>
                <option value="medio_incompleto">Médio incompleto</option>
                <option value="medio_completo">Médio completo</option>
                <option value="superior_incompleto">Superior incompleto</option>
                <option value="superior_completo">Superior completo</option>
        </select>
        <div style="color: red;" v-if="errors.escolaridade">{{ errors.escolaridade }}</div>
    </div>
    <div>
    <label for="rg" class="block text-gray-700 font-medium mb-2">RG:</label>
    <input type="text" id="rg" v-model="form.rg" class="w-full p-2 border border-gray-300 rounded-md" >
    <div style="color: red;" v-if="errors.rg">{{ errors.rg }}</div>
    </div>
    </div>
    <div class="grid md:grid-cols-3 gap-4">
    <div>
    <label for="rg_emissor" class="block text-gray-700 font-medium mb-2">Órgão emissor:</label>
    <input type="text" id="rg_emissor" v-model="form.rg_emissor" class="w-full p-2 border border-gray-300 rounded-md" >
    <div style="color: red;" v-if="errors.rg_emissor">{{ errors.rg_emissor }}</div>
    </div>
    <div>
    <label for="rg_estado" class="block text-gray-700 font-medium mb-2">Estado:</label>
    <input type="text" id="rg_estado" v-model="form.rg_estado" class="w-full p-2 border border-gray-300 rounded-md" >
    <div style="color: red;" v-if="errors.rg_estado">{{ errors.rg_estado }}</div>
    </div>
    <div>
    <label for="rg_data_emissao" class="block text-gray-700 font-medium mb-2">Data de emissão:</label>
    <input type="date" id="rg_data_emissao" v-model="form.rg_data_emissao" class="w-full p-2 border border-gray-300 rounded-md" >
    <div style="color: red;" v-if="errors.rg_data_emissao">{{ errors.rg_data_emissao }}</div>
    </div>
    </div>
    <div class="grid md:grid-cols-2 gap-4">
        <div>
        <label for="cep" class="block text-gray-700 font-medium mb-2">CEP:</label>
        <input type="text" id="cep" v-model="numeros_cep" class="w-full p-2 border border-gray-300 rounded-md">
        <div style="color: red;" v-if="errors.rg_cep">{{ errors.cep }}</div>
    </div>

        <div>
            <label for="cep" class="block text-gray-700 font-medium mb-2">&nbsp;</label>
            <button type="button" @click="buscarCep" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Buscar CEP</button>
        </div>

    </div>
    <div class="grid md:grid-cols-2 gap-4">
    <div>
    <label for="endereco" class="block text-gray-700 font-medium mb-2">Endereço:</label>
    <input type="text" id="endereco" v-model="form.endereco" class="w-full p-2 border border-gray-300 rounded-md" >
    <div style="color: red;" v-if="errors.endereco">{{ errors.endereco }}</div>
    </div>
    <div>
    <label for="numero" class="block text-gray-700 font-medium mb-2">Número:</label>
    <input type="text" id="numero" v-model="form.numero" class="w-full p-2 border border-gray-300 rounded-md" >
    <div style="color: red;" v-if="errors.numero">{{ errors.numero }}</div>
    </div>
    </div>
    <div class="grid md:grid-cols-2 gap-4">
    <div>
    <label for="complemento" class="block text-gray-700 font-medium mb-2">Complemento:</label>
    <input type="text" id="complemento" v-model="form.complemento" class="w-full p-2 border border-gray-300 rounded-md">
    <div style="color: red;" v-if="errors.complemento">{{ errors.complemento }}</div>
    </div>
    <div>
    <label for="bairro" class="block text-gray-700 font-medium mb-2">Bairro:</label>
    <input type="text" id="bairro" v-model="form.bairro" class="w-full p-2 border border-gray-300 rounded-md" >
    <div style="color: red;" v-if="errors.bairro">{{ errors.bairro }}</div>
    </div>
    </div>
    <div class="grid md:grid-cols-3 gap-4">
        <div>
            <label for="cidade" class="block text-gray-700 font-medium mb-2">Cidade:</label>
            <input type="text" id="cidade" v-model="form.cidade" class="w-full p-2 border border-gray-300 rounded-md" >
            <div style="color: red;" v-if="errors.cidade">{{ errors.cidade }}</div>
        </div>
        <div>
            <label for="uf" class="block text-gray-700 font-medium mb-2">UF:</label>
            <input type="text" id="uf" v-model="form.uf" class="w-full p-2 border border-gray-300 rounded-md" >
            <div style="color: red;" v-if="errors.uf">{{ errors.uf }}</div>
        </div>
    </div>
    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label for="telefone" class="block text-gray-700 font-medium mb-2">Telefone:</label>
            <input type="text" id="telefone" v-model="form.telefone" class="w-full p-2 border border-gray-300 rounded-md" >
            <div style="color: red;" v-if="errors.telefone">{{ errors.telefone }}</div>
        </div>
        <div>
            <label for="celular" class="block text-gray-700 font-medium mb-2">Celular:</label>
            <input type="text" id="celular" v-model="form.celular" class="w-full p-2 border border-gray-300 rounded-md" >
            <div style="color: red;" v-if="errors.celular">{{ errors.celular }}</div>
        </div>
    </div>
    <div>
        <label for="email" class="block text-gray-700 font-medium mb-2">E-mail:</label>
        <input type="email" id="email" v-model="form.email" class="w-full p-2 border border-gray-300 rounded-md" >
        <div style="color: red;" v-if="errors.email">{{ errors.email }}</div>
    </div>
    <div class="mt-6 flex justify-center">
    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
        Enviar
    </button>
</div>
    </form>


</div>
</div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        vagas: Object,
        errors: Object,
    },

    data() {
        return {
            buttonClicked: false,
            deficiencia: '',
            set_vagas: '',
            numeros_cep: '',
            set_cpf: '',
            cpf_alert: false,
            dados: {},
            t_def: false,
            locaisDisponiveis: [],

            mapaDeLocaisPorVaga: {
    "PROFESSOR I - ARTE": ["Mangaratiba", "Conceição de Jacareí", "Itacuruçá"],
    "PROFESSOR I - CIÊNCIAS": ["Mangaratiba", "Itacuruçá"],
    "PROFESSOR I - EDUCAÇÃO FÍSICA": ["Mangaratiba", "Conceição de Jacareí"],
    "PROFESSOR I - GEOGRAFIA": ["Mangaratiba"],
    "PROFESSOR I - LÍNGUA PORTUGUESA": ["Mangaratiba", "Conceição de Jacareí", "Muriqui", "Serra do Piloto"],
    "PROFESSOR I - MATEMÁTICA": ["Mangaratiba", "Conceição de Jacareí", "Serra do Piloto"],
    "PROFESSOR I - INGLÊS": ["Serra do Piloto"],
    "PROFESSOR II": ["Mangaratiba", "Ibicuí", "Praia Brava", "Junqueira", "Praia do Saco", "Acampamento", "Fazenda Ingaíba e Batatal"],
},

            form: this.$inertia.form({
                id_vagas: '',
                nome: '',
                cpf: '',
                data_nasc: '',
                cor_raca: '',
                nacionalidade: '',
                naturalidade: '',
                sexo: '',
                estado_civil: '',
                deficiencia: '',
                tipo_deficiencia: '',
                nome_pai: '',
                nome_mae: '',
                escolaridade: '',
                rg: '',
                rg_emissor: '',
                rg_estado: '',
                rg_data_emissao: '',
                cep: '',
                endereco: '',
                numero: '',
                complemento: '',
                bairro: '',
                cidade: '',
                uf: '',
                telefone: '',
                celular: '',
                email: '',
                local: '',
            }),
        }
    },

    watch: {
        deficiencia(val) {
            this.form.deficiencia = val === 'Sim' ? '1' : '0';
            this.t_def = val === 'Sim';
        },

        set_vagas(val) {
            this.form.id_vagas = val;
            this.set_vaga(val);

            // Atualiza os locais disponíveis com base no título da vaga
            const vagaSelecionada = this.vagas.find(v => v.id === val);
            if (vagaSelecionada) {
                const titulo = vagaSelecionada.titulo;
                this.locaisDisponiveis = this.mapaDeLocaisPorVaga[titulo] || [];
                this.form.local = ''; // reseta campo local ao trocar de vaga
            }
        },

        set_cpf: {
            handler(novoValor) {
                novoValor = novoValor.replace(/[^\d]/g, '');
                if (novoValor.length === 11) {
                    const cpfValido = this.validarCpf(novoValor);
                    this.form.cpf = novoValor;
                    this.cpf_alert = !cpfValido;
                }
            },
            deep: true,
        },

        numeros_cep(valor) {
            let v = valor.replace(/[^\d]/g, '');
            if (v.length === 8) {
                this.form.cep = v;
                axios.get(`https://viacep.com.br/ws/${v}/json/`)
                    .then(response => {
                        this.form.endereco = response.data.logradouro;
                        this.form.bairro = response.data.bairro;
                        this.form.cidade = response.data.localidade;
                        this.form.uf = response.data.uf;
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Erro ao buscar CEP. Por favor, tente novamente.');
                    });
            }
        }
    },

    methods: {
        handleButtonClick() {
            this.buttonClicked = true;
        },

        async set_vaga(id) {
            try {
                const response = await axios.get('/processo-seletivo-check-vaga/' + id);
                this.dados = response.data;
                console.log(this.dados);
            } catch (e) {
                console.error(e);
            }
        },

        submit() {
            if (!this.buttonClicked) {
                alert('Por favor, clique no botão "COMUNICADO IMPORTANTE" antes de enviar o formulário.');
                return;
            }
            this.form.post(route('processo-seletivo.store'));
        },

        async buscarCep() {
            if (this.form.cep.length === 8) {
                try {
                    const response = await axios.get(`https://viacep.com.br/ws/${this.form.cep}/json/`);
                    this.form.endereco = response.data.logradouro;
                    this.form.bairro = response.data.bairro;
                    this.form.cidade = response.data.localidade;
                    this.form.uf = response.data.uf;
                } catch (error) {
                    console.error(error);
                    alert('Erro ao buscar CEP. Por favor, tente novamente.');
                }
            }
        },

        validarCpf(cpf) {
            cpf = cpf.replace(/[^\d]+/g, '');
            if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false;
            let soma = 0, resto;
            for (let i = 0; i < 9; i++) soma += parseInt(cpf[i]) * (10 - i);
            resto = 11 - (soma % 11);
            if (resto >= 10) resto = 0;
            if (resto !== parseInt(cpf[9])) return false;
            soma = 0;
            for (let i = 0; i < 10; i++) soma += parseInt(cpf[i]) * (11 - i);
            resto = 11 - (soma % 11);
            if (resto >= 10) resto = 0;
            return resto === parseInt(cpf[10]);
        },
    }
}
</script>





<style>

</style>