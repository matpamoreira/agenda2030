<?php
$VER_LOGIN = true;
include_once '../play.php';
include_once '../conectar.php';
$array = array();
$array['status'] = 'ok';
$tabela = $_REQUEST['t'];
$nome   = $_REQUEST['n'];
$sql = "select c.TABLE_NAME, c.COLUMN_NAME, c.COLUMN_COMMENT, upper(c.DATA_TYPE) as DATA_TYPE, c.CHARACTER_MAXIMUM_LENGTH
          from INFORMATION_SCHEMA.COLUMNS c
         where c.TABLE_NAME = '$tabela'
           and c.TABLE_SCHEMA = '$NAME_DB'
         order by c.TABLE_NAME, c.ORDINAL_POSITION;";
$result = $conn->query($sql);
$cont = 1;
$array['dados']  = "<div class=\"colsTab\" id=\"cs$nome\">";
$array['dados'] .= "<input name=\"cts[]\" value=\"$tabela $nome\" type=\"hidden\"/>";
$array['dados'] .= "<div class=\"titulo\">$tabela</div>";
while( $row = $result->fetch_assoc() ){
    if($row['COLUMN_COMMENT'] == ''){
        $row['COLUMN_COMMENT'] = 'Sem descrição';
    }
    $array['dados'] .= '<div class="coluna">';
    $array['dados'] .= "<input id=\"$nome.c$cont\" name=\"cs[]\" value=\"$nome.{$row['COLUMN_NAME']}\" type=\"checkbox\"/>";
    $array['dados'] .= "<label for=\"$nome.c$cont\">{$row['COLUMN_NAME']}</label>";
    $array['dados'] .= '<div class="comentario">';
    $array['dados'] .= $row['COLUMN_COMMENT'] . '<br/>';
    $array['dados'] .= $row['DATA_TYPE'];
    if( strlen($row['CHARACTER_MAXIMUM_LENGTH']) > 0 and $row['CHARACTER_MAXIMUM_LENGTH'] != 0){
        $array['dados'] .= " <span class=\"f_p\">(" . number_format($row['CHARACTER_MAXIMUM_LENGTH'], 0, ',', '.') . ")</span>";
    }
    $array['dados'] .= '</div>';
    $array['dados'] .= '</div>';
    $cont++;
}
$array['dados'] .= '</div>';
echo json_encode($array, JSON_UNESCAPED_UNICODE);