<template>

    <div class="py-5 px-2 min-h-screen" style="background-image: linear-gradient(225deg,#429edc,#00629e);">

    <div >
        <img class="h-20 mx-auto" src="/img/logo-pmm-branco.png" alt="">
    </div>

    <div class="pt-10 sm:w-auto  md:w-3/3 lg:w-3/4 mx-auto">
             
    
    <div @submit.prevent="submit(candidato)" class="bg-gray-100 p-6" >
     
     <h1 class="text-center font-medium mb-4 mx-auto">Cadastro de candidatos</h1>

        <h1 class="mx-auto text-center p-5 ">A Prefeitura de Mangaratiba, RJ, anuncia a abertura do Processo Seletivo Simplificado. As inscrições estarão disponíveis a partir do dia 4 de maio de 2023. Não perca essa oportunidade de participar do processo seletivo e concorrer a vagas em diversos cargos. Prepare-se e garanta sua inscrição no dia 4 de maio. Fique atento aos requisitos e documentação necessários. Participe do processo seletivo e trilhe seu caminho rumo ao sucesso profissional!</h1>
    
        <a class="min-w-full flex flex-col items-center" target="_blank" href="https://mangaratiba.rj.gov.br/novoportal/assets/cg/_lib/file/doc/arquivos/publicacoes/dom-1803.pdf">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded ">VER EDITAL</button>
        </a>
    </div>

</div>
</div>
</template>

<script>
export default {

}
</script>

<style>

</style>