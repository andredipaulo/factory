<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Empréstimo</title>
    <style>
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
    </style>
</head>
<body>
    <h3>Simulação de empréstimo</h3>
    <div class="row">
        <p>Cliente:{{$tableData[0]['client']}}  <span>Empréstimo :{{$tableData[0]['valorEmprestimo']}}</span> </p>
        <p>Data :{{$tableData[0]['dataEmprestimo']}}</p>
    </div>

    <div class="row">
        <div class="table-responsive mt-4">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th style="width: 10px; text-align: right; white-space: nowrap;">Parcela</th>
                    <th style="width: 50px; text-align: right; white-space: nowrap;">Empréstimo</th>
{{--                    <th>Juros(%)</th>--}}
{{--                    <th>Juros($)</th>--}}
                    <th style="width: 30px; text-align: left; white-space: nowrap;">Data</th>
                    <th style="width: 60px; text-align: right; white-space: nowrap;">Valor</th>
                    <th style="width: 60px; text-align: right; white-space: nowrap;">Total</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tableData as $data)
                    <tr>
                        <td style="width: 10px; text-align: right; white-space: nowrap;">{{ $data['parcela'] }} / {{ count($tableData) }}</td>
                        <td style="width: 50px; text-align: right; white-space: nowrap;">{{ $data['valorEmprestimo'] }}</td>
{{--                        <td>{{ $data['taxaJuros'] }}</td>--}}
{{--                        <td>{{ $data['valorJuros'] }}</td>--}}
                        <td style="width: 30px; text-align: left; white-space: nowrap;">{{ $data['dataEmprestimo'] }}</td>
                        <td style="width: 60px; text-align: right; white-space: nowrap;">{{ $data['valorDivido'] }}</td>
                        <td style="width: 60px; text-align: right; white-space: nowrap;">{{ $data['valorParcela'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
