<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Inscritos</title>
    <link rel="stylesheet" href="{{ Request::root() }}/bt/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ Request::root() }}/bt/css/main.css">
<style>
html,body{height:100%}
body{margin:0}
body::before{content:"";position:fixed;inset:0;background:
radial-gradient(1000px 400px at 10% 10%, rgba(255,255,255,.08), transparent 50%),
radial-gradient(1000px 400px at 90% 90%, rgba(255,255,255,.08), transparent 50%);
pointer-events:none;}
.glass-card{background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.28);backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);border-radius:16px;box-shadow:0 18px 40px rgba(0,0,0,0.35);}
.header-title{color:#fff;text-shadow:0 2px 12px rgba(0,0,0,0.4);}
.card-header{background:transparent;border-bottom:1px solid rgba(255,255,255,0.25);color:#fff;font-weight:600}
.form-label{color:#fff}
.form-control,.form-select{background:rgba(255,255,255,0.92);border:1px solid rgba(0,0,0,0.12)}
.btn-primary{background:linear-gradient(135deg,#1e88e5,#0d47a1);border:0;box-shadow:0 10px 24px rgba(13,71,161,.35)}
.btn-primary:hover{filter:brightness(1.06)}
.alert-success{background:rgba(46,204,113,0.18);border-color:rgba(46,204,113,0.38);color:#fff}
.site-header{position:fixed;top:0;left:0;right:0;z-index:1000;background:rgba(6,19,77,0.35);backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px);border-bottom:1px solid rgba(255,255,255,0.2)}
.header-inner{display:flex;justify-content:center;align-items:center;padding:16px 0}
.header-logo{height:80px;width:auto}
.site-footer{position:fixed;bottom:0;left:0;right:0;z-index:1000;background:rgba(6,19,77,0.35);backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px);border-top:1px solid rgba(255,255,255,0.2)}
.footer-inner{display:flex;justify-content:center;align-items:center;padding:12px 0}
.footer-logo{height:36px;width:auto;margin-right:10px}
.footer-text{color:#fff;font-weight:500}
.page-main{padding-top: calc(96px + 32px); padding-bottom: calc(64px + 48px); min-height: calc(100vh - 96px - 64px)}
</style>
</head>
<body style="min-height:100vh;background-image:linear-gradient(225deg,rgba(17,60,125,0.35),rgba(6,19,77,0.35));background-repeat:no-repeat;background-attachment:fixed;background-position:center top;background-size:cover;">
<header class="site-header">
  <div class="container header-inner">
    <img src="/img/smeel-branco.png" alt="SMEEL" class="header-logo">
  </div>
  </header>
<main class="page-main">
<div class="container py-4" style="max-width: 960px;">
    <h1 class="mb-4 header-title">Inscrição</h1>

    <div id="sucesso" class="alert alert-success d-none" role="alert">
        <div class="d-flex justify-content-between align-items-center">
            <span>Inscrição realizada com sucesso.</span>
            <div>
                <a id="btnDownload" class="btn btn-outline-secondary btn-sm me-2" href="#">Download</a>
                <a id="btnImprimir" class="btn btn-outline-secondary btn-sm" href="#" target="_blank">Imprimir</a>
            </div>
        </div>
    </div>

    <form id="formInscricao">
        <input type="hidden" name="ano_letivo" id="ano_letivo" value="{{ now()->year }}">

        <div class="card glass-card mb-3">
            <div class="card-header">Dados do Candidato</div>
            <div class="card-body">
                <div class="row gy-5 gx-4">
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
                            @foreach($distritos as $d)
                                <option value="{{ $d->id }}">{{ $d->distrito }}</option>
                            @endforeach
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
                            @foreach($deficiencias as $item)
                                <option value="{{ $item->id }}">{{ $item->tipo_deficiencia }}</option>
                            @endforeach
                        </select>
                        <div class="text-danger small" data-error="deficiencias_tipo"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card glass-card mb-3">
            <div class="card-header">Dados do Responsável</div>
            <div class="card-body">
                <div class="row gy-5 gx-4">
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
                        <input type="email" class="form-control" name="email_responsavel" id="email_responsavel" required>
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
  </form>
</div>

</main>

<footer class="site-footer">
  <div class="container footer-inner">
    <img src="/img/smeel-branco.png" alt="SMEEL" class="footer-logo">
    <span class="footer-text">Secretaria Municipal de Educação</span>
  </div>
  </footer>

<script src="{{ Request::root() }}/bt/vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="{{ Request::root() }}/bt/vendor/bootstrap/js/bootstrap.min.js"></script>
<script>
$(function() {
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
  function onlyDigits(s){ return s.replace(/\D+/g,''); }
  function formatCPF(v){ var d=onlyDigits(v).slice(0,11); var out=''; if(d.length>0){ out=d.substring(0,3);} if(d.length>=4){ out+='.'+d.substring(3,6);} if(d.length>=7){ out+='.'+d.substring(6,9);} if(d.length>=10){ out+='-'+d.substring(9,11);} return out; }
  function validateCPF(cpf){ cpf=onlyDigits(cpf); if(cpf.length!==11) return false; if(/^(?:([0-9])\1+)$/.test(cpf)) return false; var soma=0; for(var i=0;i<9;i++){ soma+=parseInt(cpf.charAt(i))*(10-i);} var resto=11-(soma%11); var dv1=resto>9?0:resto; soma=0; for(var i2=0;i2<10;i2++){ soma+=parseInt(cpf.charAt(i2))*(11-i2);} resto=11-(soma%11); var dv2=resto>9?0:resto; if(dv1!==parseInt(cpf.charAt(9))||dv2!==parseInt(cpf.charAt(10))) return false; var cpfCompleto=cpf.substr(0,9)+dv1+dv2; var invalidos=['00000000000','11111111111','22222222222','33333333333','44444444444','55555555555','66666666666','77777777777','88888888888','99999999999']; if(invalidos.indexOf(cpfCompleto)>=0) return false; var somaCpf=0; for(var j=0;j<9;j++){ somaCpf+=parseInt(cpfCompleto.charAt(j))*(10-j);} resto=11-(somaCpf%11); if(resto===10||resto===11) resto=0; if(resto!==parseInt(cpfCompleto.charAt(9))) return false; somaCpf=0; for(var k=0;k<10;k++){ somaCpf+=parseInt(cpfCompleto.charAt(k))*(11-k);} resto=11-(somaCpf%11); if(resto===10||resto===11) resto=0; if(resto!==parseInt(cpfCompleto.charAt(10))) return false; return true; }
  function formatPhone(v){ var d=onlyDigits(v).slice(0,11); if(d.length<=2){ return d;} if(d.length<=6){ return '('+d.slice(0,2)+') '+d.slice(2);} if(d.length<=10){ return '('+d.slice(0,2)+') '+d.slice(2,6)+'-'+d.slice(6);} return '('+d.slice(0,2)+') '+d.slice(2,7)+'-'+d.slice(7);}
  $('#cpf_candidato').on('input', function(){ $(this).val(formatCPF($(this).val())); });
  $('#cpf_candidato').on('blur', function(){ var ok=validateCPF($(this).val()); $('[data-error="cpf_candidato"]').text(ok?'':'CPF Inválido'); });
  $('#cpf_responsavel').on('input', function(){ $(this).val(formatCPF($(this).val())); });
  $('#cpf_responsavel').on('blur', function(){ var v=$(this).val(); if(v){ var ok=validateCPF(v); $('[data-error="cpf_responsavel"]').text(ok?'':'CPF Inválido'); } else { $('[data-error="cpf_responsavel"]').text(''); } });
  $('#tel_cel_responsavel').on('input', function(){ $(this).val(formatPhone($(this).val())); });
  $('#tel_fixo_responsavel').on('input', function(){ $(this).val(formatPhone($(this).val())); });

  function definirTurma(dataNascimento) {
    if (!dataNascimento) return 'Não atribuída';
    var nascimento = new Date(dataNascimento);
    var hoje = new Date();
    var anoAtual = hoje.getFullYear();
    var dataCorte = new Date(anoAtual, 2, 31);

    var idadeMesesCorte = (dataCorte.getFullYear() - nascimento.getFullYear()) * 12 + (dataCorte.getMonth() - nascimento.getMonth());
    if (nascimento.getDate() > dataCorte.getDate()) idadeMesesCorte -= 1;

    var bercarioA_ini = new Date(anoAtual - 1, 2, 31);
    var bercarioA_fim = dataCorte;
    var bercarioB_ini = new Date(anoAtual - 2, 2, 31);
    var bercarioB_fim = new Date(anoAtual - 1, 2, 31);
    var nivel1_ini = new Date(anoAtual - 3, 2, 31);
    var nivel1_fim = new Date(anoAtual - 2, 2, 31);
    var nivel2_ini = new Date(anoAtual - 4, 2, 31);
    var nivel2_fim = new Date(anoAtual - 3, 2, 31);

    if ((idadeMesesCorte >= 6 && idadeMesesCorte <= 11) || (nascimento >= bercarioA_ini && nascimento <= bercarioA_fim)) return 'BERÇÁRIO A';
    if ((idadeMesesCorte >= 12 && idadeMesesCorte <= 23) || (nascimento >= bercarioB_ini && nascimento <= bercarioB_fim)) return 'BERÇÁRIO B';
    if ((idadeMesesCorte >= 24 && idadeMesesCorte <= 35) || (nascimento >= nivel1_ini && nascimento <= nivel1_fim)) return 'Nível 1';
    if ((idadeMesesCorte >= 36 && idadeMesesCorte <= 47) || (nascimento >= nivel2_ini && nascimento <= nivel2_fim)) return 'Nível 2';
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
    if (dias < 0) { meses--; dias += new Date(hoje.getFullYear(), hoje.getMonth(), 0).getDate(); }
    if (meses < 0) { anos--; meses += 12; }

    var anoLetivo = hoje.getFullYear();
    var corte = new Date(anoLetivo, 2, 31);
    var anosC = corte.getFullYear() - dn.getFullYear();
    var mesesC = corte.getMonth() - dn.getMonth();
    var diasC = corte.getDate() - dn.getDate();
    if (diasC < 0) { mesesC--; var ultimoDiaMesAnterior = new Date(corte.getFullYear(), corte.getMonth(), 0).getDate(); diasC += ultimoDiaMesAnterior; }
    if (mesesC < 0) { anosC--; mesesC += 12; }
    diasC--; if (diasC < 0) { mesesC--; diasC = new Date(corte.getFullYear(), corte.getMonth() - 1, 0).getDate() - 2; if (mesesC < 0) { anosC--; mesesC = 11; } }
    if (dn > corte) { anosC = 0; mesesC = 0; diasC = 0; }

    var texto = '';
    if (anosC > 0) texto += anosC + (anosC === 1 ? ' ano' : ' anos');
    if (mesesC > 0) { if (texto) texto += ', '; texto += mesesC + (mesesC === 1 ? ' mês' : ' meses'); }
    if (diasC > 0) { if (texto) texto += ' e '; texto += diasC + (diasC === 1 ? ' dia' : ' dias'); }
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

  $('#data_nascimento').on('change', function(){ atualizarIdadeECorte($(this).val()); });

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
    $.post('/matricula/consultar-bairro', { distrito: distrito }, function(resp) {
      var dados = resp.data || [];
      dados.forEach(function(b) {
        var label = (b.descricao || b.escola_bairro_id || 'Bairro');
        $('#escola_bairro_id').append('<option value="'+b.id+'">'+label+'</option>');
      });
    });
  });

  $('#escola_bairro_id').on('change', function() {
    var bairro_id = $(this).val();
    $('#escola_nome_id').empty().append('<option value="">Selecionar</option>');
    $('#turma_id').empty().append('<option value="">Selecionar</option>');
    if (!bairro_id) return;
    $.post('/matricula/consultar-escola', { bairro_id: bairro_id, turma_especie: $('#turma_especie').val() }, function(resp) {
      var dados = resp.data || [];
      dados.forEach(function(e) {
        $('#escola_nome_id').append('<option value="'+e.id+'">'+(e.escola_nome || e.nome || 'Escola')+'</option>');
      });
    });
  });

  $('#escola_nome_id').on('change', function() {
    var escola_id = $(this).val();
    $('#turma_id').empty().append('<option value="">Selecionar</option>');
    if (!escola_id) return;
    $.post('/matricula/consultar-turma', { escola_id: escola_id }, function(resp) {
      var dados = resp.data || [];
      dados.forEach(function(t) {
        var label = (t.tipo_descricao ? t.tipo_descricao : (t.turma_nome || 'Turma'));
        $('#turma_id').append('<option value="'+t.id+'">'+label+'</option>');
      });
    });
  });

  function clearErrors() {
    $('[data-error]').text('');
  }

  function showErrors(errors) {
    Object.keys(errors || {}).forEach(function(k){
      var msg = errors[k] && errors[k][0] ? errors[k][0] : '';
      $('[data-error="'+k+'"]').text(msg);
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
      data: dados,
      success: function(resp) {
        var id = resp.id;
        $('#sucesso').removeClass('d-none');
        $('#btnDownload').attr('href', '/matricula/comprovante/'+id+'/d');
        $('#btnImprimir').attr('href', '/matricula/comprovante/'+id+'/p');
        $('html, body').animate({ scrollTop: 0 }, 300);
      },
      error: function(xhr) {
        if (xhr.responseJSON && xhr.responseJSON.errors) {
          showErrors(xhr.responseJSON.errors);
        }
      }
    });
  });
});
</script>
</body>
</html>
