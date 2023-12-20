@extends('adminlte::page')

@section('title', 'Payments')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Payments</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <button type="button" id="createPayment" class="btn btn-success">Incluir Pagamento</button>
        </div>
    </div>
    <div>
        <div class="table-responsive mt-4">
            @if($payments->isEmpty())
                <h6> Não encontrou nenhuma informação pesquisada. </h6>
            @else

                <table id="tblSponsors" class="table table-bordered table-hover minhaTable" style="width:100%">
                    <thead>
                    <tr>
                        <th hidden>#</th>
                        <th class="numero">Id</th>
                        <th class="texto">Agiota</th>
                        <th class="texto">Cliente</th>
                        <th class="numero">Devedor</th>
                        <th class="data">Data(Empré)</th>
                        <th class="data">Data(Pagam)</th>
                        {{--                            <th class="data">Dias</th>--}}
                        <th class="numero">($)Juros</th>
                        <th class="numero">($)Valor</th>
                        {{--                            <th class="data">Adicionado</th>--}}
                        <th class="acoes">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($payments  as $payment)
                            <?php
                            $newDateLoanDate = new DateTime($payment->loan->loan_date);
                            $newPaymentDate = new DateTime($payment->payment_date);
//                                $interval =$newDateLoanDate->diff($newPaymentDate);
//                                $days = $interval->days;

                            ?>
                        <tr>
                            <td hidden></td>
                            <td class="numero">{{ $payment->loan_id }}</td>
                            <td class="texto">{{ $payment->loan->sponsor->name }}</td>
                            <td class="texto">{{ $payment->loan->client->first_name }} {{ $payment->loan->client->last_name }}</td>
                            <td class="numero">{{ $payment->amount }}</td>
                            <td class="data">{{ $newDateLoanDate->format("d/m/Y") }}</td>
                            <td class="data">{{ $newPaymentDate->format("d/m/Y") }}</td>
                            {{--                            <td class="data">{{ $days }}</td>--}}
                            <td class="numero">{{ $payment->amount_fees }}</td>
                            <td class="numero">{{ $payment->amount_paid }}</td>
                            {{--                            <td class="data">{{ date_format($payment->created_at, 'd/m/Y') }}</td>--}}
                            <td class="acoes">
                                <meta name="csrf-token" content="{{ csrf_token() }}"/>
                                <a onclick="deleteRegistro(  ' {{ route('payments.destroy',  $payment) }} ', {{ $payment->id }} ) "
                                   class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                    Excluir
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- Div oculta para carregar o conteúdo do modal -->
    <div id="modalContainer">

    </div>
@stop

@section('css')
    <!-- incio -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Adicione os links para as bibliotecas do AdminLTE, jQuery, Select2 e Select2 Bootstrap Theme -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/1.5.2/select2-bootstrap.min.css">
    <!-- fim -->
    <link rel="stylesheet" type="text/css" href="/css/factoryStyle.css">
@stop
@section('js')
    <!-- incio -->
    <script src="/js/factoryAction.js"></script>

    <!-- Inclua o jQuery DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Inclua o jQuery Mask Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>

        var loans      = [];

        var loan_id    = 0;
        var loan_date  = 0;

        //Instanciando o plugin DataTable
        $(document).ready(function (){
            $("#tblSponsors").DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json',
                },
                autoWidth: true,
            });
        });

        function montarTabela(data, tableId){
            var sumAmount = 0;

            $("#" + tableId + '>tbody>tr').remove();

            for( i=0; i<data.length; i++){

                sumAmount += parseFloat( data[i].amount );

                line = showLine(data[i]);

                $("#" + tableId + ">tbody").append(line);
            }

            document.getElementById("modalEditForm").elements['emprestado'].value  = sumAmount.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }); // 'pt-BR' representa o formato brasileiro;
        };

        function showLine(p){
            loan_date = formatarData(p.loan_date, 'DD-MM-YYYY');

            var line =
                "<tr>"+
                "<td>"+ p.id +"</td>" +
                "<td>"+ p.client.first_name + ' ' + p.client.last_name+"</td>" +//de quem pegou
                "<td>"+ loan_date +"</td>" +//data do emprestimo
                "<td>"+ parseFloat(p.amount).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })  +"</td>" + //valor do emprestimo
                "<td>"+ p.fees  +"</td>" +//taxa de juros
                "<td>"+ parseFloat(p.total_paid).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })  +"</td>" + //total pago da dividia
                "</tr>";

            return line;
        }

        document.querySelectorAll('#createPayment').forEach(function (button) {
            button.addEventListener("click", function () {

                // Faça uma requisição AJAX para buscar  com base no ID
                $.ajax({
                    url: '/payments/create', // Substitua pela URL correta
                    method: 'GET',
                    dataType: 'json',
                    // success: function(data) {
                    success: function(dados) {

                        // Inserir o conteúdo do arquivo no modal
                        $('#modalContainer').html(dados.content);

                        mostrarForm('modalCreate');

                    },
                    error: function() {
                        $('#limit').val("");
                        alert('Falha ao buscar dados.');
                    }
                });
            });
        });

        function mostrarForm( modal ) {
            // Mostrar o modal
            document.getElementById( modal ).style.display = "block";

            // Quando o botão "X" dentro do modal for clicado, feche o modal
            document.getElementById("modalClose").addEventListener("click", function() {
                document.getElementById(modal).style.display = "none";
            });

            // Quando o botão "X" dentro do modal for clicado, feche o modal
            document.getElementById("modalCancel").addEventListener("click", function() {
                document.getElementById(modal).style.display = "none";
            });

            // Selecione a caixa de seleção e inicialize o Select2
            $('#loan').select2({
                placeholder: 'Selecione um loans',
                width: '100%',
            });

            $('#loan').on('select2:select', function (e) {

                loan_id = e.params.data.id;
                // Faça uma requisição AJAX para buscar o usuário com base no ID
                $.ajax({
                    url: '/getLoan/' + loan_id, // Substitua pela URL correta
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Preencha o campo de texto com o dados retornado
                        $('#name').val(data.client.first_name+" "+data.client.last_name);
                        $('#sponsor').val(data.sponsor.name);
                        $('#amount').val(data.amount);
                        $('#fees').val(data.fees);
                        $('#payment_date').val(dataAtual);
                        $('#amount_fees').attr('placeholder', (data.amount * data.fees) /100);
                        $('#amount_paid').attr('placeholder', data.amount);

                    },
                    error: function() {
                        $('#name').val("");
                        alert('Falha ao buscar dados.');
                    }
                });
            });

            $('#amount').mask('0.000.000.000.000.000,00', {reverse: true});
            $('#fees').mask('0.000.000.000.000.000,00', {reverse: true});
            $('#amount_fees').mask('0.000.000.000.000.000,00', {reverse: true});
            $('#amount_paid').mask('0.000.000.000.000.000,00', {reverse: true});
        }
    </script>
@stop
