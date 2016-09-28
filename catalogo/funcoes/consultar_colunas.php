<?php
$VER_LOGIN = true;
include_once '../play.php';
include_once '../conectar.php';
$array = array();
$array['status']  = 'ok';
function replace($val){
    return str_replace('.', '.`', $val) . '`';
}
function arrumaNome($val){
    return substr($val, strpos($val, '.') + 1);
}

$tabelas = $_REQUEST['cts'];
if( sizeof($tabelas) > 1 ){
    $where = "where 1=1";
    for( $i = 1; $i < sizeof($tabelas); $i++ ){
        $chave1 = explode(' ', $tabelas[$i - 1]);
        $chave2 = explode(' ', $tabelas[$i]);

        $sql = "select REFERENCED_COLUMN_NAME as col1, COLUMN_NAME as col2
                  from INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                 where REFERENCED_TABLE_SCHEMA = '$NAME_DB'
                   and REFERENCED_TABLE_NAME = '{$chave1[0]}'
                   and TABLE_NAME = '{$chave2[0]}'
                union
                select COLUMN_NAME as col1, REFERENCED_COLUMN_NAME as col2
                  from INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                 where REFERENCED_TABLE_SCHEMA = '$NAME_DB'
                   and REFERENCED_TABLE_NAME = '{$chave2[0]}'
                   and TABLE_NAME = '{$chave1[0]}';";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $where .= " and {$chave1[1]}.{$row['col1']} = {$chave2[1]}.{$row['col2']}";
    }
}
else{
    $where = '';
}
$tabelas = implode(',', $tabelas);

$colunas = array_map('replace', $_REQUEST['cs']);
$colunas = implode(",", $colunas);
$quant  = $_REQUEST['q_p'];
if( !isset($quant) ){
    $quant = 50;
}
$pagina = $_REQUEST['p'];
if( !isset($pagina) ){
    $pagina = 0;
}
$offset = ($pagina - 1) * $quant;


$sql = "select count(1) as t
          from $tabelas $where;";
$result = $conn->query($sql);
$row    = $result->fetch_assoc();
$total  = $row['t'];
$array['dados']  = '<div>' . number_format($total, 0, ',', '.') . ' registros</div>';
$qtd_pag = ceil($total / $quant);
if( $qtd_pag > 1 ){
    $array['dados'] .= '<div class="paginas">Páginas:<span class="opcoes">';
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
    $array['dados'] .= '</span></div>';
}
$sql = "select $colunas
          from $tabelas $where
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