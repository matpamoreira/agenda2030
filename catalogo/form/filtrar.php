<?php
$VER_LOGIN = true;
include_once '../play.php';
?>
<form>
    Opções de Filtros:
    <?php
        foreach($_SESSION['colunas'] as $key => $coluna){
            echo '<div class="cmp">';
            echo $coluna;
            echo " <input name=\"f[$key][n]\" value=\"$coluna\" type=\"hidden\"/>";
            echo " <select name=\"f[$key][s]\">";
            echo '<option value="=">Igual</option>';
            echo '<option value="!=">Diferente</option>';
            echo '</select>';
            echo " <input name=\"f[$key][v]\" type=\"text\" value=\"{$_SESSION['filtros'][$coluna]}\"/>";
            echo '</div>';
        }
    ?>
</form>