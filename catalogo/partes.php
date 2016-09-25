<?php
$NOM_SISTEMA = 'Catálogo de Dados';
$NOM_PAGINA  = null;
function getHead(){
global $NOM_SISTEMA;
global $NOM_PAGINA;

$DESC_SISTEMA = 'Catálogo de Dados.';
$PALAVRAS_CHV = 'Catálogo, Dados';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Language" content='pt-BR' />
    <meta name="country" content="Brazil" />
    <meta name="geo.country" content="BR" />
    <meta content="4mti" name="author" />
    <meta name="robots" content="index, follow, noarchive" />
    <meta name="googlebot" content="noarchive" />
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
    <meta property="og:title" content="<? echo $NOM_SISTEMA; ?>" />
    <meta property="og:description" content="<? echo $DESC_SISTEMA; ?>" />

    <link rel="stylesheet" type="text/css" media="screen" href="css/genesis.css"/>
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="js/brain.js"></script>
</head>
<body>
    <header>
        Catálogo de Dados
    </header>
<?php
}

function getInicio(){
    getHead();
}

function getFim(){
?>
</body>
</html>
<?php
}