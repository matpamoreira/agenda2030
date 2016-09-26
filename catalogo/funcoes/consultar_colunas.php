<?php
$VER_LOGIN = true;
include_once '../play.php';
include_once '../conectar.php';
$array = array();
$array['status']  = 'ok';
$colunas = '`' . implode("`,`", $_REQUEST['cs']) . '`';
$tabelas = str_replace("\\'", '', $_REQUEST['ts']);
$quant = $_REQUEST['q_p'];
if( !isset($quant) ){
    $quant = 50;
}
$sql = "select $colunas
          from $tabelas
         limit $quant;";
$result = $conn->query($sql);
$cont = 1;
$array['dados'] = '<table>';
$array['dados'] .= '<thead>';
$array['dados'] .= '<tr>';
$array['dados'] .= '<th>Nº</th><th>' . implode('</th><th>', $_REQUEST['cs']) . '</th>';
$array['dados'] .= '</tr>';
$array['dados'] .= '</thead><tbody>';
$cont = 0;
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