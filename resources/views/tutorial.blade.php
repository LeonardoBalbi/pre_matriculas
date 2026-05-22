<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tutorial de Inscrição</title>
    <link rel="stylesheet" href="{{ Request::root() }}/bt/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ Request::root() }}/bt/css/main.css">
    <style>
      body{background:linear-gradient(225deg,rgba(17,60,125,0.35),rgba(6,19,77,0.35));min-height:100vh}
      .glass{background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.28);backdrop-filter:blur(14px);border-radius:16px}
    </style>
</head>
<body>
  <div class="container py-5" style="max-width:960px;">
    <h1 class="text-white mb-4">Tutorial: Como preencher o formulário de inscrição</h1>

    <div class="p-3 mb-4 glass">
      <div class="ratio ratio-16x9">
        <video id="videoTutorial" controls preload="metadata" poster="/img/smeel-branco.png">
          <source src="/videos/tutorial-inscricao.mp4" type="video/mp4">
        </video>
      </div>
      <div class="mt-3 text-white">Se o vídeo não carregar, verifique se o arquivo está disponível em <code>/public/videos/tutorial-inscricao.mp4</code>.</div>
    </div>

    <div class="p-4 glass text-white">
      <h2 class="h4">Passo a passo</h2>
      <ol class="mb-0">
        <li>Acesse <a class="text-white" href="/pre-matricula">/pre-matricula</a>.</li>
        <li>Informe a data de nascimento da criança.</li>
        <li>Digite nome e CPF do candidato.</li>
        <li>Selecione sexo e demais opções (irmão na creche, bolsa família, etc.).</li>
        <li>Escolha o distrito e o bairro; em seguida selecione a escola.</li>
        <li>Verifique a turma calculada automaticamente.</li>
        <li>Informe os dados do responsável, aceite a declaração e o edital.</li>
        <li>Clique em Enviar para concluir.</li>
      </ol>
    </div>
  </div>

  <script src="{{ Request::root() }}/bt/vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
