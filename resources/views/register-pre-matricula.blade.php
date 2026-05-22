<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pré-matrícula</title>
    <link rel="stylesheet" type="text/css" href="{{Request::root()}}/bt/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{Request::root()}}/bt/css/util.css">
    <link rel="stylesheet" type="text/css" href="{{Request::root()}}/bt/css/main.css">
    <link rel="stylesheet" type="text/css" href="{{Request::root()}}/bt/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="{{Request::root()}}/bt/images/img-01.png" alt="IMG">
                </div>
                <form action="/register/pre-matricula" method="POST" class="login100-form validate-form">
                    @csrf
                    <span class="login100-form-title">Pré-matrícula</span>

                    @if(session('status'))
                        <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                    @endif

                    <div class="wrap-input100 validate-input" data-validate="Digite seu nome">
                        <input class="input100" type="text" name="nome" placeholder="Nome" value="{{ old('nome') }}">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </span>
                    </div>
                    @error('nome')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror

                    <div class="wrap-input100 validate-input" data-validate="Digite seu CPF">
                        <input class="input100" type="text" name="cpf" id="cpf" placeholder="000.000.000-00" value="{{ old('cpf') }}">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-id-card" aria-hidden="true"></i>
                        </span>
                    </div>
                    @error('cpf')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">Enviar</button>
                    </div>

                    <div class="text-center p-t-12">
                        <a class="txt2" href="/pre-matricula">Abrir formulário completo</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{Request::root()}}/bt/vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="{{Request::root()}}/bt/vendor/bootstrap/js/popper.js"></script>
    <script src="{{Request::root()}}/bt/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{Request::root()}}/bt/vendor/select2/select2.min.js"></script>
    <script src="{{Request::root()}}/bt/vendor/tilt/tilt.jquery.min.js"></script>
    <script>
        $('.js-tilt').tilt({ scale: 1.1 });
        function onlyDigits(v){ return (v||'').replace(/\D+/g,''); }
        function formatCPF(v){ var d=onlyDigits(v).slice(0,11); var out=''; if(d.length>0){ out+=d.slice(0,3);} if(d.length>3){ out+='.'+d.slice(3,6);} if(d.length>6){ out+='.'+d.slice(6,9);} if(d.length>9){ out+='-'+d.slice(9,11);} return out; }
        function validateCPF(cpf){ cpf=onlyDigits(cpf); if(cpf.length!==11) return false; if(/^(?:([0-9])\1+)$/.test(cpf)) return false; var soma=0; for(var i=0;i<9;i++){ soma+=parseInt(cpf.charAt(i))*(10-i);} var resto=11-(soma%11); var dv1=resto>9?0:resto; soma=0; for(var i2=0;i2<10;i2++){ soma+=parseInt(cpf.charAt(i2))*(11-i2);} resto=11-(soma%11); var dv2=resto>9?0:resto; if(dv1!==parseInt(cpf.charAt(9))||dv2!==parseInt(cpf.charAt(10))) return false; var cpfCompleto=cpf.substr(0,9)+dv1+dv2; var invalidos=['00000000000','11111111111','22222222222','33333333333','44444444444','55555555555','66666666666','77777777777','88888888888','99999999999']; if(invalidos.indexOf(cpfCompleto)>=0) return false; var somaCpf=0; for(var j=0;j<9;j++){ somaCpf+=parseInt(cpfCompleto.charAt(j))*(10-j);} resto=11-(somaCpf%11); if(resto===10||resto===11) resto=0; if(resto!==parseInt(cpfCompleto.charAt(9))) return false; somaCpf=0; for(var k=0;k<10;k++){ somaCpf+=parseInt(cpfCompleto.charAt(k))*(11-k);} resto=11-(somaCpf%11); if(resto===10||resto===11) resto=0; if(resto!==parseInt(cpfCompleto.charAt(10))) return false; return true; }
        $('#cpf').on('input', function(){ $(this).val(formatCPF($(this).val())); });
    </script>
    <script src="{{Request::root()}}/bt/js/main.js"></script>
</body>
</html>
