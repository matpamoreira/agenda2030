<?php
$VER_LOGIN = true;
include_once 'play.php';
include_once 'conectar.php';
getInicio();
?>
<form id="tabelas" action="javascript:consultarT();" onsubmit="return verTabela();">
    <div class="cmp">
        <div>
            <div class="titulo">Tabelas:</div>
            <div id="busca_tabela"><input type="text" name="nome" placeholder="Nome ou descrição da tabela" onkeyup="filtraTabelas(this);"/></div>
        </div>
        <div class="tabelas">
            <div class="msg" style="display:none;">Não foram localizadas tabelas</div>
    <?php
    $sql = "select t.*,
                   (select GROUP_CONCAT(distinct n.c)
                      from (select k1.TABLE_NAME as t, k1.REFERENCED_TABLE_NAME as c
                              from INFORMATION_SCHEMA.KEY_COLUMN_USAGE k1
                             where k1.REFERENCED_TABLE_SCHEMA = '$NAME_DB'
                               and k1.REFERENCED_TABLE_NAME <> k1.TABLE_NAME
                             union
                            select k2.REFERENCED_TABLE_NAME as t, k2.TABLE_NAME as c
                              from INFORMATION_SCHEMA.KEY_COLUMN_USAGE k2
                             where k2.REFERENCED_TABLE_SCHEMA = '$NAME_DB'
                               and k2.REFERENCED_TABLE_NAME <> k2.TABLE_NAME
                           ) n where n.t = t.TABLE_NAME
                   ) as tbs_ref
              from(
            select @rank := @rank+1 as r,
                   t.TABLE_NAME, t.TABLE_ROWS, t.DATA_LENGTH, t.TABLE_COMMENT
              from INFORMATION_SCHEMA.TABLES t, (select @rank := 0) r
             where TABLE_SCHEMA = '$NAME_DB'
               and TABLE_TYPE = 'BASE TABLE'
               and t.TABLE_NAME not like 'CAT%'
               and t.TABLE_NAME not like 'LOG%'
             order by t.TABLE_NAME) t;";
    $result = $conn->query($sql);
    $tabelas = array();
    while( $row = $result->fetch_assoc() ){
        $tabelas[$row['TABLE_NAME']] = $row['r'];
    }
    $result->data_seek(0);

    while( $row = $result->fetch_assoc() ){
        if( $row['TABLE_COMMENT'] == '' ){
            $row['TABLE_COMMENT'] = 'Sem descrição';
        }
        echo '<div class="tabela">';
        $ativas = '';
        if( isset($row['tbs_ref']) ){
            $referencias = explode(',', $row['tbs_ref']);
            foreach($referencias as $referencia) {
                $ativas .= $tabelas[$referencia] . ',';
            }
        }
        echo "<input id=\"t{$row['r']}\" name=\"ts[]\" value=\"{$row['TABLE_NAME']}\" type=\"checkbox\" onchange=\"marcaTabela(this);\" ativas=\",{$row['r']},$ativas\"/>";
        echo "<label for=\"t{$row['r']}\">{$row['TABLE_NAME']}</label>";
        echo '<div class="comentario">';
        echo number_format($row['TABLE_ROWS'], 0, ',', '.') . ' linhas <span class="f_p">(' . number_format($row['DATA_LENGTH'] / 1024 / 1024, 2, ',', '.') . ' MB)</span><br/>';
        echo $row['TABLE_COMMENT'];
        echo '</div>';
        echo '</div>';
    }
    ?>
        </div>
    </div>
    <div class="clear"></div>
</form>
<form id="colunas" action="javascript:consultarC();" style="display:none;" onsubmit="return verColuna();">
    <div class="titulo">Colunas:</div>
    <input id="chAll" type="checkbox" onchange="checkAll();"/>
    <div class="colunas">
        <div class="resultado"></div>
    </div>
    <div class="cmp">
        <label>Quant. por Página</label>
        <select name="q_p">
            <option>10</option>
            <option>20</option>
            <option>50</option>
            <option>100</option>
            <option>200</option>
        </select>
    </div>
    <input id="p" type="hidden" name="p">
    <div class="clear"></div>
    <input type="submit" value="Consultar">
</form>
<div id="dados">
    <div class="resultado"></div>
</div>
<?php
getfim();
?>
