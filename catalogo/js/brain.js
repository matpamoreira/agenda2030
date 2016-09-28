function filtraTabelas(campo){
    var texto = $(campo).val();
    var achei = false;
    $('.tabela').each(function () {
        var obj = $(this);
        if( obj.find('label').html().indexOf(texto) != -1 ||
            obj.find('.comentario').html().indexOf(texto) != -1
          ){
            obj.show();
            achei = true;
        }
        else{
            obj.hide();
        }
    });
    if( achei ){
        $('.tabelas .msg').hide();
    }
    else{
        $('.tabelas .msg').show();
    }
}

function verTabela(){
    if( $('.tabelas input:checked').length < 1 ){
        alert('Antes selecione pelo menos 1 tabela.');
        return false;
    }
    return true;
}

function verColuna(){
    if( $('#colunas .resultado input:checked').length < 1 ){
        alert('Antes selecione pelo menos 1 coluna.');
        return false;
    }
    return true;
}

function marcaTabela(obj){
    obj = $(obj);
    if( obj.is(":checked") ){
        var ativas = obj.attr('ativas');
        $('.tabelas input').each(function (){
            if( ativas.indexOf(',' + $(this).attr('id').substr(1) + ',') == -1 ){
                $(this).attr('disabled', 'disabled');
            }
        });
        consultarT(obj.val(), obj.attr('id'));
    }
    else{
        $('#colunas .resultado #cs' + obj.attr('id')).remove();
        if( $('.tabelas input:checked').length == 0 ){
            $('.tabelas input').removeAttr('disabled');
            $('#colunas').css('display', 'none');
        }
        $('#dados .resultado').empty();
    }
}

function consultarT(tabela, nome){
    var cx_retorno = $('#colunas .resultado');
    $('#dados .resultado').empty();
    $('#chAll').prop('checked', false);
    cx_retorno.addClass('carregando');
    $('#colunas').css('display', 'block');
    $.ajax({
        url: 'funcoes/consultar.php',
        data: {'t': tabela, 'n': nome},
        cache: true,
        dataType: 'json',
        async: false,
        type: 'POST'
    }).done(function(retorno){
        if(retorno.status == 'ok'){
            cx_retorno.append(retorno.dados);
        }
        cx_retorno.removeClass('carregando');
    });
}

function consultarC(p){
    $('#p').val(( p !== undefined ) ? p : 1);
    var cx_retorno = $('#dados .resultado');
    cx_retorno.empty();
    cx_retorno.addClass('carregando');
    $('#dados').css('display', 'block');
    $.ajax({
        url: 'funcoes/consultar_colunas.php',
        data: $('#colunas').serialize(),
        cache: true,
        dataType: 'json',
        async: false,
        type: 'POST'
    }).done(function(retorno){
        if(retorno.status == 'ok'){
            cx_retorno.append(retorno.dados);
            if( retorno.tabelas !== undefined ){
                $('#dados input[name=ts]').val(retorno.tabelas);
            }
        }
        cx_retorno.removeClass('carregando');
    });
}

function checkAll(){
    var marcarTodos = $('#chAll');
    if( marcarTodos.is(":checked") ){
        $('#colunas .resultado input[type=checkbox]').prop('checked', true);
    }
    else{
        $('#colunas .resultado input[type=checkbox]').prop('checked', false);
    }
}