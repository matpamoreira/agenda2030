<?php
$VER_LOGIN = false;
include_once 'play.php';

$acao = $_REQUEST['acao'];
if( isset($acao) && $acao == 'sair' ){
    $_SESSION['catalogo']['id_usuario']  = null;
    $_SESSION['catalogo']['nom_usuario'] = null;
    session_destroy();
    header("location:logar.php");
    die;
}
if( isset($acao) && $acao == 'Entrar'){
    $login = $_POST['login'];
    $pass  = $_POST['pass'];
    if( !isset($login) or !isset($pass) or
        strlen($login) < 1 or strlen($pass) < 1 ){
        echo 'Faltam dados.';
    }
    else{
        include_once 'conectar.php';
        $sql = "select cu.id_usuario,
                       cu.nom_usuario
                  from $NAME_DB.cat_usuario cu
                 where cu.dsc_login = '$login'
                   and cu.dsc_senha = '$pass'";
        $result = $conn->query($sql);
        if( $row = $result->fetch_assoc() ){
            $_SESSION['catalogo']['id_usuario']  = $row['id_usuario'];
            $_SESSION['catalogo']['nom_usuario'] = $row['nom_usuario'];
            $esta_logando = true;
            header("location:index.php");
            die;
        }
        else{
            $sem_login = 'Login ou senha inválidos.';
        }
    }
}
getInicio();
?>
<h2>Acessar o Catálogo de Dados</h2>
<form method="post" action="logar.php">
    <?php
    if( isset($sem_login) ){
        echo "<div class=\"erro_senha\">$sem_login</div>";
    }
    ?>
    <div class="cmp">
        <label for="login">Login:</label>
        <input id="login" name="login" type="text" />
    </div>
    <div class="cmp">
        <label for="pass">Senha:</label>
        <input id="pass" name="pass" type="password" />
    </div>
    <input type="submit" name="acao" value="Entrar"/>
</form>
<?php
getFim();
?>