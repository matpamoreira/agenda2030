function mostraMeta(ods, num){
    $('#inds_' + ods).html('Mostrar indicadores da meta ' + num);
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