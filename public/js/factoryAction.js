// Obtém a data atual no formato "AAAA-MM-DD"
var dataAtual = new Date().toISOString().split('T')[0];

// $('#valor').mask('0.000.000.000.000.000,00', {reverse: true});

/**
 * Realiza a exclusão de um registro com base em uma rota URL e um ID.
 *
 * @param {string} rotaUrl - A URL da rota onde a exclusão será realizada.
 * @param {number} id - O ID do registro a ser excluído.
 * @returns {Promise} - Uma promessa que representa a conclusão da operação de exclusão.
 */
function deleteRegistro(rotaUrl, id){
    if(confirm('Deseja excluir o registro?')){
        $.ajax({
            url: rotaUrl,
            method: 'DELETE',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                id: id,
            },
            // beforeSend: function () {
            //     $.blockUI({
            //         message: 'Aguarde executando a ação...',
            //         timeout: 1000,
            //     });
            // },
        }).done(function (data) {
            // $.unblockUI();

            if(data.success == true){
                window.location.reload(true);
            }else{
                alert('Não foi possível excluir o registro.'+"\n"+ data.info);
            }
        }).fail( function(data) {
            //$.unblockUI();
            alert('Não foi possível buscar os dados.');
        });
    }
}

/**
 * Realiza uma pesquisa de CEP e retorna os dados correspondentes.
 *
 * @param {string} valor - O CEP a ser pesquisado.
 * @param {string} formId - O ID do formulário.
 * @returns {object} - Um objeto contendo os dados correspondentes ao CEP.
 */
function pesquisaCep(valor, formId) {

    var cep = valor.replace(/\D/g, '');

    var form = document.getElementById(formId);

    if (form) {
        //var streetName = form.querySelector('input[name="street_name"]');
        var address = form.querySelector('input[name="address"]');
        var complement = form.querySelector('input[name="complement"]');
        var neighborhood = form.querySelector('input[name="neighborhood"]');
        var city = form.querySelector('input[name="city"]');
        var state = form.querySelector('input[name="state"]');
    }

    if (cep != "") {
        var validacep = /^[0-9]{8}$/;
        if (validacep.test(cep)){

            //streetName.value = "...";
            address.value = "...";
            complement.value = "...";
            neighborhood.value = "...";
            city.value = "...";
            state.value = "...";

            $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados){
                if (!("erro" in dados)){
                    //streetName.value = primeiraPalavraDaString(dados.logradouro);
                    address.value = (dados.logradouro);
                    complement.value = (dados.complemento);
                    neighborhood.value = (dados.bairro);
                    city.value = (dados.localidade);
                    state.value = (dados.uf.toUpperCase());

                }else{
                    alert("O " + $('#postcode').val() + " não foi encontrado, digite manualmente ou tente novamente");
                    $('#postcode').val(cep);
                }
            });
        }
    }
};

/**
 * Calcula as parcelas de um empréstimo.
 *
 * @param {string} nome - O nome do mutuário.
 * @param {number} valorEmprestimo - O valor do empréstimo.
 * @param {number} juros - A taxa de juros (em porcentagem) a ser aplicada ao empréstimo.
 * @param {Date} dataInicial - A data de início do empréstimo.
 * @param {number} parcelas - O número de parcelas a serem calculadas.
 * @param {string} periodo - O período de pagamento das parcelas (por exemplo, "mensal" ou "anual").
 * @returns {Array} - Um array de objetos representando as parcelas calculadas.
 */
function calcularParcelas(nome, valorEmprestimo, juros, dataInicial, parcelas, periodo ) {

    //formatado a moeda
    valorEmprestimo = valorEmprestimo.replace(/\./g, "").replace(",", ".");
    juros = juros.replace(/\./g, "").replace(",", ".");

    if (valorEmprestimo < 1) {
        alert( "O valor deve ser preenchido.");
        die;
    }

    if (parcelas < 1) {
        alert( "O número de parcelas deve ser pelo menos 1.");
        die;
    }

    var valorParcela = valorEmprestimo / parcelas;
    var resultado = [];
    var valorAbate = 0;

    for (var i = 0; i < parcelas; i++) {

        var totalComJuros = 0;

        //var juroParcela = valorParcela * (juros / 100);
        valorEmprestimo = valorEmprestimo - valorAbate;

        //var juroDoValor = valor * (juros / 100);
        var juroDoValor = 0
        juroDoValor = valorEmprestimo * ( ( (juros / 100) / 30) * periodo);

        totalComJuros += valorParcela + juroDoValor;

        var data = 0;
        data = somarDias(dataInicial, (periodo * (i + 1)) );

        resultado.push({
            id: i + 1,
            name: nome ,
            valorEmprestimo: valorEmprestimo.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }),
            parcela: i + 1,
            data: data,
            juros: juros,
            jurosValor: juroDoValor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }),
            valor: valorParcela.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }),
            total: totalComJuros.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }),
        });
        valorAbate = valorParcela;

    }

    return resultado;
}

