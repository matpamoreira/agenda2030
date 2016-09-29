<?php
include_once '../conectar.php';
$array = array();
$id_ods  = $_REQUEST['ods'];
$id_meta = $_REQUEST['meta'];

$sql = "select di.seq_dim_indicador,
               di.nom_indicador,
               di.dsc_frequencia,
               di.dsc_unidade
          from dim_indicador di
         where di.seq_dim_meta = $id_meta
         order by di.seq_dim_indicador";
$result = $conn->query($sql);
if( $result->num_rows > 0 ) {
    $tabela  = '<table>';
    $tabela .= '<thead><tr>';
    $tabela .= '<th></th><th>Indicador</th><th>Frequência</th><th>Unidade</th>';
    $tabela .= '</tr></thead>';
    $tabela .= '<tbody>';
    $cont = 1;
    while ($row = $result->fetch_assoc()) {
        $tabela .= '<tr>';
        $tabela .= "<td>$cont</td>";
        $tabela .= "<td class=\"rot\"><a title=\"Detalha indicador\" href=\"javascript:detIndicador({$row['seq_dim_indicador']});\">{$row['nom_indicador']}</a></td>";
        $tabela .= "<td>{$row['dsc_frequencia']}</td>";
        $tabela .= "<td>{$row['dsc_unidade']}</td>";
        $tabela .= '</tr>';
        $tabela .= "<tr id=\"i{$row['seq_dim_indicador']}\" class=\"detInd\">";
        $tabela .= '<td colspan="4" class="dados">';
        $tabela .= '<div class="grafico"></div>';
        $tabela .= '<div class="tabela"></div>';
        $tabela .= '</td></tr>';
        $cont++;
    }
    $tabela .= '</tbody></table>';
    $array['resultado'] = $tabela;
}
else{
    $array['resultado'] = '<div>Sem indicadores</div>';
}
echo json_encode($array, JSON_UNESCAPED_UNICODE);