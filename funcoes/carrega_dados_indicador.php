<?php
include_once '../conectar.php';
$array = array();
$id_ind = $_REQUEST['id_ind'];

$sql = "select dt.num_ano,
               (select dl.dsc_localidade
                  from dim_localidade dl
                 where dl.seq_dim_localidade = dvi.seq_dim_localidade
               ) as dsc_localidade,
               (select dgi.dsc_grupo_idade
                  from dim_grupo_idade dgi
                 where dgi.seq_dim_grupo_idade = dvi.seq_dim_grupo_idade
               ) as dsc_grupo_idade,
               dvi.ind_genero,
               dvi.vlr_indicador
          from dim_valor_indicador dvi, dim_tempo dt
         where dvi.seq_dim_indicador = '$id_ind'
           and dvi.seq_dim_tempo = dt.seq_dim_tempo
           and dt.num_ano >= 2001
         order by dsc_localidade, dsc_grupo_idade, dvi.ind_genero, dt.num_ano;";
//echo $sql;
$result = $conn->query($sql);
$titulo = '';
$corpo = '';
if( $result->num_rows > 0 ) {
    $ult_ano = '';
    $ult_localidade  = '';
    $ult_grupo_idade = '';
    $ult_genero      = '';
    while ($row = $result->fetch_assoc()) {
        if( $row['num_ano'] > $ult_ano ){
            $titulo .= "<th>{$row['num_ano']}</th>";
            $ult_ano = $row['num_ano'];
        }

        if( $ult_localidade  != $row['dsc_localidade'] or
            $ult_grupo_idade != $row['dsc_grupo_idade'] or
            $ult_genero      != $row['ind_genero'] ){
            if( $corpo != '' ){
                $corpo  .= '<td class="ln">' . substr($valores, 0, -1) . '</td></tr>';
                $valores = '';
            }
            $corpo .= '<tr>';
            $corpo .= "<td>{$row['dsc_localidade']}</td>";
            $corpo .= "<td class=\"tp\">{$row['dsc_grupo_idade']}</td>";
            $corpo .= "<td>{$row['ind_genero']}</td>";
        }
        if( $row['vlr_indicador'] != 0 ){
            $corpo .= "<td>{$row['vlr_indicador']}</td>";
            $valores .= $row['vlr_indicador'] . ',';
        }
        else{
            $corpo .= "<td>-</td>";
            $valores .= 'null,';
        }
        $ult_localidade  = $row['dsc_localidade'];
        $ult_grupo_idade = $row['dsc_grupo_idade'];
        $ult_genero      = $row['ind_genero'];
    }
    $array['resultado']  = "<table id=\"t_$id_ind\">";
    $array['resultado'] .= '<thead><tr><th>Localidade</th><th>Grupo Idade</th><th>Gênero</th>';
    $array['resultado'] .= $titulo;
    $array['resultado'] .= '<th>Histograma</th></tr></thead>';
    $array['resultado'] .= '<tbody>';
    $array['resultado'] .= $corpo . '<td class="ln">' . substr($valores, 0, -1) . '</td>';
    $array['resultado'] .= '</tr></tbody></table>';
    $array['resultado'] .= '<script type="text/javascript">';
    $array['resultado'] .= "$('#t_$id_ind .ln').sparkline('html', {type:'bar'});";
    $array['resultado'] .= '</script>';
}
else{
    $array['resultado'] = '<div>Sem dados</div>';
}
echo json_encode($array, JSON_UNESCAPED_UNICODE);