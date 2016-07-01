<?php
$NOM_SISTEMA = 'Agenda 2030';
$NOM_PAGINA  = null;

function getInicio(){
    global $NOM_SISTEMA;
    global $NOM_PAGINA;

    $DESC_SISTEMA = 'DESCRICAO DO SISTEMA';
    $PALAVRAS_CHV = 'PALABRAS CHAVE';

    include_once 'conectar.php';
    //Registrar que o usuário acessou a página
/*
    if( isset($_SESSION['seq_dim_usuario']) ){
        $sql = "insert into bi_dadospublicos_oltp.dim_acesso_pagina (seq_dim_usuario, seq_dim_entidade, dsc_pagina)
					values ({$_SESSION['seq_dim_usuario']}, '{$_SESSION["municipio"]['seq_dim_entidade']}', '$NOM_PAGINA');";
        $conn->query($sql);
    }
*/
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta name="viewport" content="width=device-width" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta charset="utf-8">
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content='pt-BR' />
        <meta name="country" content="Brazil" />
        <meta name="geo.country" content="BR" />
        <meta content="4mti" name="author" />
        <meta name="robots" content="index, follow, noarchive" />
        <meta name="googlebot" content="noarchive" />
        <!--
        <link rel="sitemap" type="application/xml" title="Sitemap" href="sitemap.php" />
        -->
        <meta name="application-name" content="<? echo $NOM_SISTEMA; ?>"  />
        <link rel="shortcut icon" type="image/x-icon" href="img/logo_pq.png" />
        <link rel="icon" type="image/png" sizes="16x16" href="img/logo_pq.png" />
        <link rel="apple-touch-icon" type="image/x-icon" href="img/logo_pq.png" />

        <title><? echo $NOM_SISTEMA . ( isset($NOM_PAGINA) ? ' - ' . $NOM_PAGINA : '' ); ?></title>
        <meta name="description" content="<? echo $DESC_SISTEMA; ?>">
        <meta name="keywords" content="<? echo $PALAVRAS_CHV; ?>" />

        <meta property="fb:app_id" content="796464717165526" />
        <meta property="og:locale" content="pt_BR" />
        <meta property="og:type" content="website" />
        <meta property="og:site_name" content="<? echo $NOM_SISTEMA; ?>" />
        <meta property="og:image" content="http://52.24.9.238/sala_situacao_nescon/img/logo_dp.png" />
        <meta property="og:title" content="<? echo $NOM_SISTEMA; ?>" />
        <meta property="og:description" content="<? echo $DESC_SISTEMA; ?>" />

        <link rel="stylesheet/less" type="text/css" href="css/genesis.less">
        <script type="text/javascript" src="js/less.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/screen.css"/>
        <link rel="stylesheet" type="text/css" href="css/menu.css"/>
        <link rel="stylesheet" type="text/css" href="css/selectize.css"/>
        <link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>
        <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="js/jquery.number.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

        <script type="text/javascript" src="js/xsl.js"></script>
        <script type="text/javascript" src="js/util.js"></script>
        <script type="text/javascript" src="js/brain.js.php"></script>
    </head>
    <body>
        <div class="gesso">
            <div class="cx c1"></div>
            <div class="cx c2"></div>
            <div class="cx c3"></div>
            <div class="cx c4"></div>
            <div class="cx c5"></div>
            <div class="cx c6"></div>
            <div class="cx c7"></div>
            <div class="cx c8"></div>
            <div class="cx c9"></div>
            <div class="cx c10"></div>
            <div class="cx c11"></div>
            <div class="cx c12"></div>
            <div class="cx c13"></div>
            <div class="cx c14"></div>
            <div class="cx c15"></div>
            <div class="cx c16"></div>
            <div class="cx c17"></div>
            <div class="cx c18"></div>
        </div>
        <header>
        </header>
        <div id="conteudo">
        <div id="dialog"></div>
    <?
}

function getFim(){
    global $NOM_SISTEMA;
    ?>
    </div>
    <div class="clear"></div>
    <footer>
        <nav id="mapa_site"></nav>
        <script language="javascript" type="text/javascript">
            //gerarTransformacao('mapa_site', 'menu/menu.php', 'menu/menu.xsl');
        </script>
        <div class="clear"></div>
        <div class="copyright">Plataforma Agenda 2030 para o Desenvolvimento Sustentável</div>
    </footer>
    <div id="preload1"></div>
    <div id="preload2"></div>
    <div id="preload3"></div>
    </body>
    </html>
    <?
}