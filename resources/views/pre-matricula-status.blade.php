<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Status da Pré-Matrícula</title>
    @include('partials.pwa')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="/">Portal da Matrícula</a>
    </nav>

    <div class="container mt-4">
    <h1 class="text-center">Classificados</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('register.pre-matricula.status') }}" class="mb-4">
        <div class="form-row">
            <div class="col-md-10">
                <input
                    type="text"
                    name="nome"
                    class="form-control"
                    placeholder="Buscar por nome do candidato"
                    value="{{ request('nome') }}"
                >
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary btn-block">Buscar</button>
            </div>
        </div>
    </form>

    @if($matriculas->count() === 0)
        <div class="alert alert-warning">
            Nenhuma matrícula apta encontrada.
        </div>
    @else
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Protocolo</th>
                    <th>Nome do Candidato</th>
                    <th>Ano Letivo</th>
                    {{-- <th>Ações</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($matriculas as $matricula)
                    <tr>
                        <td>{{ $matricula->protocolo }}</td>
                        <td>{{ $matricula->nome_candidato }}</td>
                        <td>{{ $matricula->ano_letivo }}</td>
                        <td style="width: 300px;">
                            <a
                                class="btn btn-success btn-sm"
                                href="{{ \Illuminate\Support\Facades\URL::signedRoute('pre-matricula.confirmar.get', ['id' => $matricula->id]) }}"
                            >
                                Confirmar matrícula
                            </a>
                            <button class="btn btn-info btn-sm mt-2" type="button" data-toggle="collapse" data-target="#wa-form-{{ $matricula->id }}">Enviar WhatsApp</button>
                            <div class="collapse mt-2" id="wa-form-{{ $matricula->id }}" data-protocolo="{{ $matricula->protocolo }}" data-nome="{{ $matricula->nome_candidato }}" data-escola="{{ $matricula->escola ? $matricula->escola->escola_nome : 'Não informado' }}" data-ano="{{ $matricula->ano_letivo }}" data-url="{{ route('matricula.comprovante', ['id' => base64_encode($matricula->id), 'tipo' => 'd']) }}">
                                <form>
                                    <div class="form-group mb-2">
                                        <input type="text" name="nome" class="form-control form-control-sm" placeholder="Nome do responsável" value="{{ $matricula->nome_responsavel ?? $matricula->nome_candidato }}">
                                    </div>
                                    <div class="form-group mb-2">
                                        <input type="text" name="telefone" class="form-control form-control-sm" placeholder="Telefone (opcional)" value="{{ $matricula->tel_cel_responsavel }}">
                                    </div>
                                    <div class="form-group mb-2">
                                        <textarea name="mensagem" class="form-control form-control-sm" rows="2" placeholder="Mensagem do WhatsApp"></textarea>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="openWhatsApp('{{ $matricula->id }}')">Abrir WhatsApp Web</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $matriculas->links('pagination::bootstrap-4') }}
    @endif

    </div>

    <!-- Footer -->
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container text-center">
            <span class="text-muted">&copy; {{ date('Y') }} Prefeitura Municipal de Mangaratiba - Secretaria de Educação</span>
        </div>
    </footer>

    <script>
        function openWhatsApp(id) {
            var form = document.querySelector('#wa-form-' + id + ' form');
            var nome = form.querySelector('input[name=nome]').value.trim();
            var telInput = form.querySelector('input[name=telefone]');
            var tel = (telInput.value || telInput.getAttribute('value') || '').replace(/[^0-9]/g, '');
            if (!tel) return;
            if (!tel.startsWith('55')) {
                if (tel.length === 10) {
                    tel = '55' + tel.slice(0, 2) + '9' + tel.slice(2);
                } else {
                    tel = '55' + tel;
                }
            } else {
                if (tel.length === 12) {
                    tel = tel.slice(0, 4) + '9' + tel.slice(4);
                }
            }
            var wrap = document.querySelector('#wa-form-' + id);
            var msg = form.querySelector('textarea[name=mensagem]').value.trim();
            if (!msg) {
                var proto = wrap.getAttribute('data-protocolo') || '';
                var aluno = wrap.getAttribute('data-nome') || '';
                var escola = wrap.getAttribute('data-escola') || '';
                var ano = wrap.getAttribute('data-ano') || '';
                var link = wrap.getAttribute('data-url') || '';
                msg = 'MATRÍCULA CONFIRMADA\n\nProtocolo: ' + proto + '\nAluno: ' + aluno + '\nEscola: ' + escola + '\nAno Letivo: ' + ano + '\nComprovante: ' + link;
            }
            var url = 'https://web.whatsapp.com/send/?phone=' + tel + '&text=' + encodeURIComponent('Olá, ' + nome + '!\n\n' + msg);
            window.open(url, '_blank');
        }
        document.querySelectorAll('[data-toggle="collapse"]').forEach(function(btn){
            btn.addEventListener('click', function(){
                var target = document.querySelector(btn.getAttribute('data-target'));
                if (!target) return;
                if (target.style.display === 'none' || !target.style.display) {
                    target.style.display = 'block';
                } else {
                    target.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
