@extends('layouts.app')

@section('content')
    <div x-data="{ showPreloader: true }" x-init="setTimeout(() => showPreloader = false, 500)" class="min-vh-100 d-flex flex-column bg-gradient antialiased text-body font-body">
        {{-- PRELOADER --}}
        <div x-show="showPreloader" class="preloader fixed inset-0 z-[100] bg-slate-900/70 flex items-center justify-center">
            <div class="spinner-border text-light" role="status">
                <span class="visually-hidden">Carregando...</span>
            </div>
        </div>

        {{-- NAVBAR --}}
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow-lg" style="background: linear-gradient(to right, #4338ca, #6d28d9, #16a34a) !important; z-index: 1050 !important; display: block !important;">
            <div class="container-fluid px-3 px-md-4">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="/img/smeel-branco2.png" alt="Logo" style="height: 48px !important; width: auto !important;" class="rounded shadow-sm">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                        aria-controls="mainNavbar" aria-expanded="false" aria-label="Alternar navegação">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse show" id="mainNavbar">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 me-lg-3 gap-lg-3">
                        <li class="nav-item"><a class="nav-link text-white fw-bold active" style="font-size: 1rem !important; opacity: 1 !important; visibility: visible !important;" href="#Etapas">Etapas</a></li>
                        <li class="nav-item"><a class="nav-link text-white fw-bold active" style="font-size: 1rem !important; opacity: 1 !important; visibility: visible !important;" href="#duvidas">Dúvidas</a></li>
                        <li class="nav-item"><a class="nav-link text-white fw-bold active" style="font-size: 1rem !important; opacity: 1 !important; visibility: visible !important;" href="#UnidadesEscolares">Unidades</a></li>
                        <li class="nav-item"><a class="nav-link text-white fw-bold active" style="font-size: 1rem !important; opacity: 1 !important; visibility: visible !important;" href="#contatos">Contatos</a></li>
                        <li class="nav-item"><a class="nav-link text-white fw-bold active" style="font-size: 1rem !important; opacity: 1 !important; visibility: visible !important;" href="#publicacao">Publicação</a></li>
                        <li class="nav-item"><a class="nav-link text-white fw-bold active" style="font-size: 1rem !important; opacity: 1 !important; visibility: visible !important;" href="{{ route('register.pre-matricula.status') }}">Área do candidato</a></li>
                    </ul>

                    <a href="/pre-matricula"
                       class="btn text-white d-inline-block px-4 py-2"
                       style="background: linear-gradient(to right, #4ade80, #3b82f6) !important; border: none !important; border-radius: 9999px !important; font-weight: bold !important; visibility: visible !important; display: inline-block !important;">
                        Fazer Inscrição Online
                    </a>
                </div>
            </div>
        </nav>

        {{-- HERO COM VÍDEO --}}
        <section class="hero-section d-flex align-items-center justify-content-center text-center text-white relative h-screen">
            <video class="absolute inset-0 w-full h-full object-cover brightness-75" autoplay muted loop>
                <source src="/flaro-assets/fundo.mp4" type="video/mp4">
            </video>
            <div class="relative z-10 flex flex-col items-center gap-8 px-4">
                <h1 class="text-white text-5xl md:text-7xl font-extrabold bg-gradient-to-r from-blue-500 via-purple-500 to-green-400 bg-clip-text text-transparent drop-shadow-lg text-center leading-tight">
                    Pré Matrícula
                </h1>
                <a href="/pre-matricula" class="px-10 py-4 bg-gradient-to-r from-green-400 to-blue-500 text-white font-bold rounded-full shadow-xl text-xl hover:scale-105 hover:from-green-500 hover:to-blue-600 transition-all duration-200 no-underline">
                    Fazer Inscrição
                </a>
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
        <div id="duvidas"></div>
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
                @php
                    $distritos = $escolas->pluck('distrito')->filter()->unique()->sort()->values();
                    $bairros = $escolas->pluck('bairro')->filter()->unique()->sort()->values();
                @endphp
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Distrito</label>
                        <select id="filtroDistrito" class="form-select">
                            <option value="">Todos</option>
                            @foreach($distritos as $distrito)
                                <option value="{{ $distrito }}">{{ $distrito }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Bairro</label>
                        <select id="filtroBairro" class="form-select">
                            <option value="">Todos</option>
                            @foreach($bairros as $bairro)
                                <option value="{{ $bairro }}">{{ $bairro }}</option>
                            @endforeach
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
                    @foreach($escolas as $unidade)
                        <div class="col-md-6 col-lg-4 unidade-item"
                             data-distrito="{{ $unidade['distrito'] ?? '' }}"
                             data-bairro="{{ $unidade['bairro'] ?? '' }}">
                            <div class="card h-100 shadow-sm unidade-card"
                                 data-id="{{ $unidade['id'] }}"
                                 data-nome="{{ $unidade['nome'] }}"
                                 data-endereco="{{ $unidade['endereco'] ?? '' }}"
                                 data-img="{{ $unidade['foto_url'] ?? '/images/icons/favicon.ico' }}"
                                 data-distrito="{{ $unidade['distrito'] ?? '' }}"
                                 data-bairro="{{ $unidade['bairro'] ?? '' }}">
                                <img src="{{ $unidade['foto_url'] ?? '/images/icons/favicon.ico' }}"
                                     class="card-img-top unidade-img"
                                     alt="{{ $unidade['nome'] }}"
                                     onerror="this.src='/images/icons/favicon.ico'">
                                <div class="card-body text-center">
                                    <h5 class="card-title text-primary fw-bold">{{ $unidade['nome'] }}</h5>
                                    <p class="card-text text-muted small mb-0">{{ $unidade['endereco'] ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
        <footer id="contatos" class="footer-gradient text-white py-4 mt-auto">
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
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="{{ asset('js/bot_educacao.js') }}"></script>
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

                // Filtros e modal das unidades escolares (dados já carregados via PHP)
                const grid = document.getElementById('gridUnidades');
                const filtroDistrito = document.getElementById('filtroDistrito');
                const filtroBairro = document.getElementById('filtroBairro');
                const btnLimparFiltros = document.getElementById('btnLimparFiltros');

                function filtrarUnidades() {
                    if (!grid) return;
                    const distritoSelecionado = filtroDistrito ? filtroDistrito.value : '';
                    const bairroSelecionado = filtroBairro ? filtroBairro.value : '';

                    const itens = grid.querySelectorAll('.unidade-item');
                    itens.forEach(item => {
                        const distrito = item.getAttribute('data-distrito') || '';
                        const bairro = item.getAttribute('data-bairro') || '';

                        const okDistrito = !distritoSelecionado || distrito === distritoSelecionado;
                        const okBairro = !bairroSelecionado || bairro === bairroSelecionado;

                        if (okDistrito && okBairro) {
                            item.style.display = '';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                }

                if (filtroDistrito) {
                    filtroDistrito.addEventListener('change', filtrarUnidades);
                }
                if (filtroBairro) {
                    filtroBairro.addEventListener('change', filtrarUnidades);
                }
                if (btnLimparFiltros) {
                    btnLimparFiltros.addEventListener('click', () => {
                        if (filtroDistrito) filtroDistrito.value = '';
                        if (filtroBairro) filtroBairro.value = '';
                        filtrarUnidades();
                    });
                }

                // Modal de detalhes
                const cards = document.querySelectorAll('.unidade-card');
                cards.forEach(card => {
                    card.addEventListener('click', function() {
                        const modalEl = document.getElementById('unidadeModal');
                        if (!modalEl) return;

                        document.getElementById('unidadeNome').textContent = this.getAttribute('data-nome') || '';
                        document.getElementById('unidadeEndereco').textContent = this.getAttribute('data-endereco') || '';

                        const imgEl = document.getElementById('unidadeImg');
                        const imgSrc = this.getAttribute('data-img');
                        if (imgSrc) {
                            imgEl.src = imgSrc;
                            imgEl.classList.remove('d-none');
                        } else {
                            imgEl.classList.add('d-none');
                        }

                        const distritoRow = document.getElementById('unidadeDistritoRow');
                        const bairroRow = document.getElementById('unidadeBairroRow');
                        const distritoSpan = document.getElementById('unidadeDistrito');
                        const bairroSpan = document.getElementById('unidadeBairro');

                        const distrito = this.getAttribute('data-distrito');
                        const bairro = this.getAttribute('data-bairro');

                        if (distrito) {
                            distritoSpan.textContent = distrito;
                            distritoRow.classList.remove('d-none');
                        } else {
                            distritoRow.classList.add('d-none');
                        }
                        if (bairro) {
                            bairroSpan.textContent = bairro;
                            bairroRow.classList.remove('d-none');
                        } else {
                            bairroRow.classList.add('d-none');
                        }

                        const modal = new bootstrap.Modal(modalEl);
                        modal.show();
                    });
                });
            })();
        </script>
    @endpush

@push('scripts')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="{{ asset('js/bot_educacao.js') }}"></script>
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
