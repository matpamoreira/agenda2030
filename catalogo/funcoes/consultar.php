<?php
$VER_LOGIN = true;
include_once '../play.php';
include_once '../conectar.php';
$array = array();
$array['status'] = 'ok';
$array['tabelas'] = implode("','", $_REQUEST['ts']);
$sql = "select c.TABLE_NAME, c.COLUMN_NAME, c.COLUMN_COMMENT
          from INFORMATION_SCHEMA.COLUMNS c
         where c.TABLE_NAME in ('{$array['tabelas']}')
           and c.TABLE_SCHEMA = 'agenda2030'
         order by c.TABLE_NAME, c.ORDINAL_POSITION;";
$result = $conn->query($sql);
$cont = 1;
$array['dados'] = '';
while( $row = $result->fetch_assoc() ){
    $array['dados'] .= '<div>';
    $array['dados'] .= "<input id=\"c$cont\" name=\"cs[]\" value=\"{$row['COLUMN_NAME']}\" type=\"checkbox\"/>";
    $array['dados'] .= "<label for=\"c$cont\" title=\"{$row['COLUMN_COMMENT']}\">{$row['COLUMN_NAME']}</label>";
    $array['dados'] .= '</div>';
    $cont++;
}
echo json_encode($array, JSON_UNESCAPED_UNICODE);