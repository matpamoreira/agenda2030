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
    $('#i' + id_ind).css('display', 'table-row');
    var caixaValorInd = $('#i' + id_ind + ' td.dados');
    caixaValorInd.addClass('carregando');
    $.ajax({
        url: 'funcoes/carrega_dados_indicador.php',
        data: { 'id_ind':id_ind },
        async: false,
        dataType: 'json',
        type: 'POST'
    }).done(function(retorno){
        caixaValorInd.removeClass('carregando');
        caixaValorInd.append('<a class="fechar" title="Fechar" href="javascript:fecharVlrInd(' + id_ind + ');">X</a>');
        $(caixaValorInd).find('.tabela').html(retorno.tabela);
        showGrafico(id_ind, retorno.dados);
    });
}

function showGrafico(idCaixa, dados){
    var localeFormatter = d3.locale({
        "decimal": ",",
        "thousands": ".",
        "grouping": [3],
        "currency": ["R$", ""],
        "dateTime": "%d/%m/%Y %H:%M:%S",
        "date": "%d/%m/%Y",
        "time": "%H:%M:%S",
        "periods": ["AM", "PM"],
        "days": ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"],
        "shortDays": ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
        "months": ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
        "shortMonths": ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"]
    });

    var arrayLinhas = [];
    arrayLinhas.push(['x'].concat(dados.rotulos.split(",")));
    var rotulos = {};
    for( var cont = 0; cont < dados.indicadores.length; cont++ ){
        arrayLinhas.push([cont].concat(dados.indicadores[cont].valores.split(",")));
        eval("var rot = {" + cont + ":'" + dados.indicadores[cont].nome + "'};");
        $.extend(rotulos, rot);
    }
    c3.generate({
        bindto:'#i' + idCaixa + ' .grafico',
        data:{
            x:'x',
            columns: arrayLinhas,
            names: rotulos
        },
        legend:{
            position: 'right'
        },
        tooltip:{
            format:{
                value:function(value){
                    return localeFormatter.numberFormat('')(value);
                }
            }
        }
    });
}

function fecharVlrInd(id){
    var caixa = $('#i' + id);
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

function openNav(){
    var menu = $('#mySidenav');
    if( menu.css('width') == '250px' ){
        menu.css('width', '0');
        $('#menu-burger-wrapper').removeClass('menu-opened');
    }
    else{
        menu.css('width', '250px');
        $('#menu-burger-wrapper').addClass('menu-opened');
    }
}

function closeNav(){
    $('#mySidenav').css('width', 0);
    $('#menu-burger-wrapper').removeClass('menu-opened');
}