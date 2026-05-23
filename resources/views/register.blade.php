<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro</title>
    @include('partials.pwa')
    <link rel="stylesheet" type="text/css" href="{{Request::root()}}/bt/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{Request::root()}}/bt/css/util.css">
    <link rel="stylesheet" type="text/css" href="{{Request::root()}}/bt/css/main.css">
</head>
<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="{{Request::root()}}/bt/images/img-01.png" alt="IMG">
                </div>
                <form action="/register" method="POST" class="login100-form validate-form">
                    @csrf
                    <span class="login100-form-title">Criar Conta</span>
                    <div class="wrap-input100 validate-input" data-validate="Digite seu nome">
                        <input class="input100" type="text" name="name" placeholder="Nome" value="{{ old('name') }}">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </span>
                    </div>
                    @error('name')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                    <div class="wrap-input100 validate-input" data-validate="Digite um e-mail válido">
                        <input class="input100" type="email" name="email" placeholder="Email" value="{{ old('email') }}">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>
                    @error('email')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                    <div class="wrap-input100 validate-input" data-validate="Digite uma senha">
                        <input class="input100" type="password" name="password" placeholder="Senha">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>
                    @error('password')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                    <div class="wrap-input100 validate-input" data-validate="Confirme sua senha">
                        <input class="input100" type="password" name="password_confirmation" placeholder="Confirmar senha">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">Registrar</button>
                    </div>
                    <div class="text-center p-t-12">
                        <a class="txt2" href="/login">Já tenho conta</a>
                        <br><br>
                        <a class="txt2" href="/register/api">
                            Cadastrar via API
                            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                        </a>
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
        $('.js-tilt').tilt({ scale: 1.1 })
    </script>
    <script src="{{Request::root()}}/bt/js/main.js"></script>
</body>
</html>
