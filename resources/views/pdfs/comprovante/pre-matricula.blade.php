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

    <div class="row">
        <div class="logo">
            <img src="{{ public_path('img/brasao-pmm-smeel-black.png') }}" alt="Logo" class="logo-img">
        </div>
        <div class="text-processo">
            <h5>PRE-MATRICULA SIMPLIFICADO - EDITAL 001/2024</h5>
        </div>
    </div>
    <br>
    <hr>
    <div class="row">
        <div class="text-center">
            <p><strong>COMPROVANTE DE INSCRIÇÃO DE PRE-MATRICULA</strong></p>
        </div>
    </div>
    
    <div class="row">
       
        <div class="text-left">
            <p>
             <strong>Inscrição:</strong> {{ $matricula->id }} - <strong>Nome do Candidato:</strong> {{$matricula->nome}}<br>
             <strong>CPF:</strong> {{ $matricula->cpf }} - <strong>Vaga Pretendida:</strong> {{$turma->titulo}}
            </p>
        </div>

    </div>

    <div class="row">
        <p style="font-size: 9px;">Relação das Cópias dos Documentos Entregues</p>
        <table>
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Pontos.</th>                  
                </tr>
            </thead>
            <tbody>
                @foreach ($candidato_xps as $xp)                   
               
                <tr>               
                    <td>{{$xp->titulo}}</td>
                    <td>{{$xp->pontos}}</td>
                </tr>

                @endforeach             
            
            </tbody>            
        </table>
    </div>

    <div class="row" style="height: 100px;">
        <div class="assinatura text-center" >
            <p>Mangaratiba, {{date("d/m/Y")}}</p>
       
            <p>___________________________________</p>
            <p style="position: relative; top: -15px;">Assinatura do Candidato</p>
        </div>
        <div class="assinatura text-center">
            <p>Mangaratiba, {{date("d/m/Y")}}</p>
      
            <p>___________________________________</p>
            <p style="position: relative; top: -15px;">Assinatura do Servidor Atendente</p>
        </div>
    </div>

    <div class="row">
        <hr size="1" style="border:1px dashed rgb(63, 64, 63);">
    </div>

    <div class="row">
       
        <div class="text-left">
            <p>
             <strong>Inscrição:</strong> {{ $matricula->id }} - <strong>Nome do Candidato:</strong> {{$matricula->nome}}<br>
             <strong>CPF:</strong> {{ $matricula->cpf }} - <strong>Vaga Pretendida:</strong> {{$turma->titulo}}
            </p>
        </div>

    </div>

    <div class="row">
        <p style="font-size: 9px;">Relação das Cópias dos Documentos Entregues</p>
        <table>
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Pontos.</th>                  
                </tr>
            </thead>
            <tbody>
                @foreach ($candidato_xps as $xp)                   
               
                <tr>               
                    <td>{{$xp->titulo}}</td>
                    <td>{{$xp->pontos}}</td>
                </tr>

                @endforeach             
            
            </tbody>       
        </table>
    </div>

    <div class="row" style="height: 170px;">
        <div class="assinatura text-center" >
            <p>Mangaratiba, {{date("d/m/Y")}}</p>
        
            <p>___________________________________</p>
            <p style="position: relative; top: -15px;">Assinatura do Candidato</p>
        </div>
        <div class="assinatura text-center">
            <p>Mangaratiba, {{date("d/m/Y")}}</p>
   
            <p>___________________________________</p>
            <p style="position: relative; top: -15px;">Assinatura do Servidor Atendente</p>
        </div>
    </div>
    
</body>
</html>