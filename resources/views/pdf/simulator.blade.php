<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Empréstimo</title>
    <style>
        .texto {
            font-family: Arial, sans-serif;
            text-align: justify;

        }
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }
        p {
            margin: 0 0 15px;
        }
    </style>
</head>
<body>
    <h3>Simulação de empréstimo</h3>
    <div class="row">
        <p>Cliente:{{$tableData[0]['client']}}</p>
        <p>Empréstimo :{{$tableData[0]['valorEmprestimo']}}</p>
        <p>Data :{{$tableData[0]['dataEmprestimo']}}</p>
    </div>
    <div class="row texto">
        <p>
            A solicitação de empréstimo desempenha um papel crucial na realização de metas financeiras, permitindo
            a concretização de projetos e investimentos. No entanto, é igualmente importante entender a importância da
            quitação atempada para evitar encargos extras e manter a saúde financeira. Este documento é um instrumento
            que estabelece um prazo de validade de 5 dias a partir de sua emissão, visando garantir que ambas as partes
            tenham tempo suficiente para considerar a proposta. Caso não haja interesse na obtenção do empréstimo, a
            data de validade assegura que a oferta seja revista e ajustada de acordo com as necessidades do mutuário ou
            do mutuante.
        </p>
    </div>
    <div class="row">
        <div class="table-responsive mt-4">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th style="width: 10px; text-align: right; white-space: nowrap;">Parcela</th>
                    <th style="width: 50px; text-align: right; white-space: nowrap;">Empréstimo</th>
                    <th style="width: 30px; text-align: left; white-space: nowrap;">Data</th>
                    <th style="width: 60px; text-align: right; white-space: nowrap;">Total</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tableData as $data)
                    <tr>
                        <td style="width: 10px; text-align: right; white-space: nowrap;">{{ $data['parcela'] }} / {{ count($tableData) }}</td>
                        <td style="width: 50px; text-align: right; white-space: nowrap;">{{ $data['valorEmprestimo'] }}</td>
                        <td style="width: 30px; text-align: left; white-space: nowrap;">{{ $data['dataEmprestimo'] }}</td>
                        <td style="width: 60px; text-align: right; white-space: nowrap;">{{ $data['valorParcela'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
