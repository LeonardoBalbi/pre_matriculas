<template>

    <div class="py-5 px-2 min-h-screen" style="background-image: linear-gradient(225deg,#429edc,#00629e);">

    <div >
        <img class="h-20 mx-auto" src="/img/logo-pmm-branco.png" alt="">
    </div>
    
    <div class="pt-10 sm:w-auto  md:w-3/3 lg:w-3/4 mx-auto">
             
   
    
    <form @submit.prevent="submit()" class="bg-gray-100 p-6" >
     
    <h1 class="text-center font-medium mb-4 mx-auto">Consultar - Protocolo de Inscrição</h1>
    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label for="cpf" class="block text-gray-700 font-medium mb-2">CPF:  <b style="color: red" v-if="cpf_alert">Seu CPF está inválido, por favor, revisar!</b></label>
            <input type="tel" id="cpf" v-model="set_cpf" class="w-full p-2 border border-gray-300 rounded-md"  >
            <div style="color: red;" v-if="errors.cpf">{{ errors.cpf }}</div>
        </div>
        <div>
            <label for="data_nasc" class="block text-gray-700 font-medium mb-2">Data de nascimento:</label>
            <input type="date" id="data_nasc" v-model="form.data_nasc" class="w-full p-2 border border-gray-300 rounded-md" >
            <div style="color: red;" v-if="errors.data_nasc">{{ errors.data_nasc }}</div>
        </div>
    </div>
 
    <div class="mt-6  ">
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded ">Consultar</button>
    </div>
    </form>


</div>
</div>
</template>

<script>

export default {
    components: {

    },

    props:{       
        candidato: Number,
        vaga: Number,
        vagasXp: Array,
        errors: Object,
    },

    data () {
        return{
            set_cpf: '',
            form: {}
        }
    },

    watch: {
        set_cpf:{
            handler: function (novoValor) {
                novoValor = novoValor.replace(/[^\d]/g, '');
            if (novoValor.length === 11) {
                let cpfValido = this.validarCpf(novoValor);
                this.form.cpf = novoValor;
                // console.log('CPF Valido: ' + cpfValido);
                this.cpf_alert = false;
                if (!cpfValido) {
                    this.cpf_alert = true;
                    // console.log('CPF inválido');
                }
            }
            },
            deep: true
        
        },
    },


    methods: {
        submit() {

            this.$inertia.post('/processo-seletivo/consulta', this.form);
            console.log(this.form);
            
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