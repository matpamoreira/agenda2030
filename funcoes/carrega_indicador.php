<?php
include_once '../conectar.php';
$array = array();
$id_ods  = $_REQUEST['ods'];
$id_meta = $_REQUEST['meta'];

$sql = "select di.seq_dim_indicador,
               di.nom_indicador,
               di.dsc_frequencia,
               di.dsc_undiade
          from dim_indicador di
         where di.seq_dim_meta = $id_meta
         order by di.seq_dim_indicador";
$result = $conn->query($sql);
if( $result->num_rows > 0 ) {
    $array['resultado'] = '<table>';
    $array['resultado'] .= '<thead><tr>';
    $array['resultado'] .= '<th></th><th>Indicador</th><th>Frequência</th><th>Unidade</th>';
    $array['resultado'] .= '</tr></thead>';
    $array['resultado'] .= '<tbody>';
    $cont = 1;
    while ($row = $result->fetch_assoc()) {
        $array['resultado'] .= '<tr>';
        $array['resultado'] .= "<td>$cont</td>";
        $array['resultado'] .= "<td class=\"rot\"><a title=\"Detalha indicador\" href=\"javascript:detIndicador({$row['seq_dim_indicador']});\">{$row['nom_indicador']}</a></td>";
        $array['resultado'] .= "<td>{$row['dsc_frequencia']}</td>";
        $array['resultado'] .= "<td>{$row['dsc_undiade']}</td>";
        $array['resultado'] .= '</tr>';
        $array['resultado'] .= "<tr id=\"{$row['seq_dim_indicador']}\" class=\"detInd\"><td colspan=\"4\" class=\"dados\"></td></tr>";
        $cont++;
    }
    $array['resultado'] .= '</tbody></table>';
}
else{
    $array['resultado'] = '<div>Sem indicadores</div>';
}
echo json_encode($array, JSON_UNESCAPED_UNICODE);