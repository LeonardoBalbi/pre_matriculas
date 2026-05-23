<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alternar Manutenção</title>
    @include('partials.pwa')
    <style>
        body { display: flex; align-items: center; justify-content: center; height: 100vh; background: #f8fafc; }
        .box { text-align: center; background: #fff; padding: 40px 60px; border-radius: 10px; box-shadow: 0 2px 8px #0001; }
        h1 { color: #2c3e50; }
        p { color: #555; }
        .btn { padding: 12px 32px; font-size: 18px; border: none; border-radius: 5px; cursor: pointer; margin-top: 20px; }
        .btn-on { background: #e74c3c; color: #fff; }
        .btn-off { background: #27ae60; color: #fff; }
    </style>
</head>
<body>
    <div class="box">
        <h1>Modo Manutenção</h1>
        <p>Status atual: <strong>{{ $ativo ? 'ATIVADO' : 'DESATIVADO' }}</strong></p>
        <form method="POST" action="{{ route('toggle-manutencao') }}">
            @csrf
            @if($ativo)
                <button type="submit" class="btn btn-off">
                    Desativar manutenção
                </button>
            @else
                <button type="submit" name="ativo" value="1" class="btn btn-on">
                    Ativar manutenção
            </button>
            @endif
        </form>
        @if (session('status'))
            <p style="margin-top:20px;color:#2980b9;">{{ session('status') }}</p>
        @endif
    </div>
</body>
</html>
