

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Gerador</h1>
        </div>
{{--        <form method="post" action="/gerar-pdf">--}}
{{--            @csrf--}}
            {{-- Parte Superior --}}
            <div class="form">

                <div class="row">
                    <div class="col-6 col-6 col-md-3 col-lg-3 col-xl-3">
                        <div class="mb-3">
                            <label for="sponsor_name" class="form-label">Sponsor</label>
                            <?php  $sponsors = \App\Models\Sponsor::all() ?>
                            <select id="sponsors" name="sponsor_name" class="form-control select2-single">
                                <option value="">Select a sponsor</option>
                                @foreach($sponsors as $sponsor)
                                    <option value="{{$sponsor->id}}">{{ $sponsor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-6 col-6 col-md-3 col-lg-3 col-xl-3">
                        <div class="mb-3">
                            <label for="first_name" class="form-label">Cliente</label>
                            <?php  $clients = \App\Models\Client::where('status','=', 'Ativo')->get() ?>
                            <select id="clients" name="first_name" class="form-control select2-single">
                                <option value="">Select a client</option>
                                @foreach($clients as $client)
                                    <option value="{{$client->id}}">{{ $client->first_name }} {{ $client->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-3 col-3 col-md-2 col-lg-2 col-xl-2">
                        <div class="mb-3">
                            <label for="limit" class="form-label">Limite</label>
                            <input type="text" class="form-control @error('limit')  is-invalid @enderror" id="limit" name="limit" value="{{ old('limit') }}" placeholder="Limite" readonly>
                            @if($errors->has('limit'))
                                <div class="invalid-feedback">{{ $errors->first('limit') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-3 col-3 col-md-2 col-lg-2 col-xl-2">
                        <div class="mb-3">
                            <label for="devedor" class="form-label">Devedor</label>
                            <input type="text" class="form-control @error('devedor')  is-invalid @enderror" id="devedor" name="devedor" value="{{ old('devedor') }}" placeholder="Devedor" readonly>
                            @if($errors->has('devedor'))
                                <div class="invalid-feedback">{{ $errors->first('devedor') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-6 col-6 col-md-2 col-lg-2 col-xl-2">
                        <div class="mb-3">
                            <label for="valorEmprestimo" class="form-label">Empréstimo</label>
                            <input type="text" class="form-control" id="valorEmprestimo" name="valorEmprestimo" value="{{ old('valorEmprestimo') }}" placeholder="Empréstimo">
                        </div>
                    </div>

                    <div class="col-3 col-3 col-md-2 col-lg-1 col-xl-1">
                        <div class="mb-3">
                            <label for="juros" class="form-label">Juros</label>
                            <input type="text" class="form-control @error('juros')  is-invalid @enderror" id="juros" name="juros" value="{{ old('juros') }}" placeholder="Juros">
                        </div>
                    </div>

                    <div class="col-3 col-3 col-md-2 col-lg-1 col-xl-1">
                        <div class="mb-3">
                            <label for="parcelas" class="form-label">Parcelas</label>
                            <input type="text" class="form-control @error('parcelas')  is-invalid @enderror" id="parcelas" name="parcelas" value="{{ old('parcelas') }}" placeholder="Parcelas">
                        </div>
                    </div>

                    <div class="col-6 col-6 col-md-3 col-lg-2 col-xl-2">
                        <div class="mb-3">
                            <label for="date" class="form-label">Data</label>
                            <input type="date" class="form-control @error('date')  is-invalid @enderror" id="date" name="date" value="{{ old('date') }}" placeholder="Data">
                        </div>
                    </div>

                    <div class="col-12 col-12 col-md-5 col-lg-3 col-xl-3">
                        <label for="date" class="form-label">Período</label><br/>
                        <div class="row" style="border: 1px solid gray; border-radius: 5px; margin-right:2px">
                            <div class="col-6 col-6 col-md-6 col-lg-6 col-xl-6">
                                <input type="radio" name="periodo" value="1"/> Diário<br/>
                                <input type="radio" name="periodo" value="7"/> Semanal<br/>
                            </div>
                            <div class="col-6 col-6 col-md-6 col-lg-6 col-xl-6">
                                <input type="radio" name="periodo" value="15"/> Quinzenal<br />
                                <input type="radio" name="periodo" checked value="30"/> Mensal
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-12 col-md-6 col-lg-4 col-xl-4">
                        <div class="row" style="display: flex; flex-direction: row; justify-content: space-between">
                            <div class="col-4 col-4 col-md-4 col-lg-4 col-xl-4">
{{--                            <div class="col-3 col-2 col-md-2 col-lg-2 col-xl-2">--}}
                                <label class="form-label"></label>
                                <div class="row">
                                    <button  onclick="calcular()" class="btn btn-warning"> <i class="fa fa-calculator" aria-hidden="true"></i> Simular</button>
                                </div>
                            </div>

{{--                            <div class="col-3 col-2 col-md-2 col-lg-2 col-xl-2">--}}
                            <div class="col-4 col-4 col-md-4 col-lg-4 col-xl-4">
                                <label class="form-label"></label>
                                <div class="row">
                                    <button  onclick="gerarPdf()" class="btn btn-primary"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</button>
                                    {{-- <button type="submit" name="gerarPDF">Enviar para PDF</button>--}}
                                </div>
                            </div>

{{--                            <div class="col-3 col-2 col-md-2 col-lg-2 col-xl-2">--}}
                            <div class="col-4 col-4 col-md-4 col-lg-4 col-xl-4">
                                <label class="form-label"></label>
                                <div class="row">
                                    <button  onclick="gerarEmprestimo()" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> Gravar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Table --}}
            <div class="row">
                <div class="table-responsive mt-4" id="tabela-com-scroll">
                    <table id="tableSimulator" class="table table-striped">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>Name</th>
                            <th>Empréstimo</th>
                            <th>Juros(%)</th>
                            <th>Juros($)</th>
                            <th>Parcela</th>
                            <th>Data</th>
                            <th>Valor</th>
                            <th>Total</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                        <tr>
                            <td>Total </td>
                            <td id="somaColuna1"></td>
                            <td id="somaColuna2"></td>
                            <td id="somaColuna3"></td>
                            <td id="somaColuna4"></td>
                            <td id="somaColuna5"></td>
                            <td id="somaColuna6"></td>
                            <td id="somaColuna7"></td>
                            <td id="somaColuna8"></td>
                            <td id="somaColuna9"></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

{{--        </form>--}}
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Adicione os links para as bibliotecas do AdminLTE, jQuery, Select2 e Select2 Bootstrap Theme -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/1.5.2/select2-bootstrap.min.css">
@endsection

@section('js')

    <script src="/js/factoryAction.js"></script>

    <!-- Inclua o jQuery DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Inclua o jQuery Mask Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js" integrity="sha512-6HmJ9Y5PZWQVCd4KUwIaSgtDskfsykB+Fvm8Nq98GVCMHstaVoX9jqDdwSyGCbmJy5eLs/DXgDE3SXRS+2B2yA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

    <script>
        // Obtém a data atual no formato "AAAA-MM-DD"
        // var dataAtual = new Date().toISOString().split('T')[0];
        var sponsor_id = 0;
        var client_id = 0;
        var csrfToken = $('meta[name="csrf-token"]').attr('content'); // Obtenha o token CSRF

        // Define a data atual como valor inicial do campo de data
        document.getElementById("date").value = dataAtual;

        // Selecione a caixa de seleção e inicialize o Select2
        $('#sponsors').select2({
            placeholder: 'Selecione um sponsor',
            width: '100%',
        });

        $('#sponsors').on('select2:select', function (e) {
            sponsor_id = e.params.data.id;
        });

        $('#clients').select2({
            placeholder: 'Selecione o cliente',
            width: '100%',
        });

        // Adicione um evento de seleção ao campo Select2
        $('#clients').on('select2:select', function (e) {

            client_id = e.params.data.id;

            // Faça uma requisição AJAX para buscar o usuário com base no ID
            $.ajax({
                url: '/getClientData/' + client_id, // Substitua pela URL correta
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Preencha o campo de texto com o dados retornado
                    $('#limit').val(data.limit);
                },
                error: function() {
                    $('#limit').val("");
                    alert('Falha ao buscar dados.');
                }
            });
        });

        // $('#valor').mask('0.000.000.000.000.000,00', {reverse: true});
        $('#valorEmprestimo').mask('#.##0,00', { reverse:true });
        $('#juros').mask('#.##0,00', { reverse:true });

        function calcular() {

            var nome             = $("#clients option:selected").text();
            var valorEmprestimo  = document.getElementById('valorEmprestimo').value;
            var dataInicial      = document.getElementById('date').value;
            var parcelas         = document.getElementById('parcelas').value;
            var juros            = document.getElementById('juros').value;

            var resultado   = [];

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

            //chama a funcao dentro de factoryAction.js
            resultado = calcularParcelas(nome, valorEmprestimo, juros, dataInicial, parcelas, periodo )

            montarTabela(resultado);
        }

        function montarTabela(data){

            $("#tableSimulator>tbody>tr").remove();

            for( i=0; i<data.length; i++){
                line = showLine(data[i]);
                $('#tableSimulator>tbody').append(line);
            }

            calcularSomaColunas();

            //exibirTabela();
        };

        function showLine(p){
            var line =
                "<tr>"+
                "<td>"+ p.id    +"</td>" +
                "<td>"+ p.name  +"</td>" +
                "<td>"+ p.valorEmprestimo  +"</td>" +
                "<td>"+ p.juros  +"</td>" +
                "<td>"+ p.jurosValor  +"</td>" +
                "<td>"+ p.parcela  +"</td>" +
                "<td>"+ p.data  +"</td>" +
                "<td>"+ p.valor  +"</td>" +
                "<td>"+ p.total  +"</td>" +
                "<td>"+
                //'<button class="btn btn-sm btn-primary" onclick="edit(' + p.id +')"> <i class="fa fa-pencil" aria-hidden="true"></i> Editar </button> ' +
                '<button class="btn btn-sm btn-danger" onclick="remove(' + p.id +')"><i class="fa fa-trash" aria-hidden="true"></i> Apagar </button> ' +
                "</td>"+
                "</tr>";

            return line;
        }

        function remove(id) {
            if (confirm('Realmente quer excluir?\nPressione Ok ou Cancelar.')) {
                $.ajax({
                    //type: "DELETE",
                    ///url: "/api/categories/" + id,
                    //context: this,
                    success: function () {
                        lines = $("#tableSimulator>tbody>tr");

                        e = lines.filter( function (i, element){
                            return element.cells[0].textContent == id;
                        })
                        if(e){
                            e.remove();
                        }
                        document.getElementById('parcelas').value =  (lines.length - 1);
                        calcularParcelasDecrescentes();
                    },
                    error: function (error) {

                    }
                });
            }
        };

        // Função para calcular a soma no final de cada coluna
        function calcularSomaColunas() {
            var tabela = document.querySelectorAll("table")[0];
            var totalLinhas = tabela.rows.length;
            var totalColunas = tabela.rows[0].cells.length;

            const colunas = [ 4, 7, 8];

            for (var coluna = 1; coluna < (totalColunas - 1); coluna++) {
                if (colunas.includes(coluna)) {
                    var soma = 0;
                    for (var linha = 1; linha < totalLinhas - 1; linha++) {
                        text = tabela.rows[linha].cells[coluna].innerText.replace("R$", "").replace(/\./g, "").replace(",", ".");
                        //soma += parseFloat(tabela.rows[linha].cells[coluna].innerText);
                        soma += parseFloat(text);
                    }
                    tabela.rows[totalLinhas - 1].cells[coluna].innerText = soma.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                }
            }
        }

        function gerarEmprestimo(){
            if(confirm('Deseja gerar um novo empréstimo?')) {

                const sponsor = sponsor_id;
                const client = client_id;
                const amount = document.getElementById('valorEmprestimo').value.replace("R$", "").replace(/\./g, "").replace(",", ".");
                const fees = document.getElementById('juros').value.replace(/\./g, "").replace(",", ".");
                const loan_date = document.getElementById('date').value;

                emprestimo(sponsor, client, amount, fees, loan_date);

                //location.reload();
            }
        }

        function gravarParcelas(){
            // Obter a tabela e suas linhas
            const table = document.getElementById('tableSimulator');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            // Criar um array para armazenar os dados
            const data = [];

            // Iterar pelas linhas da tabela e obter os valores das colunas
            for (let i = 0; i < rows.length; i++) {

                const row = rows[i];

                const sponsor           = sponsor_id;
                const client            = client_id;
                const valorEmprestimo   = row.cells[2].textContent.replace("R$", "").replace(/\./g, "").replace(",", ".");
                const taxaJuros         = row.cells[3].textContent;
                const valorJuros        = row.cells[4].textContent.replace("R$", "").replace(/\./g, "").replace(",", ".");
                //const parcela           = row.cells[5].textContent.replace("R$", "").replace(/\./g, "").replace(",", ".");
                var   dataEmprestimo    = row.cells[6].textContent;
                //const valorDivido       = row.cells[7].textContent.replace("R$", "").replace(/\./g, "").replace(",", ".");
                const valorParcela      = row.cells[8].textContent.replace("R$", "").replace(/\./g, "").replace(",", ".");

                //dataEmprestimo = dataEmprestimo.toLocaleString('en', { timeZone: 'UTC' });

                // Adicionar os dados ao array
                data.push({
                    sponsor,
                    client,
                    valorEmprestimo,
                    taxaJuros,
                    valorJuros,
                    //parcela,
                    dataEmprestimo,
                    //valorDivido,
                    valorParcela,
                });

            };

            // Fazer a solicitação AJAX
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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

        function gerarPdf() {

            // Obter a tabela e suas linhas
            const table = document.getElementById('tableSimulator');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            // Criar um array para armazenar os dados
            const dados = [];

            // Iterar pelas linhas da tabela e obter os valores das colunas
            for (let i = 0; i < rows.length; i++) {

                const row = rows[i];

                const id = row.cells[0].textContent;
                const sponsor = sponsor_id;
                const client = row.cells[1].textContent;
                const valorEmprestimo = row.cells[2].textContent.replace("R$", "").replace(/\./g, "").replace(",", ".");
                const taxaJuros = row.cells[3].textContent;
                const valorJuros = row.cells[4].textContent.replace("R$", "").replace(/\./g, "").replace(",", ".");
                const parcela = row.cells[5].textContent.replace("R$", "").replace(/\./g, "").replace(",", ".");
                const dataEmprestimo = row.cells[6].textContent;
                const valorDivido = row.cells[7].textContent.replace("R$", "").replace(/\./g, "").replace(",", ".");
                const valorParcela = row.cells[8].textContent.replace("R$", "").replace(/\./g, "").replace(",", ".");

                //dataEmprestimo = dataEmprestimo.toLocaleString('en', { timeZone: 'UTC' });

                // Adicionar os dados ao array
                dados.push({
                    id,
                    sponsor,
                    client,
                    valorEmprestimo,
                    taxaJuros,
                    valorJuros,
                    parcela,
                    dataEmprestimo,
                    valorDivido,
                    valorParcela,
                });
            }

            // Fazer a solicitação AJAX
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "/gerar-pdf/" + {tabela: dados}, // A URL da rota
                data: {tabela: dados},
                success: function(response) {
                    // Obtém o PDF em formato Base64 da resposta
                    var pdfBase64 = response.pdf;
                    // Crie um objeto de iframe para exibir o PDF
                    // var iframe = document.createElement('iframe');
                    // iframe.src = 'data:application/pdf;base64,' + pdfBase64;
                    // iframe.width = '100%';
                    // iframe.height = '500px';

                    // Adicione o iframe à página
                    //document.body.appendChild(iframe);

                    // Crie um novo arquivo PDF em formato Blob
                    var pdfBlob = b64toBlob(pdfBase64, 'application/pdf');

                    // Crie uma URL temporária para o Blob
                    var pdfUrl = URL.createObjectURL(pdfBlob);

                    // Redirecione o navegador para a nova página com o PDF
                    window.location.href = pdfUrl;
                },
                error: function(error) {
                    // Lidar com erros, se houver
                    alert("Erro ao enviar os dados: " + error.responseJSON.message);
                }
            });
        };

        function b64toBlob(b64Data, contentType, sliceSize) {
            contentType = contentType || '';
            sliceSize = sliceSize || 512;

            var byteCharacters = atob(b64Data);
            var byteArrays = [];

            for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
                var slice = byteCharacters.slice(offset, offset + sliceSize);

                var byteNumbers = new Array(slice.length);
                for (var i = 0; i < slice.length; i++) {
                    byteNumbers[i] = slice.charCodeAt(i);
                }

                var byteArray = new Uint8Array(byteNumbers);
                byteArrays.push(byteArray);
            }

            return new Blob(byteArrays, { type: contentType });
        }

        // Ajustar a altura da tabela com base no tamanho da tela
        $(document).ready(function () {
            adjustTableHeight();
        });

        $(window).on('resize', function () {
            adjustTableHeight();
        });

        function adjustTableHeight() {
            var windowHeight = $(window).height(); // Obtém a altura da janela do navegador
            var formHeight = $('.form').outerHeight();
            var tableHeaderHeight = $('#tableSimulator thead').outerHeight();
            var tableFooterHeight = $('#tableSimulator tfoot').outerHeight();
            var tableHeight = windowHeight - (formHeight + tableHeaderHeight + tableFooterHeight);

            var elemento = document.getElementById("tabela-com-scroll");

            // Crie a string de estilo com a variável
            var estilo = 'max-height: ' + tableHeight + 'px; overflow-y: scroll;';

            // Alterar o valor da propriedade CSS "background-color" em tempo de execução.
            elemento.setAttribute("style", estilo);
        }
    </script>
@endsection
