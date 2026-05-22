<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inscrição Concluída</title>
  <link rel="stylesheet" href="{{ Request::root() }}/bt/vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ Request::root() }}/bt/css/main.css">
  <style>
    body{background:linear-gradient(225deg,rgba(17,60,125,0.35),rgba(6,19,77,0.35));min-height:100vh}
    .hero{min-height:100vh;display:flex;align-items:center;justify-content:center}
    .card-hero{background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.28);backdrop-filter:blur(14px);border-radius:16px;box-shadow:0 18px 40px rgba(0,0,0,0.35);}
    .brand{height:72px}
  </style>
  <script>
    document.addEventListener('DOMContentLoaded', function(){
      var dl = '/matricula/comprovante/{{ $id }}/d';
      var pr = '/matricula/comprovante/{{ $id }}/p';
      var btnDl = document.getElementById('btnDl');
      var btnPr = document.getElementById('btnPr');
      if(btnDl) btnDl.setAttribute('href', dl);
      if(btnPr) btnPr.setAttribute('href', pr);
    });
  </script>
  <link rel="icon" type="image/png" href="/img/seduc-white.png">
  <meta name="robots" content="noindex,nofollow">
</head>
<body>
  <div class="container hero">
    <div class="card-hero p-5 text-center text-white" style="max-width:720px;width:100%">
      <img src="/img/seduc-white.png" onerror="this.src='/img/smeel-branco.png'" alt="Secretaria de Educação" class="brand mb-3">
      <h1 class="mb-2">Inscrição realizada com sucesso</h1>
      <p class="mb-4">Seu protocolo foi gerado. Você pode baixar o comprovante agora ou abrir para imprimir.</p>
      <div class="d-flex flex-wrap gap-2 justify-content-center">
        <a id="btnDl" class="btn btn-primary btn-lg" href="#">Baixar comprovante</a>
        <a id="btnPr" class="btn btn-outline-light btn-lg" href="#" target="_blank">Imprimir</a>
        <a class="btn btn-success btn-lg" href="/pre-matricula">Nova inscrição</a>
      </div>
    </div>
  </div>
  <script src="{{ Request::root() }}/bt/vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
