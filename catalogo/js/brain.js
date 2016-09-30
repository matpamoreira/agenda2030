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

var objComment;
function showComment(obj, e){
    if( objComment !== undefined ) return;
    objComment = $(obj).find('.comentario');
    objComment.css('top', '22px')
    var position = ( $(obj).position().left + 30 + $(obj).find('.comentario').width() < $( document ).width() ) ? 'left' : 'right';
    objComment.css(position, '30px')
    objComment.css('display', 'block')
}

function moveComment(e){
/*
 ow.onmousemove = function (e) {
 var x = (e.clientX + 20) + 'px',
 y = (e.clientY + 20) + 'px';
 for (var i = 0; i < tooltips.length; i++) {
 tooltips[i].style.top = y;
 */
}

function hideComment(){
    objComment.css('display', 'none');
    objComment = undefined;
}

function verColuna(){
    if( $('#colunas .resultado input:checked').length < 1 ){
        alert('Antes selecione pelo menos 1 coluna.');
        return false;
    }
    return true;
}

var ativas = new Array();
function marcaTabela(obj, eAsync){
    if(eAsync == undefined){
        eAsync = true;
    }
    obj = $(obj);
    var nAtivas = obj.attr('ativas').split(",");
    if( obj.is(":checked") ){
        ativas = ativas.concat(nAtivas);
        consultarT(obj.val(), obj.attr('id'), eAsync);
    }
    else{
        var quantCheck = $('.tabelas input:checked').length;
        $.each(nAtivas, function(key, value){
            ativas.splice(ativas.indexOf(value), 1);
            var inputTab = $('#t' + value);
            if( quantCheck > 1 && inputTab.is(":checked") ){
                var quant = 0;
                for(var i = 0; i < ativas.length; i++){
                    if( ativas[i] == value ){
                        quant++;
                    }
                    if( quant > 2 ){
                        continue;
                    }
                }
                if( quant <= 1 ){
                    inputTab.attr('checked', false);
                    quantCheck--;
                    marcaTabela(inputTab);
                }
            }
        });
        $('#colunas .resultado #cs' + obj.attr('id')).remove();
        if( $('.tabelas input:checked').length == 0 ){
            $('#colunas').css('display', 'none');
        }
        $('#dados .resultado').empty();
    }

    $('.tabelas input').each(function (){
        if( ativas.length > 0 && ativas.indexOf($(this).attr('id').substr(1)) == -1 ){
            $(this).attr('disabled', 'disabled');
        }
        else{
            $(this).removeAttr('disabled');
        }
    });
}

function consultarT(tabela, nome, eAsync){
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
        async: eAsync,
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
        data: $('#colunas,#modal_filtro form').serialize(),
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
        $('#colunas .resultado input[type=checkbox]').attr('checked', true);
    }
    else{
        $('#colunas .resultado input[type=checkbox]').attr('checked', false);
    }
}

function geraLink(link){
    alert(location.href.substring(0, location.href.lastIndexOf('/') + 1 ) + link);
}

function filtrar(){
    var dialog = $('#modal_filtro');
    dialog.dialog({
        autoOpen: false,
        modal: true,
        resizable: true,
        width: $(window).width() * 0.5,
        height: $(window).height() * 0.8,
        closeOnEscape: false,
        title: 'Filtrar Resultado',
        show:{
            effect:'blind',
            duration:200
        },
        buttons:{
            'Filtrar':{
                text: 'Filtrar',
                click: function(event){
                    $( this ).dialog( 'close' );
                    consultarC();
                }
            },
            'Cancelar': function(){
                $( this ).dialog( 'close' );
            }
        }
    });
    dialog.html('Carregando...');
    dialog.dialog('open');
    dialog.load('form/filtrar.php');
}