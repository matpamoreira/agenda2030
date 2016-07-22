<?php
include_once '../conectar.php';
$array = array();
$id_meta = $_REQUEST['meta'];

$sql = "select i.nom_indicador, i.dsc_base_dados, i.dsc_fonte
        from indicador i
        where i.id_meta = $id_meta order by i.id_indicador;";
$result = $conn->query($sql);
if( $result->num_rows > 0 ) {
    $cont = 1;
    $array['resultado'] = '<table>';
    $array['resultado'] .= '<thead><tr>';
    $array['resultado'] .= '<th>Indicador</th><th>Base de Dados</th><th>Fonte</th>';
    $array['resultado'] .= '</tr></thead>';
    $array['resultado'] .= '<tbody>';
    while ($row = $result->fetch_assoc()) {
        $array['resultado'] .= '<tr>';
        $array['resultado'] .= "<td>{$row['nom_indicador']}</td>";
        $array['resultado'] .= "<td>{$row['dsc_base_dados']}</td>";
        $array['resultado'] .= "<td>{$row['dsc_fonte']}</td>";
        $array['resultado'] .= '</tr>';
        $cont++;
    }
    $array['resultado'] .= '</tbody></table>';
}
else{
    $array['resultado'] = '<div>Sem indicadores</div>';
}
echo json_encode($array, JSON_UNESCAPED_UNICODE);