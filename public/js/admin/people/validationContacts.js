
var countContact = 0;

function addContact(){
    countContact++;
    var divContact = ""
    + " <div class='form-group col-md-4 contact-"+countContact+"' style='margin-top: 5px;'>"
        + " <input type='text' name='fone["+countContact+"]' class='form-control fone fone-"+countContact+"' placeholder='(00) 00000-0000' value=''> &nbsp;"
        + " <button type='button' class='btn btn-danger' onclick='delContact("+countContact+")'> <i class='fas fa-trash-alt'></i> </button>"
    + " </div>";

    $('.div-contact').append(divContact);
}

function delContact(id) {
    var url_current = window.location.href;
    var create = url_current.indexOf("create")

    Swal.fire({
        title: "Vai excluir mesmo?",
        text: "Deseja realmente excluir este registro?",
        type: "warning",
        showCancelButton: !0,
        confirmButtonText: "Sim, tenho certeza!",
        cancelButtonText: "Ops, vou não!",
        reverseButtons: !0
    }).then(function (e) {
        if (e.value === true) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            if(create == -1){
                $.ajax({
                    type: 'DELETE',
                    url: `/admin/contact/${id}`,
                    data: {
                        _token: CSRF_TOKEN
                    },
                    dataType: 'JSON',
                    success: function (results) {
                        if (results.type == 'success') {
                            Swal.fire(
                                'Excluído!',
                                results.message,
                                'success'
                            );
                            removeContact(id);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Ops...',
                                text: results.message,
                            });
                        }
                    }
                });
            } else {
                removeContact(id);
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Ops...',
                text: 'Exclusão cancelada',
            });
        }
    }, function (dismiss) {
        return false;
    })
}

function removeContact(id){
    $('.contact-'+id).remove();
}

$(document).ready(function() {

    $('#btnSave').attr('type', 'button');
    $('#btnSave').prop("onclick", null);

    $('#btnSave').click(function(){
        var foneIncorrect = 0;

        if($('.name').length == 0){
            Swal.fire(
                'Atenção!',
                'Preencha o campo nome!',
                'error'
            );
            $('.name').focus();
            return false;
        }
        if($('.document').length == 0){
            Swal.fire(
                'Atenção!',
                'Preencha o campo documento!',
                'error'
            );
            $('.document').focus();
            return false;
        }

        $(".fone").each(function(index) {
            fone = validationFone($(this).val());

            if(fone === false){
                foneIncorrect++;
                $(this).val('');

                $(this).css('border', '1px solid red');
                $(this).focus();
            }
        });
        if(foneIncorrect > 0){
            Swal.fire(
                'Atenção!',
                'Informe um contato válido!',
                'error'
            );
            return false;
        } else{
            $('#btnSave').attr('type', 'submit');
            $('#btnSave').prop("onclick", submitForm());
        }

        return false;
    });
});

/**
 * Código retirado do seguinte link: https://gist.github.com/jonathangoncalves/7bdec924e9bd2bdf353d6b7520820b62
 */
function validationFone(fone) {
    //retira todos os caracteres menos os numeros
    fone = fone.replace(/\D/g, '');

    //verifica se tem a qtde de numero correto
    if (!(fone.length >= 10 && fone.length <= 11)) return false;

    //Se tiver 11 caracteres, verificar se começa com 9 o celular
    if (fone.length == 11 && parseInt(fone.substring(2, 3)) != 9) return false;

    //verifica se não é nenhum numero digitado errado (propositalmente)
    for (var n = 0; n < 10; n++) {
        //um for de 0 a 9.
        //estou utilizando o metodo Array(q+1).join(n) onde "q" é a quantidade e n é o
        //caractere a ser repetido
        if (fone == new Array(11).join(n) || fone == new Array(12).join(n)) return false;
    }
    //DDDs validos
    var codigosDDD = [11, 12, 13, 14, 15, 16, 17, 18, 19,
        21, 22, 24, 27, 28, 31, 32, 33, 34,
        35, 37, 38, 41, 42, 43, 44, 45, 46,
        47, 48, 49, 51, 53, 54, 55, 61, 62,
        64, 63, 65, 66, 67, 68, 69, 71, 73,
        74, 75, 77, 79, 81, 82, 83, 84, 85,
        86, 87, 88, 89, 91, 92, 93, 94, 95,
        96, 97, 98, 99];
    //verifica se o DDD é valido (sim, da pra verificar rsrsrs)
    if (codigosDDD.indexOf(parseInt(fone.substring(0, 2))) == -1) return false;

    //  E por ultimo verificar se o numero é realmente válido. Até 2016 um celular pode
    //ter 8 caracteres, após isso somente numeros de fone e radios (ex. Nextel)
    //vão poder ter numeros de 8 digitos (fora o DDD), então esta função ficará inativa
    //até o fim de 2016, e se a ANATEL realmente cumprir o combinado, os numeros serão
    //validados corretamente após esse período.
    //NÃO ADICIONEI A VALIDAÇÂO DE QUAIS ESTADOS TEM NONO DIGITO, PQ DEPOIS DE 2016 ISSO NÃO FARÁ DIFERENÇA
    //Não se preocupe, o código irá ativar e desativar esta opção automaticamente.
    //Caso queira, em 2017, é só tirar o if.
    if (new Date().getFullYear() < 2017) return true;
    if (fone.length == 10 && [2, 3, 4, 5, 7].indexOf(parseInt(fone.substring(2, 3))) == -1) return false;

    //se passar por todas as validações acima, então está tudo certo
    return true;
}

function validationDocument() {
    valor = $('#document').val();
    // tipo = $('#tipo').val();
    tipo = 'F';
    if (tipo == 'F') {
        if (isCPFValid(valor)) {
            $('#document').val(cpf(valor));
        } else {
            $('#document').val('');
            Swal.fire({
                icon: 'error',
                title: 'Ops...',
                text: 'CPF inválido! Forneça um válido!'
            });
        }
    }
}

function isCPFValid(cpf) {
	cpf = cpf.replace(/[^\d]+/g,'');
	if(cpf == '') return false;
	// Elimina CPFs invalidos conhecidos
	if (cpf.length != 11 ||
		cpf == "00000000000" ||
		cpf == "11111111111" ||
		cpf == "22222222222" ||
		cpf == "33333333333" ||
		cpf == "44444444444" ||
		cpf == "55555555555" ||
		cpf == "66666666666" ||
		cpf == "77777777777" ||
		cpf == "88888888888" ||
		cpf == "99999999999")
			return false;
	// Valida 1o digito
	add = 0;
	for (i=0; i < 9; i ++)
		add += parseInt(cpf.charAt(i)) * (10 - i);
		rev = 11 - (add % 11);
		if (rev == 10 || rev == 11)
			rev = 0;
		if (rev != parseInt(cpf.charAt(9)))
			return false;
	// Valida 2o digito
	add = 0;
	for (i = 0; i < 10; i ++)
		add += parseInt(cpf.charAt(i)) * (11 - i);
	rev = 11 - (add % 11);
	if (rev == 10 || rev == 11)
		rev = 0;
	if (rev != parseInt(cpf.charAt(10)))
		return false;
	return true;
}

function cpf(v) {
    v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
    v = v.replace(/(\d{3})(\d)/, "$1.$2") //Coloca um ponto entre o terceiro e o quarto dígitos
    v = v.replace(/(\d{3})(\d)/, "$1.$2") //Coloca um ponto entre o terceiro e o quarto dígitos
    //de novo (para o segundo bloco de números)
    v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2") //Coloca um hífen entre o terceiro e o quarto dígitos
    return v
}
