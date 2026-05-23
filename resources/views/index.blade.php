@extends('layouts.app')

@section('content')
@php
    $totalEscolas = $escolas->count();
    $distritos = $escolas->pluck('distrito')->filter()->unique()->sort()->values();
    $bairros = $escolas->pluck('bairro')->filter()->unique()->sort()->values();
    $heroImage = '/flaro-assets/images/blog/ceim-aarao-de-moura-brito-filho.jpg';
@endphp

<div class="home-page">
    <nav class="home-nav">
        <div class="container nav-inner">
            <a class="brand-link" href="{{ url('/') }}" aria-label="Inicio">
                <img src="/img/logo_governo_azul.png" onerror="this.src='/img/brasao-pmm-smeel-black.png'" alt="Prefeitura de Mangaratiba">
            </a>
            <div class="nav-links">
                <a href="#etapas">Etapas</a>
                <a href="#unidades">Unidades</a>
                <a href="#publicacao">Publicacao</a>
                <a href="{{ route('register.pre-matricula.status') }}">Area do candidato</a>
                <a class="btn btn-light nav-cta" href="/pre-matricula">Fazer inscricao</a>
            </div>
        </div>
    </nav>

    <header class="hero">
        <img src="{{ $heroImage }}" alt="Unidade de educacao infantil em Mangaratiba" class="hero-image">
        <div class="hero-shade"></div>
        <div class="container hero-content">
            <div class="hero-copy">
                <span class="eyebrow">Pre-matricula {{ date('Y') }}</span>
                <h1>Educacao infantil em Mangaratiba</h1>
                <p>Consulte as unidades, leia as orientacoes e realize a pre-matricula online com mais clareza e agilidade.</p>
                <div class="hero-actions">
                    <a class="btn btn-primary btn-lg" href="/pre-matricula">Iniciar pre-matricula</a>
                    <a class="btn btn-outline-light btn-lg" href="{{ route('register.pre-matricula.status') }}">Acompanhar inscricao</a>
                </div>
            </div>
            <div class="hero-panel">
                <div class="metric">
                    <strong>{{ $totalEscolas }}</strong>
                    <span>unidades listadas</span>
                </div>
                <div class="metric">
                    <strong>{{ $distritos->count() }}</strong>
                    <span>distritos atendidos</span>
                </div>
                <div class="metric">
                    <strong>31/03</strong>
                    <span>data-base de idade</span>
                </div>
            </div>
        </div>
    </header>

    <main>
        <section id="publicacao" class="section publication-section">
            <div class="container section-grid">
                <div>
                    <span class="section-kicker">Informacao oficial</span>
                    <h2>Publicacoes e edital</h2>
                    <p class="section-text">Acompanhe comunicados, editais e orientacoes publicados pela Prefeitura de Mangaratiba.</p>
                </div>
                <div class="publication-card">
                    <strong>Pre-matricula</strong>
                    <p>Leia as informacoes oficiais antes de preencher o formulario.</p>
                    <a href="https://prefeitura.mangaratiba.rj.gov.br/pre-matricula/" target="_blank" rel="noopener" class="btn btn-outline-primary">
                        Abrir publicacao
                    </a>
                </div>
            </div>
        </section>

        <section id="etapas" class="section">
            <div class="container">
                <div class="section-heading">
                    <span class="section-kicker">Como funciona</span>
                    <h2>Etapas da pre-matricula</h2>
                    <p>O processo organiza inscricao, analise e efetivacao da matricula conforme os criterios do edital.</p>
                </div>

                <div class="track-grid">
                    <article class="track-card">
                        <h3>Creche: 6 meses a 3 anos</h3>
                        <p>Atendimento nos CEIMs com criterios proprios de selecao, documentacao e acompanhamento.</p>
                    </article>
                    <article class="track-card">
                        <h3>Pre-escola: 4 a 5 anos</h3>
                        <p>Etapa obrigatoria da Educacao Infantil, atendida pelas unidades que oferecem essa faixa etaria.</p>
                    </article>
                </div>

                <div class="steps-grid">
                    @foreach ([
                        ['1', 'Pre-matricula', 'Preencha a ficha online e guarde o protocolo.'],
                        ['2', 'Documentos', 'Entregue os documentos exigidos quando solicitado.'],
                        ['3', 'Classificacao', 'A classificacao considera criterios do edital e vagas disponiveis.'],
                        ['4', 'Matricula', 'Efetive a matricula na unidade classificada apos a validacao.'],
                        ['5', 'Acompanhamento', 'Consulte o status pelo protocolo ou CPF do candidato.'],
                    ] as $step)
                        <article class="step-card">
                            <span>{{ $step[0] }}</span>
                            <h3>{{ $step[1] }}</h3>
                            <p>{{ $step[2] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="unidades" class="section units-section">
            <div class="container">
                <div class="section-heading">
                    <span class="section-kicker">Rede municipal</span>
                    <h2>Unidades escolares</h2>
                    <p>Filtre por distrito ou bairro e veja os dados principais de cada unidade.</p>
                </div>

                <div class="filter-panel">
                    <div>
                        <label class="form-label" for="filtroDistrito">Distrito</label>
                        <select id="filtroDistrito" class="form-select">
                            <option value="">Todos</option>
                            @foreach($distritos as $distrito)
                                <option value="{{ $distrito }}">{{ $distrito }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label" for="filtroBairro">Bairro</label>
                        <select id="filtroBairro" class="form-select">
                            <option value="">Todos</option>
                            @foreach($bairros as $bairro)
                                <option value="{{ $bairro }}">{{ $bairro }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-actions">
                        <button id="btnLimparFiltros" class="btn btn-outline-secondary" type="button">Limpar</button>
                    </div>
                </div>

                <div class="unit-count" id="unitCount">{{ $totalEscolas }} unidades encontradas</div>

                <div class="units-grid" id="gridUnidades">
                    @foreach($escolas as $unidade)
                        <article class="unit-card unidade-item"
                            data-distrito="{{ $unidade['distrito'] ?? '' }}"
                            data-bairro="{{ $unidade['bairro'] ?? '' }}">
                            <button type="button"
                                class="unit-card-button unidade-card"
                                data-id="{{ $unidade['id'] }}"
                                data-nome="{{ $unidade['nome'] }}"
                                data-endereco="{{ $unidade['endereco'] ?? '' }}"
                                data-img="{{ $unidade['foto_url'] ?? '/flaro-assets/images/blog/ceim-aarao-de-moura-brito-filho.jpg' }}"
                                data-distrito="{{ $unidade['distrito'] ?? '' }}"
                                data-bairro="{{ $unidade['bairro'] ?? '' }}">
                                <img src="{{ $unidade['foto_url'] ?? '/flaro-assets/images/blog/ceim-aarao-de-moura-brito-filho.jpg' }}"
                                    alt="{{ $unidade['nome'] }}"
                                    onerror="this.src='/flaro-assets/images/blog/ceim-aarao-de-moura-brito-filho.jpg'">
                                <span class="unit-body">
                                    <strong>{{ $unidade['nome'] }}</strong>
                                    <small>{{ $unidade['endereco'] ?? 'Endereco nao informado' }}</small>
                                    <span class="unit-meta">
                                        {{ $unidade['bairro'] ?? 'Bairro nao informado' }}
                                        @if(!empty($unidade['distrito']))
                                            · {{ $unidade['distrito'] }}
                                        @endif
                                    </span>
                                </span>
                            </button>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

    <div class="modal fade" id="unidadeModal" tabindex="-1" aria-labelledby="unidadeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content unit-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="unidadeModalLabel">Unidade escolar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <img id="unidadeImg" src="" alt="" class="modal-unit-img d-none">
                    <h4 id="unidadeNome" class="fw-bold mb-2"></h4>
                    <p class="mb-2"><strong>Endereco:</strong> <span id="unidadeEndereco"></span></p>
                    <p class="mb-1 d-none" id="unidadeDistritoRow"><strong>Distrito:</strong> <span id="unidadeDistrito"></span></p>
                    <p class="mb-0 d-none" id="unidadeBairroRow"><strong>Bairro:</strong> <span id="unidadeBairro"></span></p>
                </div>
            </div>
        </div>
    </div>

    <footer id="contatos" class="home-footer">
        <div class="container footer-inner">
            <div>
                <strong>Secretaria Municipal de Educacao</strong>
                <span>Praca Robert Simoes, nº 92 - Mangaratiba - RJ</span>
            </div>
            <a href="/pre-matricula" class="btn btn-light">Fazer inscricao</a>
        </div>
    </footer>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        setInterval(async function () {
            try {
                const resp = await fetch('/manutencao-status');
                const data = await resp.json();
                if (data.ativo) {
                    window.location.href = '/manutencao';
                }
            } catch (e) {}
        }, 5000);

        const grid = document.getElementById('gridUnidades');
        const filtroDistrito = document.getElementById('filtroDistrito');
        const filtroBairro = document.getElementById('filtroBairro');
        const btnLimparFiltros = document.getElementById('btnLimparFiltros');
        const unitCount = document.getElementById('unitCount');

        function filtrarUnidades() {
            if (!grid) return;

            const distritoSelecionado = filtroDistrito ? filtroDistrito.value : '';
            const bairroSelecionado = filtroBairro ? filtroBairro.value : '';
            const itens = grid.querySelectorAll('.unidade-item');
            let visiveis = 0;

            itens.forEach(item => {
                const distrito = item.getAttribute('data-distrito') || '';
                const bairro = item.getAttribute('data-bairro') || '';
                const okDistrito = !distritoSelecionado || distrito === distritoSelecionado;
                const okBairro = !bairroSelecionado || bairro === bairroSelecionado;
                const mostrar = okDistrito && okBairro;

                item.hidden = !mostrar;
                if (mostrar) visiveis++;
            });

            if (unitCount) {
                unitCount.textContent = visiveis + (visiveis === 1 ? ' unidade encontrada' : ' unidades encontradas');
            }
        }

        if (filtroDistrito) filtroDistrito.addEventListener('change', filtrarUnidades);
        if (filtroBairro) filtroBairro.addEventListener('change', filtrarUnidades);
        if (btnLimparFiltros) {
            btnLimparFiltros.addEventListener('click', () => {
                if (filtroDistrito) filtroDistrito.value = '';
                if (filtroBairro) filtroBairro.value = '';
                filtrarUnidades();
            });
        }

        document.querySelectorAll('.unidade-card').forEach(card => {
            card.addEventListener('click', function () {
                const modalEl = document.getElementById('unidadeModal');
                if (!modalEl) return;

                document.getElementById('unidadeNome').textContent = this.getAttribute('data-nome') || '';
                document.getElementById('unidadeEndereco').textContent = this.getAttribute('data-endereco') || 'Endereco nao informado';

                const imgEl = document.getElementById('unidadeImg');
                const imgSrc = this.getAttribute('data-img');
                if (imgSrc) {
                    imgEl.src = imgSrc;
                    imgEl.alt = this.getAttribute('data-nome') || 'Unidade escolar';
                    imgEl.classList.remove('d-none');
                } else {
                    imgEl.classList.add('d-none');
                }

                const distrito = this.getAttribute('data-distrito');
                const bairro = this.getAttribute('data-bairro');
                const distritoRow = document.getElementById('unidadeDistritoRow');
                const bairroRow = document.getElementById('unidadeBairroRow');

                document.getElementById('unidadeDistrito').textContent = distrito || '';
                document.getElementById('unidadeBairro').textContent = bairro || '';
                distritoRow.classList.toggle('d-none', !distrito);
                bairroRow.classList.toggle('d-none', !bairro);

                new bootstrap.Modal(modalEl).show();
            });
        });
    })();
</script>
@endpush

@push('styles')
<style>
    :root {
        --ink: #132238;
        --muted: #64748b;
        --line: #d8e0ea;
        --surface: #ffffff;
        --soft: #f5f8fc;
        --primary: #145ab8;
        --primary-dark: #083f86;
        --accent: #00a3d7;
        --success: #147d64;
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        color: var(--ink);
        background: #f5f8fc;
        font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .home-page {
        min-height: 100vh;
        background: #f5f8fc;
    }

    .home-nav {
        position: sticky;
        top: 0;
        z-index: 50;
        background: linear-gradient(90deg, rgba(3, 44, 91, .98) 0%, rgba(8, 63, 134, .98) 54%, rgba(20, 90, 184, .98) 100%);
        border-bottom: 1px solid rgba(255,255,255,.16);
        box-shadow: 0 10px 34px rgba(3, 44, 91, .22);
    }

    .nav-inner {
        min-height: 76px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .brand-link img {
        height: 58px;
        width: auto;
        filter: brightness(0) invert(1);
        transition: transform .18s ease, opacity .18s ease;
    }

    .brand-link:hover img {
        transform: translateY(-1px);
        opacity: .92;
    }

    .nav-links {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .nav-links a:not(.btn) {
        color: rgba(255,255,255,.86);
        text-decoration: none;
        font-weight: 700;
        font-size: .92rem;
    }

    .nav-links a:not(.btn):hover {
        color: #fff;
    }

    .nav-cta {
        font-weight: 800;
        border-radius: 8px;
    }

    .hero {
        position: relative;
        min-height: 680px;
        display: flex;
        align-items: center;
        overflow: hidden;
        background: #032c5b;
    }

    .hero-image,
    .hero-shade {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
    }

    .hero-image {
        object-fit: cover;
    }

    .hero-shade {
        background: linear-gradient(90deg, rgba(3,44,91,.94) 0%, rgba(8,63,134,.74) 48%, rgba(0,163,215,.24) 100%);
    }

    .hero-content {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: minmax(0, 1fr) 320px;
        align-items: center;
        gap: 2rem;
        color: #fff;
        padding: 5rem 12px 6rem;
    }

    .hero-copy {
        max-width: 720px;
    }

    .eyebrow,
    .section-kicker {
        display: inline-block;
        color: #9ee7ff;
        font-size: .82rem;
        font-weight: 900;
        letter-spacing: .08em;
        text-transform: uppercase;
        margin-bottom: .75rem;
    }

    .hero h1 {
        font-size: clamp(2.6rem, 7vw, 5.8rem);
        line-height: .98;
        letter-spacing: 0;
        font-weight: 900;
        margin-bottom: 1rem;
    }

    .hero p {
        max-width: 600px;
        color: rgba(255,255,255,.86);
        font-size: 1.15rem;
        margin-bottom: 1.5rem;
    }

    .hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: .75rem;
    }

    .btn {
        border-radius: 8px;
        font-weight: 800;
        min-height: 44px;
        text-decoration: none;
    }

    .btn-primary {
        background: var(--primary);
        border-color: var(--primary);
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        border-color: var(--primary-dark);
    }

    .hero-panel {
        display: grid;
        gap: .75rem;
        padding: 1rem;
        background: rgba(255,255,255,.94);
        border: 1px solid rgba(255,255,255,.7);
        border-radius: 8px;
        box-shadow: 0 18px 44px rgba(0,0,0,.2);
        color: var(--ink);
    }

    .metric {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        padding: .9rem;
        border: 1px solid var(--line);
        border-radius: 8px;
        background: #fff;
    }

    .metric strong {
        font-size: 1.55rem;
    }

    .metric span {
        color: var(--muted);
        font-weight: 700;
        text-align: right;
    }

    .section {
        padding: 72px 0;
    }

    .publication-section {
        background: #fff;
    }

    .section-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 360px;
        gap: 1rem;
        align-items: center;
    }

    .section h2,
    .section-heading h2 {
        font-weight: 900;
        letter-spacing: 0;
        margin-bottom: .75rem;
    }

    .section-text,
    .section-heading p {
        color: var(--muted);
        max-width: 720px;
    }

    .publication-card,
    .track-card,
    .step-card,
    .filter-panel,
    .unit-card-button,
    .unit-modal {
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 8px;
        box-shadow: 0 14px 34px rgba(21,34,56,.07);
    }

    .publication-card {
        padding: 1.25rem;
    }

    .publication-card p {
        color: var(--muted);
        margin: .35rem 0 1rem;
    }

    .section-heading {
        max-width: 780px;
        margin-bottom: 2rem;
    }

    .track-grid,
    .steps-grid {
        display: grid;
        gap: 1rem;
    }

    .track-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        margin-bottom: 1rem;
    }

    .track-card {
        padding: 1.25rem;
    }

    .track-card h3,
    .step-card h3 {
        font-size: 1.05rem;
        font-weight: 900;
    }

    .track-card p,
    .step-card p {
        color: var(--muted);
        margin-bottom: 0;
    }

    .steps-grid {
        grid-template-columns: repeat(5, minmax(0, 1fr));
    }

    .step-card {
        padding: 1rem;
    }

    .step-card span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #e8f4ff;
        color: var(--primary);
        font-weight: 900;
        margin-bottom: .75rem;
    }

    .units-section {
        background: #eef4fb;
    }

    .filter-panel {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr)) auto;
        gap: 1rem;
        align-items: end;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .form-label {
        color: #25344d;
        font-weight: 800;
        font-size: .88rem;
    }

    .form-select {
        min-height: 46px;
        border-radius: 8px;
        border-color: #cbd5e1;
    }

    .unit-count {
        color: var(--muted);
        font-weight: 800;
        margin: 1rem 0;
    }

    .units-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1rem;
    }

    .unit-card-button {
        width: 100%;
        height: 100%;
        padding: 0;
        text-align: left;
        overflow: hidden;
        cursor: pointer;
        transition: transform .18s ease, box-shadow .18s ease;
    }

    .unit-card-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 18px 38px rgba(21,34,56,.12);
    }

    .unit-card-button img {
        width: 100%;
        height: 190px;
        object-fit: cover;
        display: block;
    }

    .unit-body {
        display: grid;
        gap: .35rem;
        padding: 1rem;
    }

    .unit-body strong {
        color: var(--primary-dark);
        font-size: 1rem;
    }

    .unit-body small,
    .unit-meta {
        color: var(--muted);
    }

    .unit-meta {
        font-size: .84rem;
        font-weight: 800;
    }

    .modal-unit-img {
        width: 100%;
        max-height: 360px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .home-footer {
        background: linear-gradient(90deg, #032c5b 0%, #083f86 55%, #145ab8 100%);
        color: #fff;
        padding: 1.25rem 0;
    }

    .footer-inner {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    .footer-inner span {
        display: block;
        color: rgba(255,255,255,.78);
    }

    @media (max-width: 991px) {
        .footer-inner {
            flex-direction: column;
            align-items: stretch;
        }

        .nav-inner {
            min-height: 72px;
            align-items: center;
        }

        .brand-link img {
            height: 46px;
            max-width: 150px;
            object-fit: contain;
        }

        .nav-links {
            flex: 1;
            min-width: 0;
            overflow-x: auto;
            gap: .75rem;
            padding-bottom: .25rem;
            scrollbar-width: none;
        }

        .nav-links::-webkit-scrollbar {
            display: none;
        }

        .nav-links a:not(.btn) {
            white-space: nowrap;
        }

        .nav-cta {
            white-space: nowrap;
        }

        .hero {
            min-height: auto;
        }

        .hero-content,
        .section-grid,
        .track-grid,
        .filter-panel {
            grid-template-columns: 1fr;
        }

        .steps-grid,
        .units-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .hero-shade {
            background: rgba(8,36,70,.76);
        }
    }

    @media (max-width: 575px) {
        .steps-grid,
        .units-grid {
            grid-template-columns: 1fr;
        }

        .nav-inner {
            align-items: flex-start;
        }

        .nav-links {
            width: 100%;
        }

        .hero-actions .btn {
            width: 100%;
        }

        .section {
            padding: 52px 0;
        }
    }
</style>
@endpush
