@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Loans</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <button type="button" id="createLoan" class="btn btn-success" disabled>Incluir Empréstimo</button>
        </div>
    </div>
    <div>
        <div class="table-responsive mt-4">
            @if($loans->isEmpty())
                <h6> Não encontrou nenhuma informação pesquisada. </h6>
            @else

                <table id="tblLoans" class="table table-bordered table-hover minhaTable" style="width:100%">
                    <thead>
                    <tr>
                        <th hidden>#</th>
                        <th class="numero desktop">Id</th>
                        <th class="texto">Agiota</th>
                        <th class="texto">Cliente</th>
                        <th class="data desktop">Data</th>
                        <th class="numero">Valor</th>
                        <th class="numero">Atual</th>
                        <th class="numero desktop">Juros</th>
                        <th class="numero">Pago</th>
                        {{--                            <th class="data">Adicionado</th>--}}
                        {{--                            <th class="data">Atualizado</th>--}}
                        <th class="acoes">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($loans  as $loan)
                            <?php $newDate = new DateTime($loan->loan_date); ?>
                        <tr>
                            <td hidden></td>
                            <td class="numero desktop">{{ $loan->id }}</td>
                            <td class="texto">{{ $loan->sponsor->name }}</td>
                            <td class="texto">{{ $loan->client->first_name }} {{ $loan->client->last_name }}
                                @if(count($loan->payments) >0)<span class="float-right badge badge-success">{{ count($loan->payments) }}</span>@endif
                            </td>
                            <td class="data desktop">{{ $newDate->format("d/m/Y") }}</td>
                            {{--                            <td class="data desktop">{{ $loan->loan_date }} </td>--}}
                            <td class="numero">{{ number_format( $loan->amount_original, 2, ',', '.') }}</td>
                            <td class="numero">{{ number_format( $loan->amount, 2, ',', '.') }}</td>
                            <td class="numero desktop">{{ number_format( $loan->fees, 2, ',', '.') }}</td>
                            <td class="numero">{{ number_format( $loan->total_paid, 2, ',', '.') }}</td>
                            {{--                            <td class="data">{{ date_format($loan->created_at, 'd/m/Y') }}</td>--}}
                            {{--                            <td class="data">{{ date_format($loan->updated_at, 'd/m/Y') }}</td>--}}
                            <td class="acoes">
                                <meta name="csrf-token" content="{{ csrf_token() }}"/>
                                <a class="btn btn-primary btn-sm editLoan" data-loan="{{ json_encode($loan) }}">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                    Editar
                                </a>
                                <a onclick="deleteRegistro(  ' {{ route('loans.destroy',  $loan) }} ', {{ $loan->id }} ) "
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
        var clients    = [];
        var sponsors   = [];
        var payments   = [];

        var loan_id    = 0;
        var loan_date  = 0;

        //Instanciando o plugin DataTable
        $(document).ready(function (){
            $("#tblLoans").DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json',
                },
                autoWidth: true,
                // order: [[3, 'desc']],
                order: [[0, 'desc']],
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

        function montarTabelaPayments(data, tableId){

            $("#" + tableId + '>tbody>tr').remove();

            for( i=0; i<data.length; i++){
                line = showLinePayments(data[i]);
                $("#" + tableId + ">tbody").append(line);
            }
        };

        function showLinePayments(p){
            p.amount = p.amount === null ? 0 : p.amount;
            p.payment_date = formatarData(p.payment_date, 'DD-MM-YYYY');
            p.amount_fees = p.amount_fees === null ? 0 : p.amount_fees;
            p.amount_paid = p.amount_paid === null ? 0 : p.amount_paid;

            var line =
                "<tr>"+
                "<td class='data'>"+ p.payment_date +"</td>" +
                "<td class='numero'>"+ parseFloat(p.amount).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })  +"</td>" + //valor do emprestimo
                "<td class='numero'>"+ parseFloat(p.amount_fees).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })  +"</td>" + //valor do emprestimo
                "<td class='numero'>"+ parseFloat(p.amount_paid).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })  +"</td>" + //total pago da dividia

                "</tr>";

            return line;
        }

        document.querySelectorAll('#createPayment').forEach(function (button) {
            button.addEventListener("click", function () {

                // Faça uma requisição AJAX para buscar  com base no ID
                $.ajax({
                    url: '/loans/create', // Substitua pela URL correta
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

        // Quando o botão "editar" for clicado, mostre o modal
        /* modelo funcional de requisição via ajax */
        document.querySelectorAll('.editLoan').forEach(function (button) {
            button.addEventListener("click", function () {
                //pega a o objeto
                loan   = JSON.parse(this.getAttribute("data-loan"));

                // Faça uma requisição AJAX para buscar  com base no ID
                $.ajax({
                    url: '/loans/' + loan.id, // Substitua pela URL correta
                    method: 'GET',
                    dataType: 'json',
                    // success: function(data) {
                    success: function(dados) {

                        clients  = dados.loan['client'];
                        sponsors = dados.loan['sponsor'];
                        payments = dados.loan['payments'];

                        // Inserir o conteúdo do arquivo no modal
                        $('#modalContainer').html(dados.content);

                        //montarTabela( dados, 'tableEmprestimo' );

                        mostrarForm('modalEdit');
                        montarTabelaPayments( payments, 'tablePayments' );
                    },
                    error: function(error) {
                        // Lidar com erros, se houver
                        alert(error.responseJSON.message);
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
            $('#sponsors').select2({
                placeholder: 'Selecione um loans',
                width: '100%',
            });

            // Selecione a caixa de seleção e inicialize o Select2
            $('#clients').select2({
                placeholder: 'Selecione um cliente',
                width: '100%',
            });

            $('#amount_original').mask('0.000.000.000.000.000,00', {reverse: true});
            $('#amount').mask('0.000.000.000.000.000,00', {reverse: true});
            $('#fees').mask('0.000.000.000.000.000,00', {reverse: true});
            $('#total_paid').mask('0.000.000.000.000.000,00', {reverse: true});
        }
    </script>
@stop

