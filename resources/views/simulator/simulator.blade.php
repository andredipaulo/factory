        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Simulador</h1>
        </div>
            {{-- Parte Superior --}}
            <div class="form">

                <div class="row">
                    <div class="col-7 col-7 col-md-5 col-lg-4 col-xl-4">
                        <div class="mb-3">
                            <label for="first_name" class="form-label">Cliente</label>
                            <div class="input-group">
                                <div class="input-group-prepend  ">
                                    <span class="input-group-text"><i class="far fa-address-book"></i></span>
                                </div>
                                <input type="text" id="first_name" name="first_name" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="col-5 col-5 col-md-3 col-lg-2 col-xl-2">
                        <div class="mb-3">
                            <label for="valorEmprestimo" class="form-label">Empréstimo</label>
                            <div class="input-group">
                                <div class="input-group-prepend  ">
                                    <span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" id="valorEmprestimo" name="valorEmprestimo" value="{{ old('valorEmprestimo') }}" placeholder="Empréstimo" pattern="[0-9]+">
                            </div>
                        </div>
                    </div>

                    <div class="col-4 col-4 col-md-2 col-lg-2 col-xl-2">
                        <div class="mb-3">
                            <label for="juros" class="form-label">Juros</label>
                            <div class="input-group">
                                <div class="input-group-prepend  ">
                                    <span class="input-group-text"><i class="fas fa-piggy-bank"></i></span>
                                </div>
                                <input type="text" class="form-control" id="juros" name="juros" value="{{ old('juros') }}" placeholder="Juros"  pattern="[0-9]+">
                            </div>
                        </div>
                    </div>

                    <div class="col-3 col-3 col-md-2 col-lg-2 col-xl-2">
                        <div class="mb-3">
                            <label for="parcelas" class="form-label">Parcelas</label>
                            <div class="input-group">
                                <div class="input-group-prepend  ">
                                    <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                                </div>
                                <input type="text" class="form-control" id="parcelas" name="parcelas" value="{{ old('parcelas') }}" placeholder="Parcelas"  pattern="[0-9]+">
                            </div>
                        </div>
                    </div>

                    <div class="col-5 col-5 col-md-3 col-lg-2 col-xl-2">
                        <div class="mb-3">
                            <label for="date" class="form-label">Data do Empréstimo</label>
                            <div class="input-group">
                                <div class="input-group-prepend  ">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                </div>
                                <input type="date" class="form-control @error('date')  is-invalid @enderror" id="date" name="date" value="{{ old('date') }}" placeholder="Data">
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-12 col-md-6 col-lg-6 col-xl-6">
                        <label for="date" class="form-label">Período</label><br/>
                        <div class="col" style="border: 1px solid gray; border-radius: 5px; display: flex; flex-direction: row; justify-content: space-between">

                                <input type="radio" name="periodo" value="1"/> Diário<br/>
                                <input type="radio" name="periodo" value="7"/> Semanal<br/>

                                <input type="radio" name="periodo" value="15"/> Quinzenal<br />
                                <input type="radio" name="periodo" checked value="30"/> Mensal
                        </div>
                    </div>


                    <div class="col-12 col-12 col-md-6 col-lg-4 col-xl-4">
                        <div class="row" style="display: flex; flex-direction: row; justify-content: space-between">
                            <div class="col-6 col-6 col-md-6 col-lg-6 col-xl-6">
                                <label class="form-label"></label>
                                <div class="row">
                                    <button id="btnCalcular"  onclick="calcular()" class="btn btn-warning"> <i class="fa fa-calculator" aria-hidden="true"></i> Simular</button>
                                </div>
                            </div>

                            <div class="col-6 col-6 col-md-6 col-lg-6 col-xl-6">
                                <label class="form-label"></label>
                                <div class="row">
                                    <button id="btnImprimir" onclick="imprimir()" class="btn btn-primary"disabled><i class="fa fa-print" aria-hidden="true"></i> Imprimir</button>
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
        var dataAtual = new Date().toISOString().split('T')[0];
        var sponsor_id = 0;
        var client_id = 0;
        var csrfToken = $('meta[name="csrf-token"]').attr('content'); // Obtenha o token CSRF

        // Define a data atual como valor inicial do campo de data
        document.getElementById("date").value = dataAtual;

        // $('#valor').mask('0.000.000.000.000.000,00', {reverse: true});
        $('#valorEmprestimo').mask('#.##0,00', { reverse:true });
        $('#juros').mask('#.##0,00', { reverse:true });
        $('#parcelas').mask('#0', { reverse:true });

        function calcular() {

            var nome             = document.getElementById('first_name').value;
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
            document.getElementById('btnImprimir').removeAttribute('disabled');
        }

        function montarTabela(data){

            $("#tableSimulator>tbody>tr").remove();

            for( i=0; i<data.length; i++){
                line = showLine(data[i]);
                $('#tableSimulator>tbody').append(line);
            }

            calcularSomaColunas();

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
                        soma += parseFloat(text);
                    }
                    tabela.rows[totalLinhas - 1].cells[coluna].innerText = soma.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                }
            }
        }

        function imprimir() {

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
            };

            //funçao para gerar o pdf
            gerarPdf( dados, 'simulator' );

        };

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