/**
 * Soma um número de dias a uma data.
 *
 * @param {Date} data - A data de início para a adição dos dias.
 * @param {number} dias - O número de dias a serem adicionados à data.
 * @returns {Date} - A nova data resultante após a adição dos dias.
 */
function somarDias(data, dias) {
    const dataOriginal = new Date(data);
    const dataResultante = new Date(dataOriginal);
    dataResultante.setDate(dataResultante.getDate() + dias);

    const dia = String(dataResultante.getDate()).padStart(2, '0');
    const mes = String(dataResultante.getMonth() + 1).padStart(2, '0');
    const ano = dataResultante.getFullYear();

    return `${dia}/${mes}/${ano}`;
}

/**
 * Registra um empréstimo no sistema.
 *
 * @param {string} sponsor - O patrocinador do empréstimo.
 * @param {string} client - O cliente que está solicitando o empréstimo.
 * @param {number} amount - O valor do empréstimo.
 * @param {number} fees - As taxas associadas ao empréstimo.
 * @param {Date} loan_date - A data de concessão do empréstimo.
 * @returns {boolean} - True se o empréstimo foi registrado com sucesso, caso contrário, false.
 */
function emprestimo( sponsor, client, amount, fees, loan_date){

    var dataLoan = [];

    // Adicionar os dados ao array
    dataLoan.push({
        sponsor,
        client,
        amount,
        fees,
        loan_date,
    });

    // Fazer a solicitação AJAX
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        //url: "/loans/" + {loans: dataLoan}, // A URL da rota
        url: "/loans/", // A URL da rota
        data: {loans: dataLoan},
        success: function(response) {
            // Tratar a resposta do servidor, se necessário
            alert (response.message);
        },
        error: function(error) {
            // Lidar com erros, se houver
            alert ("Erro ao salvar os dados: " + error.responseJSON.message);
        }
    });
}

/**
 * Formata uma data de acordo com um formato especificado.
 *
 * @param {Date} data - A data a ser formatada.
 * @param {string} formato - O formato desejado para a data (por exemplo, 'DD/MM/AAAA').
 * @returns {string} - A data formatada como uma string.
 */
function formatarData(data) {
    const partes = data.split('-');
    if (partes.length === 3) {
        // Reorganiza as partes da data para o novo formato.
        return `${partes[2]}/${partes[1]}/${partes[0]}`;
    } else {
        // Se a entrada não estiver no formato esperado, retorna a mesma entrada.
        return data;
    }
}

/**
 * Gera um PDF com base nos dados fornecidos e no template.
 *
 * @param {Object} dados - Os dados a serem incluídos no PDF.
 * @param {string} template - O modelo/template a ser usado para a geração do PDF.
 * @returns {void}
 */
function gerarPdf(dados, template) {

    // Fazer a solicitação AJAX
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: "/gerar-pdf/" + {tabela: dados, template: template}, // A URL da rota
        data: {tabela: dados, template: template},
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

/**
 * Converte uma string de base64 em um objeto Blob.
 *
 * @param {string} b64Data - A string de dados em formato base64.
 * @param {string} contentType - O tipo de conteúdo do Blob (por exemplo, 'image/png').
 * @param {number} sliceSize - O tamanho do bloco ao fatiar os dados (opcional).
 * @returns {Blob} - Um objeto Blob contendo os dados decodificados.
 */
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
function getFormInputNames(formId) {
    const form = document.getElementById(formId); // Obtém o formulário pelo ID
    if (form) {
        const inputElements = form.querySelectorAll('input[name]'); // Seleciona todos os elementos de entrada com um atributo "name"
        const inputNames = Array.from(inputElements).map(input => input.getAttribute('name')); // Obtém os valores do atributo "name" e os armazena em um array
        return inputNames;
    } else {
        return null; // Retorna nulo se o formulário não for encontrado
    }
}
function primeiraPalavraDaString(str) {
    // Divide a string em palavras usando espaço como separador
    const palavras = str.split(' ');

    // Retorna a primeira palavra (elemento do array)
    return palavras[0];
}
