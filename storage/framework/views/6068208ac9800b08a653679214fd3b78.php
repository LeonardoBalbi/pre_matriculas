<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title>Inscritos</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo e(Request::root()); ?>/bt/css/main.css">
  <style>
    html,
    body {
      height: 100%
    }

    body {
      margin: 0
    }

    body::before {
      content: "";
      position: fixed;
      inset: 0;
      background:
        radial-gradient(1000px 400px at 10% 10%, rgba(255, 255, 255, .08), transparent 50%),
        radial-gradient(1000px 400px at 90% 90%, rgba(255, 255, 255, .08), transparent 50%);
      pointer-events: none;
    }

    .glass-card {
      background: rgba(255, 255, 255, 0.14);
      border: 1px solid rgba(255, 255, 255, 0.28);
      backdrop-filter: blur(14px);
      -webkit-backdrop-filter: blur(14px);
      border-radius: 16px;
      box-shadow: 0 18px 40px rgba(0, 0, 0, 0.35);
    }

    .header-title {
      color: #fff;
      text-shadow: 0 2px 12px rgba(0, 0, 0, 0.4);
    }

    .card-header {
      background: transparent;
      border-bottom: 1px solid rgba(255, 255, 255, 0.25);
      color: #fff;
      font-weight: 600
    }

    .form-label {
      color: #fff;
      margin-bottom: .5rem
    }

    .form-control,
    .form-select {
      background: rgba(255, 255, 255, 0.92);
      border: 1px solid rgba(0, 0, 0, 0.12);
      margin-bottom: 1rem
    }

    .btn-primary {
      background: linear-gradient(135deg, #1e88e5, #0d47a1);
      border: 0;
      box-shadow: 0 10px 24px rgba(13, 71, 161, .35)
    }

    .btn-primary:hover {
      filter: brightness(1.06)
    }

    .alert-success {
      background: rgba(46, 204, 113, 0.18);
      border-color: rgba(46, 204, 113, 0.38);
      color: #fff
    }

    .site-header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      background: rgba(6, 19, 77, 0.35);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.2)
    }

    .header-inner {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 16px 0
    }

    .header-logo {
      height: 80px;
      width: auto
    }

    .site-footer {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      background: rgba(6, 19, 77, 0.35);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      border-top: 1px solid rgba(255, 255, 255, 0.2)
    }

    .footer-inner {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 12px 0
    }

    .footer-logo {
      height: 36px;
      width: auto;
      margin-right: 10px
    }

    .footer-text {
      color: #fff;
      font-weight: 500
    }

    .page-main {
      padding-top: calc(96px + 32px);
      padding-bottom: calc(64px + 48px);
      min-height: calc(100vh - 96px - 64px)
    }
  </style>
</head>

