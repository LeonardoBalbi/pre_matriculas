<template>

    <div class="py-5 px-2 min-h-screen" style="background-image: linear-gradient(225deg,#429edc,#00629e);">

    <div >
        <img class="h-20 mx-auto" src="/img/logo-pmm-branco.png" alt="">
    </div>

    <div class="pt-10 sm:w-auto  md:w-3/3 lg:w-3/4 mx-auto">
             
    
    <div class="bg-gray-100 p-6" >
     
     <h1 class="text-center font-medium mb-4 mx-auto">Cadastro de candidatos - Experiência</h1>

        <img src="/img/check.png" alt="" class="h-20 mx-auto">

        <h1 class="mx-auto text-center p-5 ">PARABÉNS INSCRIÇÃO CONCLUÍDA COM SUCESSO!</h1>

        
        <div class="mx-auto text-center">
            <a :href="route('processo-seletivo.comprovante',[candidato, 'd'])">
                <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                    <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z"/></svg>
                    <span>Download</span>
                </button>
            </a>
            &nbsp
            <a :href="route('processo-seletivo.comprovante',[candidato, 'p'])">
                <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                    <span>Imprimir</span>
                </button>
            </a>
        </div>
        
       

    </div>

</div>
</div>
</template>

<script>
export default {

    props:{       
        candidato: Number,  
    },

}
</script>

<style>

</style>