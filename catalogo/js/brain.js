function consultar(form, url, idReturn){
    var dados = $('#' + form).serialize();
    var cx_retorno = $('#' + idReturn + ' .resultado')
    cx_retorno.empty();
    cx_retorno.addClass('carregando');
    $('#' + idReturn).css('display', 'block');
    $.ajax({
        url: url,
        data: dados,
        cache: true,
        dataType: 'json',
        async: false,
        type: 'POST'
    }).done(function(retorno){
        if(retorno.status == 'ok'){
            cx_retorno.append(retorno.dados);
            if( retorno.tabelas !== undefined ){
                $('#' + idReturn + ' input[name=ts]').val(retorno.tabelas);
            }
        }
        cx_retorno.removeClass('carregando');
    });
}