<body style="min-height:100vh;background-image:linear-gradient(225deg,rgba(17,60,125,0.35),rgba(6,19,77,0.35));background-repeat:no-repeat;background-attachment:fixed;background-position:center top;background-size:cover;">

  <?php
  $prefillName = '';
  $prefillEmail = '';

  if (session('api_user')) {
  $prefillName = session('api_user')['name'] ?? '';
  $prefillEmail = session('api_user')['email'] ?? '';
  } elseif (auth()->check()) {
  $prefillName = auth()->user()->name;
  $prefillEmail = auth()->user()->email;
  }
  ?>

  <header class="site-header">
    <div class="container header-inner">
      <img src="/img/seduc-white.png" onerror="this.src='/img/smeel-branco.png'" alt="Secretaria de Educação" class="header-logo">

      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('api_user') || auth()->check()): ?>
      <div class="d-flex align-items-center">
        <span class="text-white me-3 d-none d-md-block">
          <?php echo e($prefillName); ?>

        </span>
        <form method="POST" action="<?php echo e(route('api.logout')); ?>">
          <?php echo csrf_field(); ?>
          <button type="submit" class="btn btn-outline-light btn-sm">Sair</button>
        </form>
      </div>
      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
  </header>
  <main class="page-main">
    <div id="alertTop" class="alert alert-danger fixed-top d-none" role="alert" aria-live="assertive" style="z-index: 2000;">
      <div class="container d-flex justify-content-between align-items-center">
        <span id="alertTopText"></span>
        <button type="button" class="btn-close" aria-label="Close" onclick="document.getElementById('alertTop').classList.add('d-none');"></button>
      </div>
    </div>
    <style>
      @keyframes shake {0%{transform:translateX(0)}15%{transform:translateX(-8px)}30%{transform:translateX(8px)}45%{transform:translateX(-6px)}60%{transform:translateX(6px)}75%{transform:translateX(-4px)}90%{transform:translateX(4px)}100%{transform:translateX(0)}}
      .shake {animation: shake 500ms}
    </style>
    <script>
      function playErrorBeep(){try{var c=new (window.AudioContext||window.webkitAudioContext)();var o=c.createOscillator();var g=c.createGain();o.type='sine';o.frequency.value=880;o.connect(g);g.connect(c.destination);g.gain.setValueAtTime(0.001,c.currentTime);g.gain.exponentialRampToValueAtTime(0.2,c.currentTime+0.01);o.start();g.gain.exponentialRampToValueAtTime(0.00001,c.currentTime+0.3);o.stop(c.currentTime+0.32)}catch(e){}}
    </script>
    <div class="container py-4" style="max-width: 960px;">
      <h2 class="h4 mb-0 header-title">Pré-matrícula para o ano letivo de <?php echo e(date('Y')); ?></h2>

      <div id="sucesso" class="alert alert-success d-none" role="alert">
        <div class="d-flex justify-content-between align-items-center">
          <span>Inscrição realizada com sucesso.</span>
          <div>
            <a id="btnDownload" class="btn btn-outline-secondary btn-sm me-2" href="#">Download</a>
            <a id="btnImprimir" class="btn btn-outline-secondary btn-sm" href="#" target="_blank">Imprimir</a>
          </div>
        </div>
      </div>

      <div class="modal fade" id="modalSucesso" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content glass-card">
            <div class="modal-header">
              <h5 class="modal-title">Parabéns!</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p class="mb-3">Sua matrícula foi realizada com sucesso. Deseja fazer o download do comprovante agora? Você também pode imprimir em outra aba.</p>
              <div class="d-flex gap-2">
                <a id="modalBtnDownload" class="btn btn-primary" href="#">Baixar agora</a>
                <a id="modalBtnImprimir" class="btn btn-outline-secondary" href="#" target="_blank">Imprimir</a>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Agora não</button>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" id="btnNovaInscricao">Nova inscrição</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="modalErro" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content glass-card">
            <div class="modal-header">
              <h5 class="modal-title text-danger">Atenção</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p class="mb-2" data-erro-msg></p>
              <p class="text-muted">Para prosseguir, solicite liberação na Secretaria ou aguarde o administrador.</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Entendi</button>
            </div>
          </div>
        </div>
      </div>

      <form id="formInscricao">
        <input type="hidden" name="ano_letivo" id="ano_letivo" value="<?php echo e(date('Y')); ?>">

        <div class="card glass-card mb-3">
          <div class="card-header">Dados do Candidato</div>
          <div class="card-body">
            <div class="row gy-6 gx-6">
              <div class="col-md-6">
                <label class="form-label">Data de Nascimento</label>
                <input type="date" class="form-control" name="data_nascimento" id="data_nascimento" required>
                <div class="text-danger small" data-error="data_nascimento"></div>
                <div class="form-text mt-1" id="idade_corte_text"></div>
                <div class="text-danger small" id="aviso_data_corte"></div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Nome do Candidato</label>
                <input type="text" class="form-control" name="nome_candidato" id="nome_candidato" required>
                <div class="text-danger small" data-error="nome_candidato"></div>
              </div>
              <div class="col-md-6">
                <label class="form-label">CPF do Candidato</label>
                <input type="text" class="form-control" name="cpf_candidato" id="cpf_candidato" placeholder="000.000.000-00" required>
                <div class="text-danger small" data-error="cpf_candidato"></div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Sexo</label>
                <select class="form-select" name="sexo" id="sexo" required>
                  <option value="">Selecionar</option>
                  <option value="masculino">Masculino</option>
                  <option value="feminino">Feminino</option>
                </select>
                <div class="text-danger small" data-error="sexo"></div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Irmão na creche</label>
                <select class="form-select" name="irmao_creche" id="irmao_creche">
                  <option value="">Selecionar</option>
                  <option value="sim">Sim</option>
                  <option value="não">Não</option>
                </select>
                <div class="text-danger small" data-error="irmao_creche"></div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Irmão gêmeo</label>
                <select class="form-select" name="irmao_gemeo" id="irmao_gemeo">
                  <option value="">Selecionar</option>
                  <option value="sim">Sim</option>
                  <option value="não">Não</option>
                </select>
                <div class="text-danger small" data-error="irmao_gemeo"></div>
              </div>
              <div class="col-md-6 d-none" id="grupo_nome_irmao">
                <label class="form-label">Nome do irmão gêmeo</label>
                <input type="text" class="form-control" name="nome_irmao_gemeo" id="nome_irmao_gemeo">
                <div class="text-danger small" data-error="nome_irmao_gemeo"></div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Bolsa Família</label>
                <select class="form-select" name="bolsa_familia" id="bolsa_familia">
                  <option value="">Selecionar</option>
                  <option value="sim">Sim</option>
                  <option value="não">Não</option>
                </select>
                <div class="text-danger small" data-error="bolsa_familia"></div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Vulnerabilidade Social</label>
                <select class="form-select" name="vulneravel_social" id="vulneravel_social">
                  <option value="">Selecionar</option>
                  <option value="sim">Sim</option>
                  <option value="não">Não</option>
                </select>
                <div class="text-danger small" data-error="vulneravel_social"></div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Distrito</label>
                <select class="form-select" name="distrito_id" id="distrito_id" required>
                  <option value="">Selecionar</option>
                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $distritos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                  <option value="<?php echo e($d->id); ?>"><?php echo e($d->distrito); ?></option>
                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
                <div class="text-danger small" data-error="distrito_id"></div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Endereço</label>
                <input type="text" class="form-control" name="endereco" id="endereco">
                <div class="text-danger small" data-error="endereco"></div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Bairro</label>
                <select class="form-select" name="escola_bairro_id" id="escola_bairro_id" required>
                  <option value="">Selecionar</option>
                </select>
                <div class="text-danger small" data-error="escola_bairro_id"></div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Escola</label>
                <select class="form-select" name="escola_nome_id" id="escola_nome_id" required>
                  <option value="">Selecionar</option>
                </select>
                <div class="text-danger small" data-error="escola_nome_id"></div>
              </div>
              <div class="col-md-6 d-none">
                <label class="form-label">Turma</label>
                <select class="form-select" name="turma_id" id="turma_id">
                  <option value="">Selecionar</option>
                </select>
                <div class="text-danger small" data-error="turma_id"></div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Turma calculada (automática)</label>
                <input type="text" class="form-control" id="turma_especie_display" readonly>
                <input type="hidden" name="turma_especie" id="turma_especie">
              </div>
              <div class="col-md-6">
                <label class="form-label">Carteira de Vacinação</label>
                <select class="form-select" name="carteira_vacinacao" id="carteira_vacinacao" required>
                  <option value="">Selecionar</option>
                  <option value="sim">Sim</option>
                  <option value="não">Não</option>
                </select>
                <div class="text-danger small" data-error="carteira_vacinacao"></div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Cadastro Único</label>
                <select class="form-select" name="cad_unico" id="cad_unico">
                  <option value="">Selecionar</option>
                  <option value="sim">Sim</option>
                  <option value="não">Não</option>
                </select>
                <div class="text-danger small" data-error="cad_unico"></div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Portador de Deficiência</label>
                <select class="form-select" name="portador_deficiencia" id="portador_deficiencia">
                  <option value="">Selecionar</option>
                  <option value="sim">Sim</option>
                  <option value="não">Não</option>
                </select>
                <div class="text-danger small" data-error="portador_deficiencia"></div>
              </div>
              <div class="col-md-6 d-none" id="grupo_deficiencias">
                <label class="form-label">Deficiências Tipo</label>
                <select class="form-select" name="deficiencias_tipo" id="deficiencias_tipo">
                  <option value="">Selecionar</option>
                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $deficiencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                  <option value="<?php echo e($item->id); ?>"><?php echo e($item->tipo_deficiencia); ?></option>
                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
                <div class="text-danger small" data-error="deficiencias_tipo"></div>
              </div>
            </div>
          </div>
        </div>

        <div class="card glass-card mb-3">
          <div class="card-header">Dados do Responsável</div>
          <div class="card-body">
            <div class="row gy-6 gx-6">
              <div class="col-md-6">
                <label class="form-label">Grau de Parentesco</label>
                <select class="form-select" name="grau_parentesco" id="grau_parentesco">
                  <option value="">Selecionar</option>
                  <option value="mãe">Mãe</option>
                  <option value="pai">Pai</option>
                  <option value="responsável legal">Responsável Legal</option>
                </select>
                <div class="text-danger small" data-error="grau_parentesco"></div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Nome do Responsável</label>
                <input type="text" class="form-control" name="nome_responsavel" id="nome_responsavel" required>
                <div class="text-danger small" data-error="nome_responsavel"></div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Data de Nascimento do Responsável</label>
                <input type="date" class="form-control" name="data_nasc_responsavel" id="data_nasc_responsavel" required>
                <div class="text-danger small" data-error="data_nasc_responsavel"></div>
              </div>
              <div class="col-md-6">
                <label class="form-label">CPF do Responsável</label>
                <input type="text" class="form-control" name="cpf_responsavel" id="cpf_responsavel" placeholder="000.000.000-00">
                <div class="text-danger small" data-error="cpf_responsavel"></div>
              </div>
              <div class="col-md-6">
                <label class="form-label">E-mail do Responsável</label>
                <input type="email" class="form-control" name="email_responsavel" id="email_responsavel" value="<?php echo e($prefillEmail); ?>" required>
                <div class="text-danger small" data-error="email_responsavel"></div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Celular do Responsável</label>
                <input type="text" class="form-control" name="tel_cel_responsavel" id="tel_cel_responsavel" required>
                <div class="text-danger small" data-error="tel_cel_responsavel"></div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Telefone Fixo</label>
                <input type="text" class="form-control" name="tel_fixo_responsavel" id="tel_fixo_responsavel">
                <div class="text-danger small" data-error="tel_fixo_responsavel"></div>
              </div>
            </div>
          </div>
        </div>

        <div class="card glass-card mb-3">
          <div class="card-body">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="declaro" name="declaro" value="1">
              <label class="form-check-label" for="declaro">Declaro que os dados informados são verídicos.</label>
              <div class="text-danger small" data-error="declaro"></div>
            </div>
            <div class="form-check mt-2">
              <input class="form-check-input" type="checkbox" id="edital" name="edital" value="1">
              <label class="form-check-label" for="edital">Concordo com os termos do edital.</label>
              <div class="text-danger small" data-error="edital"></div>
            </div>
            <div class="mt-3">
              <a href="pdf/Edital_02_de_2024-Cadastro_dos_CEIMs_para_2025.pdf" target="_blank" class="btn btn-primary btn-sm">Acessar Edital</a>
            </div>
          </div>
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-primary btn-lg" id="btnEnviar">Enviar</button>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('api_user') || auth()->check()): ?>
        <div class="text-center mt-3">
          <form method="POST" action="<?php echo e(route('api.logout')); ?>" class="d-inline">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-danger btn-sm">Sair / Deslogar</button>
          </form>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </form>
    </div>

  </main>

  <footer class="site-footer">
    <div class="container footer-inner">
      <img src="/img/seduc-white.png" onerror="this.src='/img/smeel-branco.png'" alt="Secretaria de Educação" class="footer-logo">
      <span class="footer-text">Secretaria Municipal de Educação</span>
    </div>
  </footer>

  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    $(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      function onlyDigits(s) {
        return s.replace(/\D+/g, '');
      }

      function formatCPF(v) {
        var d = onlyDigits(v).slice(0, 11);
        var out = '';
        if (d.length > 0) {
          out = d.substring(0, 3);
        }
        if (d.length >= 4) {
          out += '.' + d.substring(3, 6);
        }
        if (d.length >= 7) {
          out += '.' + d.substring(6, 9);
        }
        if (d.length >= 10) {
          out += '-' + d.substring(9, 11);
        }
        return out;
      }

      function validateCPF(cpf) {
        cpf = onlyDigits(cpf);
        if (cpf.length !== 11) return false;
        if (/^(?:([0-9])\1+)$/.test(cpf)) return false;
        var soma = 0;
        for (var i = 0; i < 9; i++) {
          soma += parseInt(cpf.charAt(i)) * (10 - i);
        }
        var resto = 11 - (soma % 11);
        var dv1 = resto > 9 ? 0 : resto;
        soma = 0;
        for (var i2 = 0; i2 < 10; i2++) {
          soma += parseInt(cpf.charAt(i2)) * (11 - i2);
        }
        resto = 11 - (soma % 11);
        var dv2 = resto > 9 ? 0 : resto;
        if (dv1 !== parseInt(cpf.charAt(9)) || dv2 !== parseInt(cpf.charAt(10))) return false;
        var cpfCompleto = cpf.substr(0, 9) + dv1 + dv2;
        var invalidos = ['00000000000', '11111111111', '22222222222', '33333333333', '44444444444', '55555555555', '66666666666', '77777777777', '88888888888', '99999999999'];
        if (invalidos.indexOf(cpfCompleto) >= 0) return false;
        var somaCpf = 0;
        for (var j = 0; j < 9; j++) {
          somaCpf += parseInt(cpfCompleto.charAt(j)) * (10 - j);
        }
        resto = 11 - (somaCpf % 11);
        if (resto === 10 || resto === 11) resto = 0;
        if (resto !== parseInt(cpfCompleto.charAt(9))) return false;
        somaCpf = 0;
        for (var k = 0; k < 10; k++) {
          somaCpf += parseInt(cpfCompleto.charAt(k)) * (11 - k);
        }
        resto = 11 - (somaCpf % 11);
        if (resto === 10 || resto === 11) resto = 0;
        if (resto !== parseInt(cpfCompleto.charAt(10))) return false;
        return true;
      }

      function formatPhone(v) {
        var d = onlyDigits(v).slice(0, 11);
        if (d.length <= 2) {
          return d;
        }
        if (d.length <= 6) {
          return '(' + d.slice(0, 2) + ') ' + d.slice(2);
        }
        if (d.length <= 10) {
          return '(' + d.slice(0, 2) + ') ' + d.slice(2, 6) + '-' + d.slice(6);
        }
        return '(' + d.slice(0, 2) + ') ' + d.slice(2, 7) + '-' + d.slice(7);
      }
      $('#cpf_candidato').on('input', function() {
        $(this).val(formatCPF($(this).val()));
      });
      $('#cpf_candidato').on('blur', function() {
        var ok = validateCPF($(this).val());
        $('[data-error="cpf_candidato"]').text(ok ? '' : 'CPF Inválido');
      });
      $('#cpf_responsavel').on('input', function() {
        $(this).val(formatCPF($(this).val()));
      });
      $('#cpf_responsavel').on('blur', function() {
        var v = $(this).val();
        if (v) {
          var ok = validateCPF(v);
          $('[data-error="cpf_responsavel"]').text(ok ? '' : 'CPF Inválido');
        } else {
          $('[data-error="cpf_responsavel"]').text('');
        }
      });
      $('#tel_cel_responsavel').on('input', function() {
        $(this).val(formatPhone($(this).val()));
      });
      $('#tel_fixo_responsavel').on('input', function() {
        $(this).val(formatPhone($(this).val()));
      });

      function definirTurma(dataNascimento) {
        if (!dataNascimento) return 'Não atribuída';
        var nascimento = new Date(dataNascimento);
        var hoje = new Date();
        var anoAtual = new Date().getFullYear();
        var dataCorte = new Date(anoAtual, 2, 31);
        var diff = dataCorte - nascimento;
        var idadeMesesCorte = Math.floor(diff / (1000 * 60 * 60 * 24 * 30.4375));
        var idadeAnosCorte = Math.floor(idadeMesesCorte / 12);

        var bercario_ini = new Date(anoAtual - 1, 3, 1);
        var bercario_fim = new Date(anoAtual, 2, 31);
        var infantil1_ini = new Date(anoAtual - 2, 3, 1);
        var infantil1_fim = new Date(anoAtual - 1, 2, 31);
        var infantil2_ini = new Date(anoAtual - 3, 3, 1);
        var infantil2_fim = new Date(anoAtual - 2, 2, 31);
        var infantil3_ini = new Date(anoAtual - 4, 3, 1);
        var infantil3_fim = new Date(anoAtual - 3, 2, 31);

        if ((idadeMesesCorte >= 6 && idadeMesesCorte <= 11) || (nascimento >= bercario_ini && nascimento <= bercario_fim)) return 'BERÇARIO';
        if ((idadeMesesCorte >= 12 && idadeMesesCorte <= 23) || (nascimento >= infantil1_ini && nascimento <= infantil1_fim)) return 'INFANTIL 1';
        if ((idadeMesesCorte >= 24 && idadeMesesCorte <= 35) || (nascimento >= infantil2_ini && nascimento <= infantil2_fim)) return 'INFANTIL 2';
        if ((idadeMesesCorte >= 36 && idadeMesesCorte <= 47) || (nascimento >= infantil3_ini && nascimento <= infantil3_fim)) return 'INFANTIL 3';
        return 'Não atribuída';
      }

      function atualizarIdadeECorte(val) {
        if (!val) {
          $('#idade_corte_text').text('');
          $('#aviso_data_corte').text('Data de nascimento não pode ser vazia.');
          $('#btnEnviar').prop('disabled', true);
          $('#turma_especie_display').val('Não atribuída');
          $('#turma_especie').val('');
          return;
        }

        var dn = new Date(val);
        var hoje = new Date();
        var anos = hoje.getFullYear() - dn.getFullYear();
        var meses = hoje.getMonth() - dn.getMonth();
        var dias = hoje.getDate() - dn.getDate();
        if (dias < 0) {
          meses--;
          dias += new Date(hoje.getFullYear(), hoje.getMonth(), 0).getDate();
        }
        if (meses < 0) {
          anos--;
          meses += 12;
        }

        var anoLetivo = new Date().getFullYear();
        var corte = new Date(anoLetivo, 2, 31);
        var anosC = corte.getFullYear() - dn.getFullYear();
        var mesesC = corte.getMonth() - dn.getMonth();
        var diasC = corte.getDate() - dn.getDate();
        if (diasC < 0) {
          mesesC--;
          var ultimoDiaMesAnterior = new Date(corte.getFullYear(), corte.getMonth(), 0).getDate();
          diasC += ultimoDiaMesAnterior;
        }
        if (mesesC < 0) {
          anosC--;
          mesesC += 12;
        }
        diasC--;
        if (diasC < 0) {
          mesesC--;
          diasC = new Date(corte.getFullYear(), corte.getMonth() - 1, 0).getDate() - 2;
          if (mesesC < 0) {
            anosC--;
            mesesC = 11;
          }
        }
        if (dn > corte) {
          anosC = 0;
          mesesC = 0;
          diasC = 0;
        }

        var texto = '';
        if (anosC > 0) texto += anosC + (anosC === 1 ? ' ano' : ' anos');
        if (mesesC > 0) {
          if (texto) texto += ', ';
          texto += mesesC + (mesesC === 1 ? ' mês' : ' meses');
        }
        if (diasC > 0) {
          if (texto) texto += ' e ';
          texto += diasC + (diasC === 1 ? ' dia' : ' dias');
        }
        $('#idade_corte_text').text(texto || '0 dias');

        var turma = definirTurma(val);
        $('#turma_especie_display').val(turma);
        $('#turma_especie').val(turma);

        if (anosC > 3 || (anosC === 3 && (mesesC > 11 || diasC > 29))) {
          $('#btnEnviar').prop('disabled', true);
          $('#aviso_data_corte').text('A criança deve ter no máximo 3 anos e 11 meses 29 dias na data base (31/03).');
        } else {
          $('#btnEnviar').prop('disabled', false);
          $('#aviso_data_corte').text('');
        }

        if ($('#escola_bairro_id').val()) {
          $('#escola_bairro_id').trigger('change');
        }
      }

      $('#data_nascimento').on('change', function() {
        atualizarIdadeECorte($(this).val());
      });

      $('#irmao_gemeo').on('change', function() {
        var v = $(this).val();
        $('#grupo_nome_irmao').toggleClass('d-none', v !== 'sim');
      });

      $('#portador_deficiencia').on('change', function() {
        var v = $(this).val();
        $('#grupo_deficiencias').toggleClass('d-none', v !== 'sim');
      });

      $('#distrito_id').on('change', function() {
        var distrito = $(this).val();
        $('#escola_bairro_id').empty().append('<option value="">Selecionar</option>');
        $('#escola_nome_id').empty().append('<option value="">Selecionar</option>');
        $('#turma_id').empty().append('<option value="">Selecionar</option>');
        if (!distrito) return;
        $.post('/matricula/consultar-bairro', {
          distrito: distrito
        }, function(resp) {
          var dados = resp.data || [];
          dados.forEach(function(b) {
            var label = (b.descricao || b.escola_bairro_id || 'Bairro');
            $('#escola_bairro_id').append('<option value="' + b.id + '">' + label + '</option>');
          });
        });
      });

      $('#escola_bairro_id').on('change', function() {
        var bairro_id = $(this).val();
        $('#escola_nome_id').empty().append('<option value="">Selecionar</option>');
        $('#turma_id').empty().append('<option value="">Selecionar</option>');
        if (!bairro_id) return;
        $.post('/matricula/consultar-escola', {
          bairro_id: bairro_id,
          turma_especie: $('#turma_especie').val()
        }, function(resp) {
          var dados = resp.data || [];
          dados.forEach(function(e) {
            $('#escola_nome_id').append('<option value="' + e.id + '">' + (e.escola_nome || e.nome || 'Escola') + '</option>');
          });
        });
      });

      $('#escola_nome_id').on('change', function() {
        var escola_id = $(this).val();
        $('#turma_id').empty().append('<option value="">Selecionar</option>');
        if (!escola_id) return;
        $.post('/matricula/consultar-turma', {
          escola_id: escola_id
        }, function(resp) {
          var dados = resp.data || [];
          dados.forEach(function(t) {
            var label = (t.tipo_descricao ? t.tipo_descricao : (t.turma_nome || 'Turma'));
            $('#turma_id').append('<option value="' + t.id + '">' + label + '</option>');
          });
        });
      });

      function clearErrors() {
        $('[data-error]').text('');
      }

      function showErrors(errors) {
        Object.keys(errors || {}).forEach(function(k) {
          var msg = errors[k] && errors[k][0] ? errors[k][0] : '';
          $('[data-error="' + k + '"]').text(msg);
        });
      }

      $('#formInscricao').on('submit', function(e) {
        e.preventDefault();
        clearErrors();

        var dados = {
          ano_letivo: $('#ano_letivo').val(),
          data_nascimento: $('#data_nascimento').val(),
          nome_candidato: $('#nome_candidato').val(),
          cpf_candidato: onlyDigits($('#cpf_candidato').val()),
          sexo: $('#sexo').val(),
          irmao_creche: $('#irmao_creche').val(),
          irmao_gemeo: $('#irmao_gemeo').val(),
          nome_irmao_gemeo: $('#nome_irmao_gemeo').val(),
          bolsa_familia: $('#bolsa_familia').val(),
          vulneravel_social: $('#vulneravel_social').val(),
          distrito_id: $('#distrito_id').val(),
          endereco: $('#endereco').val(),
          escola_bairro_id: $('#escola_bairro_id').val(),
          escola_nome_id: $('#escola_nome_id').val(),
          turma_id: $('#turma_id').val(),
          turma_especie: $('#turma_especie').val(),
          carteira_vacinacao: $('#carteira_vacinacao').val(),
          cad_unico: $('#cad_unico').val(),
          portador_deficiencia: $('#portador_deficiencia').val(),
          deficiencias_tipo: $('#deficiencias_tipo').val(),
          grau_parentesco: $('#grau_parentesco').val(),
          nome_responsavel: $('#nome_responsavel').val(),
          data_nasc_responsavel: $('#data_nasc_responsavel').val(),
          cpf_responsavel: onlyDigits($('#cpf_responsavel').val()),
          email_responsavel: $('#email_responsavel').val(),
          tel_cel_responsavel: $('#tel_cel_responsavel').val(),
          tel_fixo_responsavel: $('#tel_fixo_responsavel').val(),
          declaro: $('#declaro').is(':checked') ? 1 : 0,
          edital: $('#edital').is(':checked') ? 1 : 0
        };

        $.ajax({
          url: '/matricula/enviar',
          method: 'POST',
          headers: { 'Accept': 'application/json' },
          data: dados,
          success: function(resp) {
            var id = resp.id;
            var dl = resp.download_url || ('/matricula/comprovante/' + id + '/d');
            var pr = resp.print_url || ('/matricula/comprovante/' + id + '/p');
            $('#sucesso').removeClass('d-none');
            $('#btnDownload').attr('href', dl);
            $('#btnImprimir').attr('href', pr);
            $('#modalBtnDownload').attr('href', dl);
            $('#modalBtnImprimir').attr('href', pr);
            var base = "<?php echo e(Request::root()); ?>";
            var target = resp.redirect_url || (base + '/inscritos/sucesso/' + encodeURIComponent(id));
            try {
              window.location.assign(target);
            } catch (e) {
              var modalEl = document.getElementById('modalSucesso');
              if (modalEl) {
                new bootstrap.Modal(modalEl).show();
              }
            }
            setTimeout(function() {
              var modalEl = document.getElementById('modalSucesso');
              if (modalEl && document.visibilityState === 'visible') {
                new bootstrap.Modal(modalEl).show();
              }
            }, 1200);
          },
          error: function(xhr) {
            var resp = xhr.responseJSON;
            if (!resp) {
              try { resp = JSON.parse(xhr.responseText || '{}'); } catch(e) { resp = {}; }
            }
            if (resp && resp.errors) {
              showErrors(resp.errors);
            }
            var msg = '';
            if (resp && resp.errors && resp.errors['cpf_candidato'] && resp.errors['cpf_candidato'][0]) {
              msg = resp.errors['cpf_candidato'][0];
            } else if (resp && resp.message) {
              msg = resp.message;
            }
            if (msg && msg.indexOf('Já existe uma matrícula ativa para este CPF') !== -1) {
              var alertTop = document.getElementById('alertTop');
              var alertText = document.getElementById('alertTopText');
              if (alertTop && alertText) {
                alertText.textContent = msg;
                alertTop.classList.remove('d-none');
                window.scrollTo({ top: 0, behavior: 'smooth' });
              }
              var cpfEl = document.getElementById('cpf_candidato');
              if (cpfEl) {
                cpfEl.classList.add('is-invalid');
                cpfEl.classList.add('shake');
                setTimeout(function(){ cpfEl.classList.remove('shake'); }, 600);
                try { cpfEl.focus({ preventScroll: false }); } catch(e) { cpfEl.focus(); }
              }
              if (typeof playErrorBeep === 'function') { playErrorBeep(); }
              var modalEl = document.getElementById('modalErro');
              if (modalEl) {
                var el = modalEl.querySelector('[data-erro-msg]');
                if (el) el.textContent = msg;
                if (window.bootstrap && bootstrap.Modal) {
                  new bootstrap.Modal(modalEl).show();
                } else if (window.jQuery) {
                  $(modalEl).modal('show');
                }
              }
            }
          }
        });
      });

      function resetFormulario() {
        var f = $('#formInscricao')[0];
        if (f) f.reset();
        clearErrors();
        $('#turma_especie_display').val('Não atribuída');
        $('#turma_especie').val('');
        $('#idade_corte_text').text('');
        $('#aviso_data_corte').text('');
        $('#escola_bairro_id').empty().append('<option value="">Selecionar</option>');
        $('#escola_nome_id').empty().append('<option value="">Selecionar</option>');
        $('#turma_id').empty().append('<option value="">Selecionar</option>');
        $('#grupo_nome_irmao').addClass('d-none');
        $('#grupo_deficiencias').addClass('d-none');
        $('#btnEnviar').prop('disabled', true);
      }

      if (typeof onlyDigits !== 'function') {
        window.onlyDigits = function(s){ return (s||'').replace(/\D+/g,''); };
      }
      if (typeof formatCPF !== 'function') {
        window.formatCPF = function(v){ var d=onlyDigits(v).slice(0,11); var out=''; if(d.length>0){ out=d.substring(0,3);} if(d.length>=4){ out+='.'+d.substring(3,6);} if(d.length>=7){ out+='.'+d.substring(6,9);} if(d.length>=10){ out+='-'+d.substring(9,11);} return out; };
      }
      if (typeof formatPhone !== 'function') {
        window.formatPhone = function(v){ var d=onlyDigits(v).slice(0,11); if(d.length<=2){ return d;} if(d.length<=6){ return '('+d.slice(0,2)+') '+d.slice(2);} if(d.length<=10){ return '('+d.slice(0,2)+') '+d.slice(2,6)+'-'+d.slice(6);} return '('+d.slice(0,2)+') '+d.slice(2,7)+'-'+d.slice(7); };
      }

      $('#cpf_candidato').on('change', function(){
        var cpf = onlyDigits($(this).val());
        if (!cpf || cpf.length !== 11) { return; }
        $.ajax({
          url: "/matricula/buscar-por-cpf",
          method: 'POST',
          headers: { 'Accept': 'application/json' },
          dataType: 'json',
          data: { cpf: cpf },
          success: function(resp){
            if (resp && resp.data) {
              var d = resp.data;
              $('[data-error="cpf_candidato"]').text('');
              $('#nome_candidato').val(d.nome_candidato || '');
              $('#data_nascimento').val(d.data_nascimento || '').trigger('change');
              $('#sexo').val(d.sexo || '').trigger('change');
              $('#endereco').val(d.endereco || '');
              $('#distrito_id').val(d.distrito_id || '').trigger('change');
              setTimeout(function(){ $('#escola_bairro_id').val(d.escola_bairro_id || '').trigger('change'); }, 300);
              setTimeout(function(){ $('#escola_nome_id').val(d.escola_nome_id || '').trigger('change'); }, 600);
              setTimeout(function(){ $('#turma_id').val(d.turma_id || '').trigger('change'); }, 900);
              $('#turma_especie').val(d.turma_especie || '');
              $('#turma_especie_display').val(d.turma_especie || '');
              $('#nome_responsavel').val(d.nome_responsavel || '');
              $('#data_nasc_responsavel').val(d.data_nasc_responsavel || '').trigger('change');
              $('#cpf_responsavel').val(formatCPF(d.cpf_responsavel || ''));
              $('#email_responsavel').val(d.email_responsavel || '');
              $('#tel_cel_responsavel').val(formatPhone(d.tel_cel_responsavel || ''));
              $('#tel_fixo_responsavel').val(formatPhone(d.tel_fixo_responsavel || ''));
              $('#vulneravel_social').val(d.vulneravel_social || '').trigger('change');
              $('#portador_deficiencia').val(d.portador_deficiencia || '').trigger('change');
              $('#deficiencias_tipo').val(d.deficiencias_tipo || '').trigger('change');
              $('#grau_parentesco').val(d.grau_parentesco || '').trigger('change');
            } else {
              $('[data-error="cpf_candidato"]').text('Nenhuma matrícula encontrada para este CPF.');
            }
          },
          error: function(xhr){
            try {
              var resp = xhr.responseJSON || JSON.parse(xhr.responseText || '{}');
              if (resp && resp.error) {
                $('[data-error=\"cpf_candidato\"]').text(resp.error);
              }
              console.log('Erro buscar CPF', resp);
            } catch(e) {
              console.log('Erro buscar CPF', e);
            }
          }
        });
      });

      var cpfSearchTimeout = null;
      var cpfLastQueried = '';
      $('#cpf_candidato').on('input', function() {
        var v = $(this).val();
        $(this).val(formatCPF(v));
        var digits = onlyDigits(v);
        if (digits.length === 11 && digits !== cpfLastQueried) {
          clearTimeout(cpfSearchTimeout);
          cpfSearchTimeout = setTimeout(function(){
            cpfLastQueried = digits;
            $('#cpf_candidato').trigger('change');
          }, 200);
        }
      });
      $('#cpf_candidato').on('blur', function(){
        var ok = validateCPF($(this).val());
        $('[data-error=\"cpf_candidato\"]').text(ok ? '' : 'CPF Inválido');
        if (onlyDigits($(this).val()).length === 11) {
          $('#cpf_candidato').trigger('change');
        }
      });

      $('#btnNovaInscricao').on('click', function() {
        resetFormulario();
        var modalEl = document.getElementById('modalSucesso');
        var inst = bootstrap.Modal.getInstance(modalEl);
        if (inst) inst.hide();
      });
    });
  </script>
</body>

</html>
<?php /**PATH D:\app_filament5_inicio\app\resources\views/inscritos.blade.php ENDPATH**/ ?>