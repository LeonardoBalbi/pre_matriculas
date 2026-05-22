<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inscricao concluida</title>
  <link rel="stylesheet" href="{{ Request::root() }}/bt/vendor/bootstrap/css/bootstrap.min.css">
  <style>
    :root {
      --ink: #132238;
      --muted: #64748b;
      --line: #d8e0ea;
      --surface: #ffffff;
      --primary: #0f6cbd;
      --primary-dark: #084f8f;
      --success: #147d64;
      --soft-success: #e9f8f3;
    }

    html,
    body {
      min-height: 100%;
    }

    body {
      margin: 0;
      color: var(--ink);
      background:
        linear-gradient(180deg, #eaf3fb 0, #f7f9fc 360px, #eef2f7 100%);
      font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .topbar {
      background: #082446;
      border-bottom: 1px solid rgba(255, 255, 255, .16);
    }

    .brand {
      height: 62px;
      width: auto;
    }

    .page {
      min-height: calc(100vh - 95px);
      display: flex;
      align-items: center;
      padding: 32px 0;
    }

    .success-shell {
      display: grid;
      grid-template-columns: minmax(0, 1fr) 340px;
      gap: 1rem;
      align-items: stretch;
    }

    .panel {
      background: var(--surface);
      border: 1px solid var(--line);
      border-radius: 8px;
      box-shadow: 0 16px 38px rgba(21, 34, 56, .08);
    }

    .main-panel {
      padding: 2rem;
    }

    .status-mark {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 64px;
      height: 64px;
      border-radius: 50%;
      background: var(--soft-success);
      border: 1px solid #bfe8db;
      color: var(--success);
      font-size: 2rem;
      font-weight: 900;
      margin-bottom: 1rem;
    }

    .kicker {
      color: var(--success);
      font-size: .82rem;
      font-weight: 800;
      letter-spacing: .08em;
      text-transform: uppercase;
    }

    h1 {
      letter-spacing: 0;
      margin: .35rem 0 .75rem;
    }

    .lead-copy {
      color: var(--muted);
      max-width: 680px;
    }

    .action-grid {
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: .75rem;
      margin-top: 1.5rem;
    }

    .btn {
      min-height: 46px;
      border-radius: 8px;
      font-weight: 700;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: .45rem;
      text-decoration: none;
    }

    .btn-primary {
      background: var(--primary);
      border-color: var(--primary);
      color: #fff;
    }

    .btn-primary:hover {
      background: var(--primary-dark);
      border-color: var(--primary-dark);
      color: #fff;
    }

    .btn-outline-primary {
      color: var(--primary);
      border-color: var(--primary);
    }

    .btn-outline-primary:hover {
      color: #fff;
      background: var(--primary);
      border-color: var(--primary);
    }

    .btn-outline-secondary {
      color: #334155;
      border-color: #cbd5e1;
      background: #fff;
    }

    .btn-outline-secondary:hover {
      color: #132238;
      background: #f1f5f9;
      border-color: #94a3b8;
    }

    .btn-success {
      color: #fff;
      background: var(--success);
      border-color: var(--success);
    }

    .btn-success:hover {
      color: #fff;
      background: #0f684f;
      border-color: #0f684f;
    }

    .side-panel {
      padding: 1.25rem;
    }

    .info-row {
      padding: .85rem 0;
      border-top: 1px solid #edf2f7;
    }

    .info-row:first-of-type {
      border-top: 0;
    }

    .info-label {
      color: var(--muted);
      font-size: .84rem;
      margin-bottom: .2rem;
    }

    .info-value {
      font-weight: 800;
      overflow-wrap: anywhere;
    }

    .next-steps {
      margin-top: 1.5rem;
      padding: 1.25rem;
      background: #f8fafc;
      border: 1px solid var(--line);
      border-radius: 8px;
    }

    .next-steps ol {
      margin: 0;
      padding-left: 1.25rem;
      color: #334155;
    }

    .footer-note {
      color: var(--muted);
      font-size: .9rem;
      margin-top: 1rem;
    }

    @media (max-width: 991px) {
      .success-shell,
      .action-grid {
        grid-template-columns: 1fr;
      }

      .page {
        align-items: flex-start;
      }
    }
  </style>
  <link rel="icon" type="image/png" href="/img/seduc-white.png">
  <meta name="robots" content="noindex,nofollow">
</head>
<body>
  @php
    $downloadUrl = route('matricula.comprovante', ['id' => $id, 'tipo' => 'd']);
    $printUrl = route('matricula.comprovante', ['id' => $id, 'tipo' => 'p']);
  @endphp

  <header class="topbar">
    <div class="container py-3 d-flex justify-content-center">
      <img src="/img/seduc-white.png" onerror="this.src='/img/smeel-branco.png'" alt="Secretaria de Educacao" class="brand">
    </div>
  </header>

  <main class="page">
    <div class="container" style="max-width: 1120px;">
      <div class="success-shell">
        <section class="panel main-panel">
          <div class="status-mark" aria-hidden="true">✓</div>
          <div class="kicker">Inscricao enviada</div>
          <h1 class="display-6 fw-bold">Pre-matricula realizada com sucesso</h1>
          <p class="lead-copy">
            Seu cadastro foi recebido pelo sistema. Baixe ou imprima o comprovante e guarde-o para acompanhar a solicitacao.
          </p>

          <div class="action-grid">
            <a id="btnDl" class="btn btn-primary" href="{{ $downloadUrl }}">Baixar comprovante</a>
            <a id="btnPr" class="btn btn-outline-primary" href="{{ $printUrl }}" target="_blank" rel="noopener">Imprimir</a>
            <a class="btn btn-outline-secondary" href="{{ url('/pre-matricula/status') }}">Acompanhar status</a>
          </div>

          <div class="next-steps">
            <h2 class="h6 fw-bold mb-3">Proximos passos</h2>
            <ol>
              <li>Confira os dados no comprovante.</li>
              <li>Guarde o arquivo em local seguro.</li>
              <li>Acompanhe o status pelo protocolo ou CPF do candidato.</li>
            </ol>
          </div>

          <p class="footer-note">
            Precisa cadastrar outra crianca? Use o botao de nova inscricao no painel ao lado.
          </p>
        </section>

        <aside class="panel side-panel">
          <h2 class="h5 fw-bold mb-3">Resumo</h2>
          <div class="info-row">
            <div class="info-label">Comprovante</div>
            <div class="info-value">Disponivel agora</div>
          </div>
          <div class="info-row">
            <div class="info-label">Identificador seguro</div>
            <div class="info-value">{{ $id }}</div>
          </div>
          <div class="info-row">
            <div class="info-label">Situacao inicial</div>
            <div class="info-value">Recebida para analise</div>
          </div>
          <div class="d-grid gap-2 mt-4">
            <a class="btn btn-success" href="/pre-matricula">Nova inscricao</a>
            <a class="btn btn-outline-secondary" href="{{ url('/') }}">Voltar ao inicio</a>
          </div>
        </aside>
      </div>
    </div>
  </main>

  <script src="{{ Request::root() }}/bt/vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
