<template>

    <div class="py-5 px-2 min-h-screen" style="background-image: linear-gradient(225deg,#429edc,#00629e);">

    <div >
        <img class="h-20 mx-auto" src="/img/logo-pmm-branco.png" alt="">
    </div>
    
    <div class="pt-10 sm:w-auto  md:w-3/3 lg:w-3/4 mx-auto">
             
   
    
    <form @submit.prevent="submit(candidato)" class="bg-gray-100 p-6" >
     
    <h1 class="text-center font-medium mb-4 mx-auto">Cadastro de candidatos - Experiência</h1>
    <div class="grid md:grid-cols-2 gap-4">
        <div v-for="xp in vagasXp" :key="xp.id">
            <label for="id_vagas" class="block text-gray-700 font-medium mb-2">{{ xp.titulo }}</label>
            <select 
            id="id_vagas" 
            v-model="form[xp.id]"
            :name="`form.${xp.id}`"
            class="w-full p-2 border border-gray-300 rounded-md" 
            required>
                <option value="">Escolha uma opção...</option>                
                <option v-for="set_xp in xp.plus" :key="set_xp.id" :value="set_xp.id">{{ set_xp.titulo }}</option>                
                
            </select>
            <div style="color: red;" v-if="errors.id_vagas">{{ errors.id_vagas }}</div>
        </div>
    </div>
 
    <div class="mt-6  ">
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded ">Salvar</button>
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
            form: {}
        }
    },


    methods: {
        submit(id) {

            this.form.id = id;

            this.$inertia.post('/processo-seletivo-xp', this.form);
            console.log(this.form);
        }
    }

   

   
}


</script>



<style>

</style>