@extends('layouts.app')

@section('content')
    <div class="min-vh-100 d-flex flex-column bg-gradient">
        {{-- PRELOADER (opcional) --}}
        <div id="preloader" class="preloader d-none align-items-center justify-content-center">
            <div class="spinner-border text-light" role="status">
                <span class="visually-hidden">Carregando...</span>
            </div>
        </div>

        {{-- NAVBAR --}}
        <nav class="navbar navbar-expand-xl navbar-dark fixed-top bg-gradient-nav shadow">
            <div class="container-fluid px-3 px-md-4">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="/img/smeel-branco2.png" alt="Logo" class="logo-img me-2">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                        aria-controls="mainNavbar" aria-expanded="false" aria-label="Alternar navegação">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="mainNavbar">
                    <ul class="navbar-nav ms-auto mb-2 mb-xl-0 me-xl-3">
                        <li class="nav-item"><a class="nav-link" href="#Etapas">Etapas</a></li>
                        <li class="nav-item"><a class="nav-link" href="#duvidas">Dúvidas</a></li>
                        <li class="nav-item"><a class="nav-link" href="#UnidadesEscolares">Unidades</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contatos">Contatos</a></li>
                        <li class="nav-item"><a class="nav-link" href="#publicacao">Publicação</a></li>
                        <li class="nav-item"><a class="nav-link" href="#candidato">Área do candidato</a></li>
                    </ul>

                    <a href="/pre-matricula"
                       class="btn btn-inscricao d-none d-xl-inline-block">
                        Fazer Inscrição Online
                    </a>
                </div>
            </div>
        </nav>

        {{-- HERO COM VÍDEO --}}
        <section class="hero-section d-flex align-items-center justify-content-center text-center text-white">
            <video class="hero-video" autoplay muted loop>
                <source src="/flaro-assets/fundo.mp4" type="video/mp4">
            </video>
            <div class="hero-overlay"></div>
            <div class="container position-relative hero-content">
                <h1 class="display-3 display-md-1 fw-bold text-gradient mb-4">
                    Pré Matrícula
                </h1>
                <button id="btnInscricao" class="btn btn-inscricao btn-lg">
                    Fazer Inscrição
                </button>
            </div>
        </section>

        {{-- PUBLICAÇÕES --}}
        <section id="publicacao" class="py-5 bg-white">
            <div class="container text-center">
                <h2 class="display-6 fw-bold text-gradient-title mb-3">Publicações</h2>
                <p class="text-muted mb-4 fw-medium">
                    Acompanhe comunicados, editais e informações oficiais.
                </p>
                <a href="https://prefeitura.mangaratiba.rj.gov.br/pre-matricula/"
                   target="_blank" rel="noopener noreferrer"
                   class="btn btn-primary">
                    Pré-matrícula — Prefeitura de Mangaratiba
                </a>
            </div>
        </section>

        {{-- ETAPAS DA PRÉ-MATRÍCULA --}}
        <div id="Etapas"></div>
        <section class="py-5 bg-gradient-soft">
            <div class="container text-center text-dark">
                <div class="mx-auto mb-5" style="max-width: 800px;">
                    <h2 class="display-6 fw-bold text-gradient-title mb-3">
                        Etapas da Pré-matrícula
                    </h2>
                </div>

                <div class="row g-4 justify-content-center">
                    <div class="col-md-6">
                        <div class="card h-100 shadow-lg border-0">
                            <div class="card-body p-4 text-start">
                                <h3 class="h5 fw-semibold text-primary mb-3">
                                    Creche: 6 meses a 03 anos
                                </h3>
                                <ul class="ps-3">
                                    <li class="mb-2">
                                        É a primeira etapa da Educação Infantil e não é obrigatória por lei (LEI 9394/96).
                                    </li>
                                    <li class="mb-2">
                                        Em Mangaratiba essa etapa é oferecida nos Centros de Educação Infantil Municipal – CEIMs.
                                    </li>
                                    <li class="mb-2">
                                        Esta etapa tem Critérios de seleção próprios de Pré-Matrícula, Matrícula e outros procedimentos.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 shadow-lg border-0">
                            <div class="card-body p-4 text-start">
                                <h3 class="h5 fw-semibold text-purple mb-3">
                                    Pré-Escola: 04 a 05 anos
                                </h3>
                                <ul class="ps-3">
                                    <li class="mb-2">
                                        É a segunda etapa da Educação Infantil e é obrigatória por lei.
                                    </li>
                                    <li class="mb-2">
                                        Em Mangaratiba essa etapa é oferecida nas escolas que atendem essa faixa etária.
                                    </li>
                                    <li class="mb-2">
                                        Obs.: Nessa etapa Não haverá Pré-Matrícula para os CEIMs.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Cards das etapas (1 a 5) --}}
                <div class="row row-cols-1 row-cols-md-3 g-4 mt-4">
                    @php
                        $etapas = [
                            [
                                'etapa' => '1',
                                'titulo' => 'Pré-Matrícula',
                                'descricao' => 'Ler o edital, preencher corretamente a ficha e imprimir o protocolo.',
                                'bg' => 'bg-primary',
                            ],
                            [
                                'etapa' => '2',
                                'titulo' => 'Entrega de Documentos',
                                'descricao' => 'Entrega da documentação exigida em caso de vulnerabilidade ou deficiência, conforme edital.',
                                'bg' => 'bg-purple',
                            ],
                            [
                                'etapa' => '3',
                                'titulo' => 'Classificação',
                                'descricao' => 'Classificação eletrônica respeitando critérios de prioridade e capacidade das turmas.',
                                'bg' => 'bg-success',
                            ],
                            [
                                'etapa' => '4',
                                'titulo' => 'Matrícula',
                                'descricao' => 'Efetivação da matrícula no CEIM classificado após conferência de documentos.',
                                'bg' => 'bg-primary-dark',
                            ],
                            [
                                'etapa' => '5',
                                'titulo' => 'Parabéns!',
                                'descricao' => 'Agradecimento pela confiança no sistema de ensino do município.',
                                'bg' => 'bg-success-dark',
                            ],
                        ];
                    @endphp

                    @foreach ($etapas as $etapa)
                        <div class="col">
                            <div class="card h-100 shadow-lg border-0 text-center p-4">
                                <div class="d-flex align-items-center justify-content-center rounded-circle mb-3 etapa-circle {{ $etapa['bg'] }}">
                                    <span class="fw-bold text-white fs-4">{{ $etapa['etapa'] }}</span>
                                </div>
                                <h3 class="h5 fw-bold mb-2">{{ $etapa['titulo'] }}</h3>
                                <p class="text-muted mb-0">{{ $etapa['descricao'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- UNIDADES ESCOLARES --}}
        <section id="UnidadesEscolares" class="pt-5 pb-5 bg-gradient-soft-2">
            <div class="container">
                <h2 class="display-5 fw-bold text-gradient-title text-center mb-3">
                    Unidades Escolares
                </h2>
                <p class="text-center text-muted mb-4">
                    Centros de Educação Infantil Municipal – CEIMs.
                </p>

                {{-- Filtros --}}
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Distrito</label>
                        <select id="filtroDistrito" class="form-select">
                            <option value="">Todos</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Bairro</label>
                        <select id="filtroBairro" class="form-select">
                            <option value="">Todos</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button id="btnLimparFiltros" class="btn btn-outline-primary w-100">
                            Limpar filtros
                        </button>
                    </div>
                </div>

                {{-- Grid de unidades --}}
                <div class="row g-4" id="gridUnidades">
                    {{-- Itens carregados via JS --}}
                </div>

                <div class="d-flex justify-content-center mt-4">
                    <button id="btnVerMais" class="btn btn-primary px-4"
                            data-loading-text="Carregando...">
                        Ver mais
                    </button>
                </div>
            </div>
        </section>

        {{-- MODAL UNIDADE --}}
        <div class="modal fade" id="unidadeModal" tabindex="-1" aria-labelledby="unidadeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="unidadeModalLabel">Unidade Escolar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <img id="unidadeImg" src="" alt="" class="img-fluid rounded mb-3 d-none">
                        <h4 id="unidadeNome" class="fw-bold text-primary mb-2"></h4>
                        <p class="mb-1"><strong>Endereço:</strong> <span id="unidadeEndereco"></span></p>
                        <p class="mb-0 d-none" id="unidadeDistritoRow">
                            <strong>Distrito:</strong> <span id="unidadeDistrito"></span>
                        </p>
                        <p class="mb-0 d-none" id="unidadeBairroRow">
                            <strong>Bairro:</strong> <span id="unidadeBairro"></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- RODAPÉ --}}
        <footer class="footer-gradient text-white py-4 mt-auto">
            <div class="container text-center">
                <p class="mb-2">
                    Endereço: Praça Robert Simões, nº 92 - Mangaratiba - RJ<br>
                    Ramal da Sec. de Educação: 280
                </p>
                <p class="mb-0 small">
                    © 2025 Todos os direitos reservados: Secretaria de Ciência.
                </p>
            </div>
        </footer>
    </div>

    {{-- SCRIPTS ESPECÍFICOS --}}
    @push('scripts')
        <script>
            (function () {
                const btnInscricao = document.getElementById('btnInscricao');
                if (btnInscricao) {
                    btnInscricao.addEventListener('click', function () {
                        window.location.href = '/pre-matricula';
                    });
                }

                // Manutenção (replica lógica do Vue)
                setInterval(async function () {
                    try {
                        const resp = await fetch('/manutencao-status');
                        const data = await resp.json();
                        if (data.ativo) {
                            window.location.href = '/manutencao';
                        }
                    } catch (e) {
                        // silencioso
                    }
                }, 2000);

                // Unidades escolares
                let page = 1;
                const perPage = 6;
                let hasMore = true;
                let loading = false;
                let unidades = [];

                const grid = document.getElementById('gridUnidades');
                const btnVerMais = document.getElementById('btnVerMais');
                const filtroDistrito = document.getElementById('filtroDistrito');
                const filtroBairro = document.getElementById('filtroBairro');

                async function fetchPage() {
                    if (loading || !hasMore) return;
                    loading = true;
                    const originalText = btnVerMais.textContent;
                    btnVerMais.textContent = btnVerMais.getAttribute('data-loading-text');
                    try {
                        const resp = await fetch(`/api/escolas?page=${page}&per_page=${perPage}`);
                        const json = await resp.json();
                        const list = (json.data || []).map(e => ({
                            id: e.id,
                            nome: e.nome,
                            endereco: e.endereco,
                            img: e.foto_url || '/images/icons/favicon.ico',
                            distrito: e.distrito || '',
                            bairro: e.bairro || '',
                        }));
                        unidades = unidades.concat(list);
                        atualizarFiltros();
                        renderGrid();
                        const meta = json.meta || {};
                        hasMore = (meta.current_page || 1) < (meta.last_page || 1);
                        page++;
                        if (!hasMore) {
                            btnVerMais.classList.add('d-none');
                        }
                    } catch (e) {
                        hasMore = false;
                        btnVerMais.classList.add('d-none');
                    } finally {
                        loading = false;
                        btnVerMais.textContent = originalText;
                    }
                }

                function atualizarFiltros() {
                    const distritos = [...new Set(unidades.map(u => u.distrito).filter(Boolean))];
                    const bairros = [...new Set(unidades.map(u => u.bairro).filter(Boolean))];

                    preencherSelect(filtroDistrito, distritos);
                    preencherSelect(filtroBairro, bairros);
                }

                function preencherSelect(select, valores) {
                    const valorAtual = select.value;
                    select.innerHTML = '<option value=\"\">Todos</option>';
                    valores.forEach(v => {
                        const opt = document.createElement('option');
                        opt.value = v;
                        opt.textContent = v;
                        select.appendChild(opt);
                    });
                    if (valores.includes(valorAtual)) {
                        select.value = valorAtual;
                    }
                }

                function unidadesFiltradas() {
                    return unidades.filter(u => {
                        const okD = !filtroDistrito.value || u.distrito === filtroDistrito.value;
                        const okB = !filtroBairro.value || u.bairro === filtroBairro.value;
                        return okD && okB;
                    });
                }

                function renderGrid() {
                    if (!grid) return;
                    grid.innerHTML = '';
                    unidadesFiltradas().forEach(u => {
                        const col = document.createElement('div');
                        col.className = 'col-md-6 col-lg-4';
                        col.innerHTML = `
                            <div class="card h-100 shadow-sm unidade-card" data-id="${u.id}">
                                <img src="${u.img}" class="card-img-top unidade-img" alt="${u.nome}">
                                <div class="card-body text-center">
                                    <h5 class="card-title text-primary fw-bold">${u.nome}</h5>
                                    <p class="card-text text-muted small mb-0">${u.endereco || ''}</p>
                                </div>
                            </div>
                        `;
                        grid.appendChild(col);
                        col.querySelector('.unidade-card').addEventListener('click', () => abrirDetalhe(u));
                    });
                }

                if (btnVerMais) {
                    btnVerMais.addEventListener('click', fetchPage);
                }

                const btnLimparFiltros = document.getElementById('btnLimparFiltros');
                if (btnLimparFiltros) {
                    btnLimparFiltros.addEventListener('click', () => {
                        filtroDistrito.value = '';
                        filtroBairro.value = '';
                        renderGrid();
                    });
                }

                function abrirDetalhe(u) {
                    const modalEl = document.getElementById('unidadeModal');
                    if (!modalEl) return;
                    document.getElementById('unidadeNome').textContent = u.nome || '';
                    document.getElementById('unidadeEndereco').textContent = u.endereco || '';

                    const imgEl = document.getElementById('unidadeImg');
                    if (u.img) {
                        imgEl.src = u.img;
                        imgEl.classList.remove('d-none');
                    } else {
                        imgEl.classList.add('d-none');
                    }

                    const distritoRow = document.getElementById('unidadeDistritoRow');
                    const bairroRow = document.getElementById('unidadeBairroRow');
                    const distritoSpan = document.getElementById('unidadeDistrito');
                    const bairroSpan = document.getElementById('unidadeBairro');

                    if (u.distrito) {
                        distritoSpan.textContent = u.distrito;
                        distritoRow.classList.remove('d-none');
                    } else {
                        distritoRow.classList.add('d-none');
                    }
                    if (u.bairro) {
                        bairroSpan.textContent = u.bairro;
                        bairroRow.classList.remove('d-none');
                    } else {
                        bairroRow.classList.add('d-none');
                    }

                    const modal = new bootstrap.Modal(modalEl);
                    modal.show();
                }

                // Carrega a primeira página ao abrir
                fetchPage();
            })();
        </script>
    @endpush
