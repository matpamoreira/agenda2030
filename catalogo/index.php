<?php
$VER_LOGIN = true;
include_once 'play.php';
include_once 'conectar.php';
getInicio();
?>
<form id="tabelas" action="javascript:consultar('tabelas', 'funcoes/consultar.php', 'colunas');">
    <div class="cmp">
        <span>Tabelas:</span>
        <div class="tabelas">
    <?php
    $sql = "select t.TABLE_NAME, t.TABLE_ROWS, t.DATA_LENGTH
              from INFORMATION_SCHEMA.TABLES t
             where TABLE_SCHEMA = '$NAME_DB'
               and TABLE_TYPE = 'BASE TABLE'
               and t.TABLE_NAME not like 'CAT%'
               and t.TABLE_NAME not like 'LOG%'
             order by t.TABLE_NAME;";
    $result = $conn->query($sql);
    $cont = 1;
    while( $row = $result->fetch_assoc() ){
        echo '<div>';
        echo "<input id=\"t$cont\" name=\"ts[]\" value=\"{$row['TABLE_NAME']}\" type=\"checkbox\"/>";
        echo "<label for=\"t$cont\">{$row['TABLE_NAME']}</label>";
        echo '</div>';
        $cont++;
    }
    ?>
        </div>
    </div>
    <div class="clear"></div>
    <input type="submit" value="Consultar">
</form>
<form id="colunas" action="javascript:consultar('colunas', 'funcoes/consultar_colunas.php', 'dados');" style="display:none;">
    <div class="cmp">
        <span>Colunas:</span>
        <div class="resultado"></div>
    </div>
    <div class="cmp">
        <label>Quant. Página</label>
        <select name="q_p">
            <option>10</option>
            <option>50</option>
            <option>100</option>
        </select>
    </div>
    <input type="hidden" name="ts" value="">
    <div class="clear"></div>
    <input type="submit" value="Consultar">
</form>
<div id="dados">
    <div class="resultado"></div>
</div>
<?php
getfim();
?>
