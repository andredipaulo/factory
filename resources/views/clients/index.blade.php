@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Clientes</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <button type="button" data-toggle="modal" id="createClient" class="btn btn-success">Incluir Cliente</button>
        </div>
    </div>
    <div>
        <div class="table-responsive mt-4">
            @if($clients->isEmpty())
                <h6> Não encontrou nenhuma informação pesquisada. </h6>
            @else
                <table id="tblClients" class="table table-bordered table-hover minhaTable" style="width: 100%;">
                    <thead>
                    <tr>
                        <th class="numero">#</th>
                        <th class="texto">Nome</th>
                        <th class="texto desktop">E-mail</th>
                        <th class="numero tablet">Telefone</th>
                        <th class="status tablet">Status</th>
                        <th class="data tablet">Atualizado</th>
                        <th class="acoes">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($clients  as $client)
                        <tr>
                            <td class="numero">{{ $client->id }}</td>
                            <td class="texto">{{ $client->first_name }} {{$client->last_name}} @if(count($client->loans) >0)<span class="float-right badge badge-danger">{{ count($client->loans) }}</span>@endif</td>
                            <td class="desktop"> {{ $client->email }}</td>
                            <td class="numero tablet">{{ $client->phone }}</td>
                            <td class="status tablet"> {{ $client->status }}</td>
                            <td class="data tablet"> {{ date_format($client->updated_at, 'd/m/Y') }}</td>
                            <td class="acoes">
                                <a class="btn btn-primary btn-sm editClient" data-cliente="{{ json_encode($client) }}">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                    Editar
                                </a>
                                <meta name="csrf-token" content="{{ csrf_token() }}"/>
                                <a onclick="deleteRegistro(  ' {{ route('clients.destroy',  $client) }} ', {{ $client->id }} ) "
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
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Adicione os links para as bibliotecas do AdminLTE, jQuery, Select2 e Select2 Bootstrap Theme -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/1.5.2/select2-bootstrap.min.css">

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
    <!-- fim -->

    <script>
            var client      = [];
            var sponsors    = [];
            var loans       = [];
            var payments    = [];

            var sponsor_id = 0;
            var client_id  = 0;
            var amount     = 0;
            var fees       = 0;
            var loan_date  = 0;

            //Instanciando o plugin DataTable
            $(document).ready(function (){
                $("#tblClients").DataTable({
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
                document.getElementById("modalEditForm").elements['date'].value = dataAtual;
                document.getElementById("modalEditForm").elements['devedor'].value = sumAmount.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }); // 'pt-BR' representa o formato brasileiro;
                document.getElementById("modalEditForm").elements['limitEmprestimo'].value = parseFloat( client['limit'] ).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
            };

            function showLine(p){
                const loan_date = formatarData(p.loan_date, 'DD-MM-YYYY');

                var line =
                    "<tr>"+
                    "<td><a href='#' onclick='navigateToLoan(" + p.id + ")'>"+ p.id + "</a></td>" +
                    "<td><a href='#' onclick='navigateToLoan(" + p.id + ")'>"+ p.sponsor.name +"</a></td>" +//de quem pegou
                    "<td><a href='#' onclick='navigateToLoan(" + p.id + ")'>"+ loan_date +"</a></td>" +//data do emprestimo
                    "<td><a href='#' onclick='navigateToLoan(" + p.id + ")'>"+ parseFloat(p.amount).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })  +"</a></td>" + //valor do emprestimo
                    "<td><a href='#' onclick='navigateToLoan(" + p.id + ")'>"+ p.fees  +"</td>" +//taxa de juros
                    "<td><a href='#' onclick='navigateToLoan(" + p.id + ")'>"+ parseFloat(p.total_paid).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })  +"</a></td>" + //total pago da dividia
                    "</tr>";

                return line;
            }

            // Quando o botão "editar" for clicado, mostre o modal
            /* modelo funcional de requisição via ajax */
            document.querySelectorAll('.editClient').forEach(function (button) {
                button.addEventListener("click", function () {
                    //pega a o objeto
                    client   = JSON.parse(this.getAttribute("data-cliente"));

                    // Faça uma requisição AJAX para buscar  com base no ID
                    $.ajax({
                        url: '/clients/' + client.id, // Substitua pela URL correta
                        method: 'GET',
                        dataType: 'json',
                        // success: function(data) {
                        success: function(dados) {

                            loans    = dados.client['loans'];
                            sponsors = loans['sponsor'];
                            payments = loans['payments'];

                            // Inserir o conteúdo do arquivo no modal
                            $('#modalContainer').html(dados.content);

                            montarTabela( loans, 'tableEmprestimo' );

                            mostrarForm('modalEdit');

                        },
                        error: function(error) {
                            $('#limit').val("");
                            // Lidar com erros, se houver
                            alert("Erro ao enviar os dados: " + error.responseJSON.message);
                        }
                    });
                });
            });

            document.querySelectorAll('#createClient').forEach(function (button) {
                button.addEventListener("click", function () {

                    // Faça uma requisição AJAX para buscar  com base no ID
                    $.ajax({
                        url: '/clients/create', // Substitua pela URL correta
                        method: 'GET',
                        dataType: 'json',
                        // success: function(data) {
                        success: function(dados) {

                            // Inserir o conteúdo do arquivo no modal
                            $('#modalContainer').html(dados.content);

                            mostrarForm('modalCreate');
                            document.getElementById("modalCreateForm").elements['date'].value = dataAtual;
                        },
                        error: function() {
                            $('#limit').val("");
                            alert('Falha ao buscar dados.');
                        }
                    });
                });
            });

            function mostrarForm( modal ){
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
                    placeholder: 'Selecione um sponsor',
                    width: '100%',
                });

                $('#sponsors').on('select2:select', function (e) {
                    sponsor_id = e.params.data.id;
                });

                // $('#valor').mask('0.000.000.000.000.000,00', {reverse: true});
                $('#limit').mask('#.##0,00', { reverse:true });
                $('#juros').mask('#.##0,00', { reverse:true });
                $('#valor').mask('#.##0,00', { reverse:true });
            }

            function calcularParcelasDecrescentes() {

                var sponsorId       = $("#sponsors option:selected").text();
                var valorEmprestimo = document.getElementById('valor').value;
                var dataInicial     = document.getElementById('date').value;
                var valorParcelas   = document.getElementById('parcelas').value;
                var valorJuros      = document.getElementById('juros').value;

                // Referencie os inputs de rádio pelo nome
                var periodos = document.getElementsByName('periodo');
                // Inicialize uma variável para armazenar o valor selecionado
                var periodo;
                // Percorra todos os inputs de rádio
                for (var i = 0; i < periodos.length; i++) {
                    if (periodos[i].checked) {
                        // Se o input de rádio estiver marcado, atribua o valor selecionado à variável
                        periodo = periodos[i].value;
                        break; // Saia do loop, pois já encontramos o valor selecionado
                    }
                }

                //formatado a moeda
                valor = valor.replace(/\./g, "").replace(",", ".");

                if (valor < 1) {
                    alert( "O valor deve ser preenchido.");
                    die;
                }

                if (parcelas < 1) {
                    alert( "O número de parcelas deve ser pelo menos 1.");
                    die;
                }

                var valorParcela = valor / parcelas;
                var resultado = [];
                var valorAbate = 0;

                for (var i = 0; i < parcelas; i++) {
                    var totalComJuros = 0;
                    //var juroParcela = valorParcela * (juros / 100);
                    valor = valor - valorAbate;

                    //var juroDoValor = valor * (juros / 100);
                    var juroDoValor = 0
                    juroDoValor = valor * ( ( (juros / 100) / 30) * periodo);


                    totalComJuros += valorParcela + juroDoValor;

                    var data = somarDias(datainicial, (periodo * (i + 1)) );

                    resultado.push({
                        id: i + 1,
                        name: nome ,
                        emprestimo: valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }),
                        parcela: i + 1,
                        data: data,
                        juros: juros,
                        jurosValor: juroDoValor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }),
                        valor: valorParcela.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }),
                        total: totalComJuros.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }),
                    });
                    valorAbate = valorParcela;

                }

                montarTabela(resultado);
            }

            function gravarParcelas( sponsor, client, valorEmprestimo, taxaJuros, valorJuros, valorParcela, dataEmprestimo, valorTotal){
                // Criar um array para armazenar os dados
                const data = [];

                // Adicionar os dados ao array
                data.push({
                    sponsor,
                    client,
                    valorEmprestimo,
                    taxaJuros,
                    valorJuros,
                    valorParcela,
                    dataEmprestimo,
                    valorTotal,
                });

                // Fazer a solicitação AJAX
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "/loan/" + {loans: data}, // A URL da rota
                    data: {loans: data},
                    success: function(response) {
                        // Tratar a resposta do servidor, se necessário
                        alert("Dados salvos com sucesso: " + response.message);
                    },
                    error: function(error) {
                        // Lidar com erros, se houver
                        alert("Erro ao salvar os dados: " + error.responseJSON.message);
                    }
                });
            }

            function gerarEmprestimo(){

                amount      = document.getElementById("modalEditForm").elements['valor'].value.replace("R$", "").replace(/\./g, "").replace(",", ".");
                fees        = document.getElementById("modalEditForm").elements['juros'].value.replace("R$", "").replace(/\./g, "").replace(",", ".");
                loan_date   = document.getElementById("modalEditForm").elements['date'].value;

                if(
                    (sponsor_id === null || sponsor_id === 0) ||
                    (client.id === null || client.id === 0) ||
                    (amount === null || amount === "") ||
                    (fees === null || fees === "") ||
                    (loan_date === null || loan_date === "")
                )
                {
                    alert('Preencha todos os campos obrigatórios');
                    return;
                }

                if(confirm('Deseja gerar um novo empréstimo?')) {
                    emprestimo(sponsor_id, client.id, amount, fees, loan_date);
                    window.location.reload();
                }
            }

            function navigateToLoan(loanId) {
                // Faça uma requisição AJAX para buscar  com base no ID
                $.ajax({
                    url: '/loans/' + loanId, // Substitua pela URL correta
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
            }
        </script>
@stop