@endsection

@push('styles')
    <style>
        .bg-gradient {
            background: linear-gradient(135deg, #e0e7ff, #ede9fe, #dcfce7);
        }
        .bg-gradient-nav {
            background: linear-gradient(90deg, #4338ca, #6d28d9, #16a34a);
        }
        .bg-gradient-soft {
            background: linear-gradient(135deg, #dbeafe, #ede9fe, #dcfce7);
        }
        .bg-gradient-soft-2 {
            background: linear-gradient(135deg, #bfdbfe, #e9d5ff, #bbf7d0);
        }
        .footer-gradient {
            background: linear-gradient(90deg, #4338ca, #6d28d9, #16a34a);
        }
        .logo-img {
            height: 48px;
            width: auto;
            border-radius: .5rem;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,.25);
        }
        .btn-inscricao {
            background: linear-gradient(90deg, #22c55e, #3b82f6);
            color: #fff;
            font-weight: 700;
            border-radius: 999px;
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.25);
            border: none;
        }
        .btn-inscricao:hover {
            transform: scale(1.03);
            background: linear-gradient(90deg, #16a34a, #2563eb);
            color: #fff;
        }
        .hero-section {
            position: relative;
            min-height: 100vh;
            margin-top: 56px; /* altura aproximada da navbar */
        }
        .hero-video {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(.75);
        }
        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(15,23,42,.6), rgba(30,64,175,.4));
        }
        .hero-content {
            position: relative;
            z-index: 2;
        }
        .text-gradient {
            background: linear-gradient(90deg, #3b82f6, #8b5cf6, #22c55e);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .text-gradient-title {
            background: linear-gradient(90deg, #1d4ed8, #7e22ce, #15803d);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .bg-purple { background-color: #7c3aed; }
        .bg-primary-dark { background-color: #1d4ed8; }
        .bg-success-dark { background-color: #166534; }
        .etapa-circle {
            width: 64px;
            height: 64px;
        }
        .unidade-img {
            height: 190px;
            object-fit: cover;
        }
        .unidade-card {
            cursor: pointer;
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .unidade-card:hover {
            transform: scale(1.02);
            box-shadow: 0 .75rem 1.5rem rgba(0,0,0,.15);
        }
        .preloader {
            position: fixed;
            inset: 0;
            background: rgba(15,23,42,.7);
            z-index: 1055;
        }
    </style>
@endpush

