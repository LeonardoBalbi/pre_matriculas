<!DOCTYPE html>
<html lang="en">
<head>
	<title>LOGIN API - SME</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="{{Request::root()}}/bt/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{Request::root()}}/bt/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{Request::root()}}/bt/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{Request::root()}}/bt/vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{Request::root()}}/bt/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{Request::root()}}/bt/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{Request::root()}}/bt/css/util.css">
	<link rel="stylesheet" type="text/css" href="{{Request::root()}}/bt/css/main.css">
<!--===============================================================================================-->
</head>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="{{Request::root()}}/bt/images/img-01.png" alt="IMG">
				</div>

				<form action="{{ route('register.login.store') }}" method="POST" class="login100-form validate-form">
                    @csrf

					<span class="login100-form-title">
						Login
					</span>
                    <div class="text-center mb-3">
                        <small>Entre com suas credenciais para acessar o formulário</small>
                    </div>

					<div class="wrap-input100 validate-input" data-validate = "Email válido requerido">
						<input class="input100" type="text" name="email" placeholder="Email" value="{{ old('email') }}">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>
                    @error('email')
                        <div class="text-danger pl-3">{{ $message }}</div>
                    @enderror

					<div class="wrap-input100 validate-input" data-validate = "Senha é obrigatória">
						<input class="input100" type="password" name="password" placeholder="Senha">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
                    @error('password')
                        <div class="text-danger pl-3">{{ $message }}</div>
                    @enderror

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>

					<div class="text-center p-t-12">
						<span class="txt1">
							Não tem conta?
						</span>
						<a class="txt2" href="/api/register">
							Cadastrar na API
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>

<!--===============================================================================================-->
	<script src="{{Request::root()}}/bt/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="{{Request::root()}}/bt/vendor/bootstrap/js/popper.js"></script>
	<script src="{{Request::root()}}/bt/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="{{Request::root()}}/bt/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="{{Request::root()}}/bt/vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="{{Request::root()}}/bt/js/main.js"></script>

</body>
</html>
