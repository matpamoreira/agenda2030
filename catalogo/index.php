<?php
$VER_LOGIN = true;
include_once 'play.php';
include_once 'conectar.php';
getInicio();
?>
<form id="tabelas" action="javascript:consultar('tabelas', 'consulta_catalogo.php');">
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
        echo "<input id=\"t$cont\" name=\"ts[]\" type=\"checkbox\"/>";
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

<?php
getfim();
?>
