<?php
$VER_LOGIN = true;
include_once '../play.php';
include_once '../conectar.php';
$array = array();
$array['status'] = 'ok';
$tabelas = $_REQUEST['ts'];
$sql = "select c.TABLE_NAME, c.COLUMN_NAME, c.COLUMN_COMMENT
          from INFORMATION_SCHEMA.COLUMNS c
         where c.TABLE_NAME in ('$tabelas')
           and c.TABLE_SCHEMA = 'agenda2030'
         order by t.TABLE_NAME, c.COLUMN_NAME;";
    $result = $conn->query($sql);
    $cont = 1;
    while( $row = $result->fetch_assoc() ){
        echo '<div>';
        echo "<input id=\"c$cont\" name=\"cs[]\" value=\"{$row['COLUMN_NAME']}\" type=\"checkbox\"/>";
        echo "<label for=\"c$cont\">{$row['COLUMN_NAME']}</label>";
        echo '</div>';
        $cont++;
    }


$array['dados'] = 'bla bla bla';
echo json_encode($array, JSON_UNESCAPED_UNICODE);