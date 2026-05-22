<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manutenção</title>
    <style>
        body { display: flex; align-items: center; justify-content: center; height: 100vh; background: #f8fafc; }
        .box { text-align: center; background: #fff; padding: 40px 60px; border-radius: 10px; box-shadow: 0 2px 8px #0001; }
        h1 { color: #2c3e50; }
        p { color: #555; }
    </style>
</head>
<body>
    <div class="box">
        <h1>Site em Manutenção</h1>
        <p>Estamos realizando melhorias. Por favor, volte em breve.</p>
        <p style="color:gray;font-size:12px;">DEBUG: modo_manutencao = {{ \Illuminate\Support\Facades\Cache::get('modo_manutencao', false) ? 'ATIVO' : 'DESATIVADO' }}</p>
    </div>
    <script>
        // Checa a cada 2 segundos se o modo manutenção foi ativado ou desativado
        setInterval(async function() {
            try {
                const resp = await fetch('/manutencao-status');
                const data = await resp.json();
                const isManutencao = data.ativo;
                const isOnManutencaoPage = window.location.pathname === '/manutencao';
                if (isManutencao && !isOnManutencaoPage) {
                    window.location.href = '/manutencao';
                } else if (!isManutencao && isOnManutencaoPage) {
                    window.location.href = '/';
                }
            } catch (e) {}
        }, 2000);
    </script>
</body>
</html>
