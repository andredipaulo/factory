@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Users</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <button type="button" data-toggle="modal" id="createUser" class="btn btn-success">Add User</button>
        </div>
    </div>
    <div>
        <div class="table-responsive mt-4">

            @if(Session::has('errors'))
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <script type="text/javascript">

                    </script>
                @endif
            @endif

            @if($users->isEmpty())
                <h6> Não encontrei nenhuma informação pesquisada.</h6>
            @else
                <table id="tblUsers" class="table table-bordered table-hover minhaTable" style="width: 100%;">
                    <thead>
                    <tr>
                        <th class="numero">#</th>
                        <th class="texto">Nome</th>
                        <th class="texto desktop">E-mail</th>
                        <th class="data tablet">Atualizado</th>
                        <th class="acoes">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users  as $user)
                        <tr>
                            <td class="numero">{{ $user->id }}</td>
                            <td class="texto">{{ $user->name }} </td>
                            <td class="desktop"> {{ $user->email }}</td>
                            <td class="data tablet"> {{ date_format($user->updated_at, 'd/m/Y') }}</td>
                            <td class="acoes">
                                <a class="btn btn-primary btn-sm editUser" data-user="{{ json_encode($user) }}">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                    Editar
                                </a>
                                <meta name="csrf-token" content="{{ csrf_token() }}"/>
                                <a onclick="deleteRegistro(  ' {{ route('users.destroy',  $user) }} ', {{ $user->id }} ) "
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
        var user      = [];

        //Instanciando o plugin DataTable
        $(document).ready(function (){
            $("#tblUsers").DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json',
                },
                autoWidth: true,
            });
        });

        // Quando o botão "editar" for clicado, mostre o modal
        /* modelo funcional de requisição via ajax */
        document.querySelectorAll('.editUser').forEach(function (button) {
            button.addEventListener("click", function () {
                //pega a o objeto
                user   = JSON.parse(this.getAttribute("data-user"));

                // Faça uma requisição AJAX para buscar  com base no ID
                $.ajax({
                    url: '/users/' + user.id, // Substitua pela URL correta
                    method: 'GET',
                    dataType: 'json',
                    // success: function(data) {
                    success: function(dados) {
                        // Inserir o conteúdo do arquivo no modal
                        $('#modalContainer').html(dados.content);
                        mostrarForm('modalEdit');
                    },
                    error: function(error) {
                        // Lidar com erros, se houver
                        alert("Erro ao enviar os dados: " + error.responseJSON.message);
                    }
                });
            });
        });

        document.querySelectorAll('#createUser').forEach(function (button) {
            button.addEventListener("click", function () {

                // Faça uma requisição AJAX para buscar  com base no ID
                $.ajax({
                    url: '/users/create', // Substitua pela URL correta
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

        }

        function exibirImagem() {
            const imagem = document.getElementById('imagemPreview');
            const file = event.target.files[0];

            if (file) {
                const leitor = new FileReader();

                leitor.onload = function(e) {
                    imagem.src = e.target.result;
                    imagem.style.display = 'block';
                }

                leitor.readAsDataURL(file);
            }
        }
    </script>
@stop

