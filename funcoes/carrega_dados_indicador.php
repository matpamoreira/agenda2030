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
            if( $corpo != '' ) $corpo .= '</tr>';
            $corpo .= '<tr>';
            $corpo .= "<td>{$row['dsc_localidade']}</td>";
            $corpo .= "<td class=\"tp\">{$row['dsc_grupo_idade']}</td>";
            $corpo .= "<td>{$row['ind_genero']}</td>";
        }
        $corpo .= "<td>{$row['vlr_indicador']}</td>";
        $ult_localidade  = $row['dsc_localidade'];
        $ult_grupo_idade = $row['dsc_grupo_idade'];
        $ult_genero      = $row['ind_genero'];
    }
    $array['resultado']  = '<table>';
    //<th></th>
    $array['resultado'] .= '<thead><tr><th>Localidade</th><th>Grupo Idade</th><th>Género</th>';
    $array['resultado'] .= $titulo;
    $array['resultado'] .= '</tr></thead>';
    $array['resultado'] .= '<tbody>';
    $array['resultado'] .= $corpo;
    $array['resultado'] .= '</tr></tbody></table>';
}
else{
    $array['resultado'] = '<div>Sem dados</div>';
}
echo json_encode($array, JSON_UNESCAPED_UNICODE);