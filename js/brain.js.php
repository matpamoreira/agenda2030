function cadastrar(){
    alert('devo cadstrar');
}
function mostraMeta(ods, num_meta){
    $('.ativo').removeClass('ativo');
    $('#inds_' + ods).html('');
    $('#inds_' + ods).addClass('carregando');
    $.ajax({
        url: 'funcoes/carrega_indicador.php',
        data: { 'ods':ods, 'meta':num_meta },
        async: false,
        dataType: 'json',
        type: 'POST'
    }).done(function(retorno){
        $('#m' + ods + '.' + num_meta).addClass('ativo');
        $('#inds_' + ods).removeClass('carregando');
        $('#inds_' + ods).html(retorno.resultado);
    });
}

function toogleMenu(){
    $.fn.fullpage.moveTo(2, 0);
    return;
    if( $('#menu_objetivos') ){
        $('#menu_objetivos').show();
    }
    else{
        $('#menu_objetivos').hide();
    }
}