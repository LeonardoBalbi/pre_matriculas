<template>
  <div class="antialiased bg-gradient-to-br from-indigo-100 via-purple-100 to-green-100 min-h-screen text-body font-body">
    <Preloader v-if="showPreloader" />
    <!-- MENU MODERNO -->
    <nav class="fixed w-full z-50 bg-gradient-to-r from-indigo-700 via-purple-700 to-green-600 shadow-lg">
      <div class="flex items-center justify-between px-6 py-3">
        <a href="#" class="flex items-center gap-2">
          <img src="/img/smeel-branco2.png" class="h-12 w-auto rounded-lg shadow-md" alt="Logo">
        </a>
        <ul class="hidden xl:flex gap-6">
          <li v-for="item in menuItems" :key="item.text">
            <a :href="item.href" class="relative px-3 py-2 text-white font-medium rounded transition duration-200 hover:bg-white/10 hover:text-yellow-300">
              {{ item.text }}
              <span class="absolute left-0 bottom-0 w-0 h-1 bg-yellow-300 transition-all duration-300 group-hover:w-full"></span>
            </a>
          </li>
        </ul>
        <!-- Botão de inscrição destacado -->
        <!-- Linha 20 - Link desktop -->
        <a href="/pre-matricula" class="hidden xl:inline-block ml-4 px-6 py-2 bg-gradient-to-r from-green-400 to-blue-500 text-white font-bold rounded-full shadow-lg hover:scale-105 hover:from-green-500 hover:to-blue-600 transition-all duration-200">
          Fazer Inscrição Online
        </a>

        <!-- Linha 44 - Link mobile -->

        <!-- Menu mobile -->
        <button class="navbar-burger ml-4 block xl:hidden text-white" @click="showMobileMenu = true">
          <svg width="32" height="32" fill="none" viewBox="0 0 32 32"><rect width="32" height="32" rx="6" fill="currentColor" class="text-indigo-700"/><path d="M7 12H25M7 16H25M7 20H25" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
        </button>
      </div>
      <!-- Menu lateral mobile -->
      <transition name="fade">
        <div v-if="showMobileMenu" class="fixed inset-0 z-50 flex xl:hidden">
          <div class="navbar-backdrop fixed inset-0 bg-black opacity-60" @click="showMobileMenu = false"></div>
          <div class="relative bg-gradient-to-b from-indigo-800 via-purple-800 to-green-700 flex-1 max-w-xs w-9/12 h-full overflow-y-auto shadow-2xl">
            <div class="flex flex-col p-8">
              <button class="self-end mb-8 text-white" @click="showMobileMenu = false">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
              <ul class="space-y-6">
                <li v-for="item in menuItems" :key="item.text">
                  <a :href="item.href" class="text-white text-lg font-medium hover:text-yellow-300 transition" @click="showMobileMenu = false">{{ item.text }}</a>
                </li>
                <li>
                  <a href="/pre-matricula" class="block mt-6 px-6 py-2 bg-gradient-to-r from-green-400 to-blue-500 text-white font-bold rounded-full shadow-lg text-center hover:scale-105 hover:from-green-500 hover:to-blue-600 transition-all duration-200">
                    Fazer Inscrição
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </transition>
    </nav>

    <!-- VÍDEO DE FUNDO E TÍTULO -->
    <div class="relative h-screen flex items-center justify-center">
      <video class="absolute inset-0 w-full h-full object-cover brightness-75" autoplay muted loop>
        <source src="/flaro-assets/fundo.mp4" type="video/mp4">
      </video>
      <div class="relative z-10 flex flex-col items-center gap-8">
        <p class="text-white text-5xl md:text-7xl font-extrabold bg-gradient-to-r from-blue-500 via-purple-500 to-green-400 bg-clip-text text-transparent drop-shadow-lg text-center">Pré Matrícula</p>
        <button @click="handleInscricao" class="px-10 py-4 bg-gradient-to-r from-green-400 to-blue-500 text-white font-bold rounded-full shadow-xl text-xl hover:scale-105 hover:from-green-500 hover:to-blue-600 transition-all duration-200">
          Fazer Inscrição
        </button>
    </div>
    </div>

    <section id="publicacao" class="py-16 bg-white">
      <div class="container px-4 mx-auto text-center">
        <h2 class="mb-6 text-4xl md:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-700 via-purple-700 to-green-600">Publicações</h2>
        <p class="text-gray-700 mb-8 font-medium">Acompanhe comunicados, editais e informações oficiais.</p>
        <div class="flex justify-center">
          <a
            href="https://prefeitura.mangaratiba.rj.gov.br/pre-matricula/"
            target="_blank"
            rel="noopener noreferrer"
            class="px-6 py-3 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition"
          >
            Pré-matrícula — Prefeitura de Mangaratiba
          </a>
        </div>
      </div>
    </section>

    <!-- ETAPAS DA PRÉ-MATRÍCULA -->
    <div id="Etapas" class="h-1"></div>
    <section class="py-16 bg-gradient-to-r from-blue-100 via-purple-100 to-green-100">
      <div class="container px-4 mx-auto text-gray-800">
        <div class="max-w-5xl mx-auto text-center mb-16 md:mb-24">
          <h2 class="mb-4 text-4xl md:text-5xl leading-tight font-extrabold tracking-tighter text-transparent bg-clip-text bg-gradient-to-r from-blue-700 via-purple-700 to-green-600">Etapas da Pré-matrícula</h2>
        </div>
        <div class="flex flex-col md:flex-row gap-8 justify-center">
          <div class="flex-1 bg-white rounded-2xl shadow-xl p-8 hover:scale-105 transition-all duration-300">
            <h3 class="text-lg font-semibold mb-2 text-indigo-700">Creche: 6 meses a 03 anos</h3>
            <ul class="list-disc pl-6 text-gray-700">
              <li class="mb-2">É a primeira etapa da Educação Infantil e não é obrigatória por lei (LEI 9394/96).</li>
              <li class="mb-2">Em Mangaratiba essa etapa é oferecida nos Centros de Educação Infantil Municipal – CEIMs.</li>
              <li class="mb-2">Esta etapa tem Critérios de seleção próprios de Pré-Matrícula, Matrícula e outros procedimentos.</li>
            </ul>
          </div>
          <div class="flex-1 bg-white rounded-2xl shadow-xl p-8 hover:scale-105 transition-all duration-300">
            <h3 class="text-lg font-semibold mb-2 text-purple-700">Pré-Escola: 04 a 05 anos</h3>
            <ul class="list-disc pl-6 text-gray-700">
              <li class="mb-2">É a segunda etapa da Educação Infantil e é obrigatória por lei.</li>
              <li class="mb-2">Em Mangaratiba essa etapa é oferecida nas escolas que atendem essa faixa etária.</li>
              <li class="mb-2">Obs.: Nessa etapa Não haverá Pré-Matrícula para os CEIMs.</li>
            </ul>
          </div>
        </div>
        <!-- Etapas detalhadas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-12">
          <div v-for="etapa in etapas" :key="etapa.titulo" class="bg-white rounded-2xl shadow-xl p-8 flex flex-col items-center hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-center w-16 h-16 rounded-full mb-4" :class="etapa.bg">
              <span class="text-xl font-bold text-white">{{ etapa.etapa }}</span>
            </div>
            <h3 class="mb-4 text-lg md:text-xl font-bold text-gray-900 text-center">{{ etapa.titulo }}</h3>
            <p class="text-gray-700 font-medium text-center">{{ etapa.descricao }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- UNIDADES ESCOLARES -->
    <section class="pt-20 pb-36 bg-gradient-to-r from-blue-200 via-purple-100 to-green-100 bg-opacity-80 overflow-hidden" id="UnidadesEscolares">
      <div class="container px-4 mx-auto">
        <h2 class="mb-6 text-5xl md:text-7xl text-center font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-700 via-purple-700 to-green-600">Unidades Escolares</h2>
        <p class="mb-20 text-lg text-center w-full text-gray-800 font-medium leading-normal">Centros de Educação Infantil Municipal – CEIMs.</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Distrito</label>
            <select v-model="filtroDistrito" class="w-full border rounded-md p-2">
              <option value="">Todos</option>
              <option v-for="d in distritos" :key="d" :value="d">{{ d }}</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Bairro</label>
            <select v-model="filtroBairro" class="w-full border rounded-md p-2">
              <option value="">Todos</option>
              <option v-for="b in bairros" :key="b" :value="b">{{ b }}</option>
            </select>
          </div>
          <div class="flex items-end">
            <button class="px-4 py-2 bg-indigo-600 text-white rounded-md" @click="limparFiltros">Limpar filtros</button>
          </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div v-for="(unidade, idx) in unidadesFiltradas" :key="idx" class="bg-white rounded-2xl shadow-xl p-6 flex flex-col items-center hover:scale-105 transition-all duration-300 cursor-pointer" @click="abrirDetalhe(unidade)">
            <img class="w-full h-40 object-cover rounded-xl shadow-md mb-4 hover:brightness-110 transition" :src="unidade.img" :alt="unidade.nome">
            <h3 class="text-lg font-bold text-indigo-700 mb-2 text-center">{{ unidade.nome }}</h3>
            <p class="text-sm text-gray-600 text-center">{{ unidade.endereco }}</p>
          </div>
        </div>
        <transition name="fade">
          <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black opacity-60" @click="fecharDetalhe"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-11/12 p-6">
              <button class="absolute top-3 right-3 text-gray-600" @click="fecharDetalhe">✕</button>
              <img v-if="selectedUnidade?.img" :src="selectedUnidade.img" :alt="selectedUnidade?.nome" class="w-full h-64 object-cover rounded-xl mb-4" />
              <h3 class="text-2xl font-bold text-indigo-700 mb-2">{{ selectedUnidade?.nome }}</h3>
              <p class="text-gray-700 mb-2"><strong>Endereço:</strong> {{ selectedUnidade?.endereco }}</p>
              <p class="text-gray-700" v-if="selectedUnidade?.distrito"><strong>Distrito:</strong> {{ selectedUnidade?.distrito }}</p>
              <p class="text-gray-700" v-if="selectedUnidade?.bairro"><strong>Bairro:</strong> {{ selectedUnidade?.bairro }}</p>
            </div>
          </div>
        </transition>
        <div class="flex justify-center mt-8" v-if="hasMore">
          <button class="px-6 py-3 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 disabled:opacity-50"
                  :disabled="loading" @click="fetchPage">
            {{ loading ? 'Carregando...' : 'Ver mais' }}
          </button>
        </div>
      </div>
    </section>



    <!-- RODAPÉ -->
    <footer class="bg-gradient-to-r from-indigo-700 via-purple-700 to-green-600 py-10 mt-10 shadow-inner">
      <div class="container px-4 mx-auto text-center">
        <p class="text-white text-lg font-medium mb-2">
          Endereço: Praça Robert Simões, nº 92 - Mangaratiba - RJ<br>
          Ramal da Sec. de Educação: 280
        </p>
        <p class="text-white text-sm">© 2025 Todos os direitos reservados: Secretaria de Ciência.</p>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { onMounted, ref, computed } from 'vue';
import Preloader from '@/Components/Preloader.vue';
// Controle do menu mobile
const showMobileMenu = ref(false);
const menuItems = [
  { text: 'Etapas', href: '#Etapas' },
  { text: 'Duvidas', href: '#duvidas' },
  { text: 'Unidades', href: '#UnidadesEscolares' },
  { text: 'Contatos', href: '#contatos' },
  { text: 'Publicação', href: '#publicacao' },
  { text: 'Area do candidato', href: '#candidato' },
];
const etapas = [
  {
    etapa: '1',
    titulo: 'Pré-Matrícula',
    descricao: 'Ler na íntegra e estar de acordo com as regras do Edital. Preencher total e corretamente a ficha de Pré-Matrícula. Ao concluir a Pré-Matrícula, imprimir o Protocolo.',
    bg: 'bg-blue-500',
  },
  {
    etapa: '2',
    titulo: 'Entrega de Documentos',
    descricao: 'Vulnerabilidade social e/ou econômica: entregar documentação na Secretaria Municipal de Educação em até 5 dias após o parecer do CRAS. Deficiência: entregar documentação em até 48h, conforme edital.',
    bg: 'bg-purple-500',
  },
  {
    etapa: '3',
    titulo: 'Classificação',
    descricao: 'Classificação eletrônica pelo sistema, respeitando critérios de prioridade, capacidade das turmas e ordem de inscrição.',
    bg: 'bg-green-500',
  },
  {
    etapa: '4',
    titulo: 'Matrícula',
    descricao: 'Efetivação da matrícula no CEIM classificado após entrega e verificação dos documentos. O não comparecimento implica perda da vaga.',
    bg: 'bg-blue-700',
  },
  {
    etapa: '5',
    titulo: 'Parabéns!',
    descricao: 'Agradecemos a confiança em nosso sistema de ensino, que preza pela qualidade e desenvolvimento das crianças.',
    bg: 'bg-green-700',
  },
];
const showPreloader = ref(false);
function handleInscricao() {
  window.location.href = '/pre-matricula';
}
onMounted(() => {
  window.location.href = '/pre-matricula';
});
// Script de manutenção
onMounted(() => {
  setInterval(async function() {
    try {
      const resp = await fetch('/manutencao-status');
      const data = await resp.json();
      if (data.ativo) {
        window.location.href = '/manutencao';
      }
    } catch (e) {}
  }, 2000);
});
// Lista de unidades escolares (adicione todas que quiser)
const unidades = ref([]);
const page = ref(1);
const perPage = ref(6);
const hasMore = ref(true);
const loading = ref(false);
async function fetchPage() {
  if (loading.value || !hasMore.value) return;
  loading.value = true;
  try {
    const resp = await fetch(`/api/escolas?page=${page.value}&per_page=${perPage.value}`);
    const json = await resp.json();
    const list = (json.data || []).map(e => ({
      id: e.id,
      nome: e.nome,
      endereco: e.endereco,
      img: e.foto_url || '/images/icons/favicon.ico',
      distrito: e.distrito || '',
      bairro: e.bairro || '',
    }));
    unidades.value = [...unidades.value, ...list];
    distritos.value = Array.from(new Set(unidades.value.map(x => x.distrito).filter(Boolean)));
    bairros.value = Array.from(new Set(unidades.value.map(x => x.bairro).filter(Boolean)));
    const meta = json.meta || {};
    hasMore.value = (meta.current_page || 1) < (meta.last_page || 1);
    page.value += 1;
  } catch (err) {
    hasMore.value = false;
  } finally {
    loading.value = false;
  }
}
onMounted(fetchPage);
const filtroDistrito = ref('');
const filtroBairro = ref('');
const distritos = ref([]);
const bairros = ref([]);
const unidadesFiltradas = computed(() => {
  return unidades.value.filter(u => {
    const okD = !filtroDistrito.value || u.distrito === filtroDistrito.value;
    const okB = !filtroBairro.value || u.bairro === filtroBairro.value;
    return okD && okB;
  });
});
function limparFiltros() {
  filtroDistrito.value = '';
  filtroBairro.value = '';
}
const showModal = ref(false);
const selectedUnidade = ref(null);
function abrirDetalhe(u) {
  selectedUnidade.value = u;
  showModal.value = true;
}
function fecharDetalhe() {
  showModal.value = false;
  selectedUnidade.value = null;
}
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>
