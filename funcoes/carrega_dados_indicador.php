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
if( $result->num_rows > 0 ){
    $ult_ano = '';
    $ult_localidade  = '';
    $ult_grupo_idade = '';
    $ult_genero      = '';
    $indicadores     = array();
    $variaveisColuna = array();
    $coluna1Mudou = false;
    $coluna2Mudou = false;
    $coluna3Mudou = false;
    while( $row = $result->fetch_assoc() ){
        if( $row['num_ano'] > $ult_ano ){
            $titulo  .= "<th>{$row['num_ano']}</th>";
            $rotulos .= $row['num_ano'] . ',';
            $ult_ano  = $row['num_ano'];
        }

        if( $ult_localidade  != $row['dsc_localidade'] or
            $ult_grupo_idade != $row['dsc_grupo_idade'] or
            $ult_genero      != $row['ind_genero'] ){
            array_push($variaveisColuna, array($row['dsc_localidade'], $row['dsc_grupo_idade'], $row['ind_genero']));
            if( $corpo != '' ){
                if(!$coluna1Mudou && $ult_localidade != $row['dsc_localidade'] )
                    $coluna1Mudou = true;
                if(!$coluna2Mudou && $ult_grupo_idade != $row['dsc_grupo_idade'] )
                    $coluna2Mudou = true;
                if(!$coluna3Mudou && $ult_genero != $row['ind_genero'] )
                    $coluna3Mudou = true;

                $indicador['valores'] = substr($valores, 0, -1);
                $corpo  .= '<td class="ln">' . $indicador['valores'] . '</td></tr>';
                array_push($indicadores, $indicador);
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
    $array['tabela']  = "<table id=\"t_$id_ind\">";
    $array['tabela'] .= '<thead><tr><th>Localidade</th><th>Grupo Idade</th><th>Gênero</th>';
    $array['tabela'] .= $titulo;
    $array['tabela'] .= '<th>Histograma</th></tr></thead>';
    $array['tabela'] .= '<tbody>';
    $array['tabela'] .= $corpo . '<td class="ln">' . substr($valores, 0, -1) . '</td>';
    $array['tabela'] .= '</tr></tbody></table>';
    $array['tabela'] .= '<script type="text/javascript">';
    $array['tabela'] .= "$('#t_$id_ind .ln').sparkline('html', {type:'bar'});";
    $array['tabela'] .= '</script>';
    $array['dados']['rotulos'] = substr($rotulos, 0, -1);
    $indicador['valores'] = substr($valores, 0, -1);
    array_push($indicadores, $indicador);
    foreach( $indicadores as $key => &$ind ){
        $ind['nome']  = '';
        $ind['nome'] .= ($coluna1Mudou) ? ('Localidade: ' . $variaveisColuna[$key]{0} . ' / ') : '';
        $ind['nome'] .= ($coluna2Mudou) ? ('Idade: ' . $variaveisColuna[$key]{1} . ' / ') : '';
        $ind['nome'] .= ($coluna3Mudou) ? ('Gênero: ' . $variaveisColuna[$key]{2} . ' / ') : '';
        if( strlen($ind['nome']) == 0 ) {
            $ind['nome'] = 'Total';
        }
        else{
            $ind['nome'] = substr($ind['nome'], 0, -3);
        }
    }
    $array['dados']['indicadores'] = $indicadores;
}
else{
    $array['resultado'] = '<div>Sem dados</div>';
}
echo json_encode($array, JSON_UNESCAPED_UNICODE);