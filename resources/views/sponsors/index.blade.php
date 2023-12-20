@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Sponsors</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <button type="button" id="createSponsor" class="btn btn-success">Add Sponsor</button>
        </div>
    </div>
    <div>
        <div class="table-responsive mt-4">
            @if($sponsors->isEmpty())
                <h6> Não encontrou nenhuma informação pesquisada. </h6>
            @else

                <table id="tblSponsors" class="table table-bordered table-hover minhaTable" style="width: 100%">
                    <thead>
                    <tr>
                        <th class="numero">#</th>
                        <th class="texto">Nome</th>
                        <th class="data tablet">Atualizado</th>
                        <th class="acoes">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sponsors  as $sponsor)
                        <tr>
                            <td class="numero">{{ $sponsor->id }}</td>
                            <td class="texto">{{ $sponsor->name }}
                                @isset($sponsor->loans)
                                    @if(count($sponsor->loans) >0)
                                        <span class="float-right badge badge-success">{{ count($sponsor->loans) }}</span>
                                    @endif
                                @endisset
                            </td>
                            <td class="data tablet">{{ date_format($sponsor->updated_at, 'd/m/Y') }}</td>
                            <td class="acoes">
                                <a class="btn btn-primary btn-sm editSponsor" data-sponsor="{{ json_encode($sponsor) }}">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                    Editar
                                </a>
                                <meta name="csrf-token" content="{{ csrf_token() }}"/>
                                <a onclick="deleteRegistro(  ' {{ route('sponsors.destroy',  $sponsor) }} ', {{ $sponsor->id }} ) "
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
    <link rel="stylesheet" type="text/css" href="/css/factoryStyle.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../../../vendor/almasaeed2010/adminlte/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../../vendor/almasaeed2010/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../../vendor/almasaeed2010/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../../vendor/almasaeed2010/adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="../../../vendor/almasaeed2010/adminlte/dist/css/adminlte.min.css">
@stop

@section('js')
    <!-- Adicionando JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
            integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8="
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="/js/factoryAction.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.js"></script>
    <script>

        var sponsor    = [];
        var clients    = [];
        var loans      = [];
        var payments   = [];

        var sponsor_id = 0;
        var client_id  = 0;
        var amount     = 0;
        var fees       = 0;
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
            // var sumPaid = 0;

            $("#" + tableId + '>tbody>tr').remove();

            for( i=0; i<data.length; i++){

                sumAmount += parseFloat( data[i].amount );
                // sumPaid   += parseFloat( data[i].total_paid );

                line = showLine(data[i]);

                $("#" + tableId + ">tbody").append(line);
            }

            // for( i=0; i<pagagamentos.length; i++){
            //     recebido += parseFloat( pagagamentos[i].amount_paid );
            // }

            document.getElementById("modalEditForm").elements['emprestado'].value  = sumAmount.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }); // 'pt-BR' representa o formato brasileiro;
            // document.getElementById("modalEditForm").elements['recebido'].value    = recebido.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }); // 'pt-BR' representa o formato brasileiro;
            // document.getElementById("modalEditForm").elements['receber'].value     = sumPaid.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }); // 'pt-BR' representa o formato brasileiro;
        };

        function showLine(p){
            const loandate = formatarData(p.loan_date);

            var line =
                "<tr>"+
                "<td>"+ p.id +"</td>" +
                "<td>"+ p.client.first_name + ' ' + p.client.last_name+"</td>" +//de quem pegou
                "<td>"+ loandate +"</td>" +//data do emprestimo
                "<td>"+ parseFloat(p.amount).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })  +"</td>" + //valor do emprestimo
                "<td>"+ p.fees  +"</td>" +//taxa de juros
                "<td>"+ parseFloat(p.total_paid).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })  +"</td>" + //total pago da dividia
                "</tr>";

            return line;
        }

        // Quando o botão "editar" for clicado, mostre o modal
        document.querySelectorAll('.editSponsor').forEach(function (button) {
            button.addEventListener("click", function () {
                //pega a o objeto
                sponsor  = JSON.parse(this.getAttribute("data-sponsor"));

                // Faça uma requisição AJAX para buscar  com base no ID
                $.ajax({
                    url: '/sponsors/' + sponsor.id, // Substitua pela URL correta
                    method: 'GET',
                    dataType: 'json',
                    // success: function(data) {
                    success: function(dados) {
                        loans    = dados.sponsor['loans'];
                        clients  = loans['client'];
                        payments = loans['payments'];

                        // Inserir o conteúdo do arquivo no modal
                        $('#modalContainer').html(dados.content);

                        mostrarForm('modalEdit');
                        montarTabela( loans, 'tableEmprestimo' );
                    },
                    error: function() {
                        $('#limit').val("");
                        alert('Falha ao buscar dados.');
                    }
                });
            });
        });

        document.querySelectorAll('#createSponsor').forEach(function (button) {
            button.addEventListener("click", function () {

                // Faça uma requisição AJAX para buscar  com base no ID
                $.ajax({
                    url: '/sponsors/create', // Substitua pela URL correta
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
        }

        function adjustTableHeight() {
            var windowHeight = $(window).height(); // Obtém a altura da janela do navegador
            var formHeight = $('.form').outerHeight();
            var tableHeaderHeight = $('#tableEmprestimo thead').outerHeight();
            var tableFooterHeight = $('#tableEmprestimo tfoot').outerHeight();
            var tableHeight = windowHeight - (formHeight + tableHeaderHeight + tableFooterHeight);

            var elemento = document.getElementById("tabela-com-scroll");

            // Crie a string de estilo com a variável
            var estilo = 'max-height: ' + tableHeight + 'px; overflow-y: scroll;';

            // Alterar o valor da propriedade CSS "background-color" em tempo de execução.
            elemento.setAttribute("style", estilo);
        }
    </script>
@stop
