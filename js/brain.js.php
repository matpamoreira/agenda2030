function cadastrar(){
    alert('devo cadstrar');
}

function mostraMeta(ods, id_meta){
    $('.ativo').removeClass('ativo');
    var caixaIndicadores  = $('#inds_' + ods);
    caixaIndicadores.html('');
    caixaIndicadores.addClass('carregando');
    $.ajax({
        url: 'funcoes/carrega_indicador.php',
        data: { 'meta':id_meta },
        async: false,
        dataType: 'json',
        type: 'POST'
    }).done(function(retorno){
        caixaIndicadores.css('display', 'block');
        caixaIndicadores.animate({width:'85%'});
        $('#m' + id_meta).addClass('ativo');
        caixaIndicadores.removeClass('carregando');
        caixaIndicadores.append('<h4>Meta ' + $('#m' + id_meta + ' a div').html() + '</h4>');
        caixaIndicadores.append('<a class="fechar" title="Fechar" href="javascript:fecharMeta(' + ods + ');">X</a>');
        caixaIndicadores.append(retorno.resultado);
    });
}

function fecharMeta(ods){
    var caixa = $('#inds_' + ods);
    caixa.empty();
    caixa.css('display', 'none');
}

function detIndicador(id_ind){
    $('#' + id_ind).css('display', 'table-row');
    var caixaValorInd = $('#' + id_ind + ' td.dados');
    caixaValorInd.addClass('carregando');
    caixaValorInd.empty();
    $.ajax({
        url: 'funcoes/carrega_dados_indicador.php',
        data: { 'id_ind':id_ind },
        async: false,
        dataType: 'json',
        type: 'POST'
    }).done(function(retorno){
        caixaValorInd.removeClass('carregando');
        caixaValorInd.append('<a class="fechar" title="Fechar" href="javascript:fecharVlrInd(' + id_ind + ');">X</a>');
        caixaValorInd.append(retorno.resultado);
        //getGrafico(id_ind, retorno.data);
    });
}

function fecharVlrInd(id){
    var caixa = $('#' + id);
    caixa.css('display', 'none');
}

function toogleMenu(){
    $.fn.fullpage.moveTo(2, 0);
    /*
    if( $('#menu_objetivos') ){
        $('#menu_objetivos').show();
    }
    else{
        $('#menu_objetivos').hide();
    }
    */
}
