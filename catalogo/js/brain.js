function consultar(form, url, idReturn){
    var dados = $('#' + form).serialize();
    var cx_retorno = $('#' + idReturn)
    cx_retorno.removeClass('carregando');
    $.ajax({
        url: url,
        data: dados,
        cache: true,
        dataType: 'json',
        async: false,
        type: 'POST'
    }).done(function(retorno){
        if(retorno.status == 'ok'){
            cx_retorno.empty();
            cx_retorno.append(retorno.dados);
        }
        cx_retorno.removeClass('carregando');
    });

}