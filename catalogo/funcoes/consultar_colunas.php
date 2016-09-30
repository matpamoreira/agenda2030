<?php
$VER_LOGIN = true;
include_once '../play.php';
include_once '../conectar.php';
$array = array();
$array['status']  = 'ok';
$_SESSION['colunas'] = array();
$_SESSION['filtros'] = array();

function arrumaNome($val){
    return substr($val, strpos($val, '.') + 1);
}
function arrumaNomeTab($val){
    return substr($val, 0, strpos($val, ' '));
}

$tabelas = $_REQUEST['cts'];
$tabelas_link = implode(',', array_map('arrumaNomeTab', $tabelas));
if( sizeof($tabelas) > 1 ){
    $alias_tabelas = array();
    foreach( $tabelas as $tabela ){
        $chave = explode(' ', $tabela);
        $alias_tabelas[$chave[0]] = $chave[1];
    }
    $tabelas_where = str_replace(',', "','", $tabelas_link);
    $where = "where 1=1";
    foreach( $alias_tabelas as $tabela => $chave ){
        $sql = "select REFERENCED_COLUMN_NAME as col1, TABLE_NAME as tbRef, COLUMN_NAME as col2
                  from INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                 where REFERENCED_TABLE_SCHEMA = '$NAME_DB'
                   and REFERENCED_TABLE_NAME = '{$tabela}'
                   and TABLE_NAME in ('$tabelas_where')
                union
                select COLUMN_NAME as col1, REFERENCED_TABLE_NAME as tbRef, REFERENCED_COLUMN_NAME as col2
                  from INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                 where REFERENCED_TABLE_SCHEMA = '$NAME_DB'
                   and REFERENCED_TABLE_NAME in ('$tabelas_where')
                   and TABLE_NAME = '{$tabela}';";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $where .= " and {$chave}.{$row['col1']} = {$alias_tabelas[$row['tbRef']]}.{$row['col2']}";
    }
}
else{
    $where = '';
}

$filtros = $_REQUEST['f'];
$where_filtro = '';
if( sizeof($filtros) > 0 ) {
    foreach($filtros as $filtro){
        if( strlen($filtro['v']) > 0 ){
            $where_filtro .= " and {$filtro['n']} {$filtro['s']} '{$filtro['v']}'";
            $_SESSION['filtros'][$filtro['n']] = $filtro['v'];
        }
    }
}
if( strlen($where_filtro) > 0 ){
    $where .= $where_filtro;
}
$tabelas = implode(',', $tabelas);
$colunas = $_REQUEST['cs'];
$quant   = $_REQUEST['q_p'];
if( !isset($quant) ){
    $quant = 50;
}
$pagina = $_REQUEST['p'];
if( !isset($pagina) or strlen($pagina) <= 0 ){
    $pagina = 1;
}
$offset = ($pagina - 1) * $quant;


$sql = "select count(1) as t
          from $tabelas $where;";
$result = $conn->query($sql);
if( !$result ){
    echo $sql;
}
//echo $sql;
$row    = $result->fetch_assoc();
$total  = $row['t'];
$array['dados']  = '<div class="cabecalho">';
$array['dados'] .= '<div class="botoes">';
$array['dados'] .= "<a class=\"botao\" onclick=\"filtrar();\" title=\"Filtrar o resultado\">";
$array['dados'] .= '<i class="fa fa-filter" aria-hidden="true"></i>';
$array['dados'] .= '</a>';
$array['dados'] .= "<a class=\"botao\" onclick=\"geraLink('index.php?ts=$tabelas_link&cs=" . implode(',', array_map('arrumaNome', $_REQUEST['cs'])). "&qp=$quant&p=$pagina');\" title=\"Gerar um link para esta visulização\">";
$array['dados'] .= '<i class="fa fa-link" aria-hidden="true"></i>';
$array['dados'] .= '</a>';
$array['dados'] .= '</div>';
$array['dados'] .= '<div>' . number_format($total, 0, ',', '.') . ' registros</div>';
$qtd_pag = ceil($total / $quant);
$array['dados'] .= '<div class="paginas">Páginas:<span class="opcoes">';
if( $qtd_pag > 1 ){
    $rot = ($pagina == 1) ? '[Primeira]' : 'Primeira';
    $array['dados'] .= "<a onclick=\"consultarC(1);\" title=\"Mudar para primeira página\">$rot</a>";
    if( $pagina > 7 ) $array['dados'] .= '<span>...</span>';
    for ($i = $pagina - 5; $i <= $pagina + 5; $i++){
        if($i < 2) continue;
        if($i >= $qtd_pag) break;
        $rot = ($i == $pagina) ? '[' . number_format($i, 0, ',', '.') . ']' : number_format($i, 0, ',', '.');
        $array['dados'] .= "<a onclick=\"consultarC($i);\" title=\"Mudar página\">$rot</a>";
    }
    if( $pagina < $qtd_pag - 6 ) $array['dados'] .= '<span>...</span>';
    $rot = ($pagina == $qtd_pag) ? '[Última]' : 'Última';
    $array['dados'] .= "<a onclick=\"consultarC($qtd_pag);\" title=\"Mudar para última página (" . number_format($qtd_pag, 0, ',', '.') . ")\">$rot</a>";
}
else{
    $array['dados'] .= 'Única';
}
$array['dados'] .= '</span></div>';
$array['dados'] .= '</div>';
array_walk($colunas, function(&$val, $key){
    $_SESSION['colunas'][$key] = $val;
    $val = str_replace('.', '.`', $val) . '` as ' . chr($key + 65);
});
$sql = 'select ' . implode(",", $colunas) .
        " from $tabelas $where
         limit $offset, $quant;";
$result = $conn->query($sql);
$array['dados'] .= '<table>';
$array['dados'] .= '<thead>';
$array['dados'] .= '<tr>';
$array['dados'] .= '<th>#</th><th>' . implode('</th><th>', array_map('arrumaNome', $_REQUEST['cs'])) . '</th>';
$array['dados'] .= '</tr>';
$array['dados'] .= '</thead><tbody>';
$cont = $offset;
while( $row = $result->fetch_assoc() ){
    $cont++;
    $array['dados'] .= '<tr class="l">';
    $array['dados'] .= "<td>$cont</td>";
    foreach($row as $celula){
        $array['dados'] .= "<td>$celula</td>";
    }
    $array['dados'] .= '</tr>';
}
$array['dados'] .= '</tbody></table>';
echo json_encode($array, JSON_UNESCAPED_UNICODE);