<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PRE-MATRICULA SIMPLIFICADO - EDITAL 001/2024</title>
</head>
<style>
    @page {
        margin: 0px;
    }
    body {
        margin-left: 40px;
        margin-right: 40px;
        margin-top: 20px;
        font: 1em sans-serif;
    }
    .row {
        display: flex;
        flex-wrap: wrap;
        width: 100%;

    }

    .logo-img {
        /* width: 100px; */
        height: 70px;
    }

    .logo{
        float: left;
    }

    .text-processo{
        text-align: right;
        margin-top: 10px;
    }

    .text-center{
        text-align: center;
    }

    .text-left{
        text-align: left;
    }

    hr{
        border: 1px solid rgb(142, 142, 142);
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    td, th {
        border: 1px solid rgb(142, 142, 142);
        font-size: 12px;
        /* text-align: left; */
        padding: 8px;
    }

    .assinatura{
        position: relative;
        width: 50%;
        float: left;
    }

</style>
<body>

    <div class="row center">
        <div class="logo">
            <img src="{{ public_path('img/brasao-pmm-smeel-black.png') }}" alt="Logo" class="logo-img">
        </div>
    </div>
    <br><br><br><br>
    <hr>

    <div class="row">
        <div class="text-center">
        <div class="text-center">
            <h5>EDITAL 04/SME/2025 DE 9 DE DEZEMBRO DE 2025</h5>
        </div>
            <p><strong>COMPROVANTE DE INSCRIÇÃO DE PRE-MATRICULA</strong></p>
        </div>

    </div>

    <div class="row center">

        <div class="text-center">
            <p>
             <strong>Protocolo: {{$protocolo}}</strong><br>
             <strong>Nome da Criança: {{$nome_candidato}}</strong> <br>
             <strong>Data de Nascimento: {{$data_nascimento}}</strong> <br>
             <strong>Escola: {{$escola_nome}}</strong> <br>
             <strong>Nome do Responsavel: {{$nome_responsavel}}</strong>
            </p>

            <p>
                <p>Mangaratiba: {{$data_atual}}</p>
            </p>

            <p style="font-size: 10px;">
                <i>
                    Obs: "O recibo de pré-matrícula confirma o cadastro do aluno(a)  na lista de espera do CEIM pretendido. A vaga  será confirmada de acordo com a disponibilidade, seguindo os critérios de prioridade estabelecidos no Edital. Caso o CEIM não ofereça a turma pretendida, o cadastro será remanejado para outra unidade escolar que ofereça atendimento"
                </i>
            </p>

        </div>

    </div>

</body>
</html>
