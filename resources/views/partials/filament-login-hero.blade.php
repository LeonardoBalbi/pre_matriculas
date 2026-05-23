@if (request()->is('admin/login'))
    <aside class="admin-login-hero" aria-label="Pre-matricula Mangaratiba">
        <div class="admin-login-hero__content">
            <a class="admin-login-hero__brand" href="{{ url('/') }}" aria-label="Voltar para a home">
                <img src="{{ asset('img/logo_governo_azul.png') }}" alt="Prefeitura de Mangaratiba">
            </a>

            <span class="admin-login-hero__kicker">Secretaria Municipal de Educacao</span>
            <h2>Gestao da pre-matricula</h2>
            <p>
                Acompanhe inscricoes, organize unidades escolares, confira turmas e conclua matriculas em um painel alinhado ao portal publico.
            </p>

            <div class="admin-login-hero__actions">
                <a href="{{ url('/') }}">Voltar para home</a>
                <a href="{{ url('/pre-matricula') }}">Fazer inscricao</a>
            </div>

            <div class="admin-login-hero__metrics">
                <span>Analise</span>
                <span>Confirmacao</span>
                <span>Unidades</span>
            </div>
        </div>
    </aside>
@endif
