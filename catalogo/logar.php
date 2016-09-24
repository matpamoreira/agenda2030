<?php
$VER_LOGIN = false;
include_once 'play.php';

$acao = $_REQUEST['acao'];
if( isset($acao) && $acao == 'sair'){
    $_SESSION['catalogo']['id_usuario']  = null;
    $_SESSION['catalogo']['nom_usuario'] = null;
    session_destroy();
    header("location:logar.php");
    die;
}

$login = $_POST['login'];
$pass  = $_POST['pass'];
if( !isset($login) or !isset($pass) or
    strlen($login) < 1 or strlen($pass) < 1 ){
    die('Faltam dados.');
}

include_once 'conectar.php';
$sql = "select cu.id_usuario,
			   cu.nom_usuario
		  from $NAME_DB_OLTP.cat_usuario cu
		 where cu.dsc_login = '$login'
		   and cu.dsc_senha = '$pass'";
$result = $conn->query($sql);
if( $row = $result->fetch_assoc() ) {
    $_SESSION['catalogo']['id_usuario']  = $row['id_usuario'];
    $_SESSION['catalogo']['nom_usuario'] = $row['nom_usuario'];
    $esta_logando = true;
}
else{
    $_SESSION["sem_login"] = 'Login ou senha inválidos.';
    header("location:logar.php");
    die;
}
header("location:index.php");?>

<form id="logar" class="busca" method="post" action="funcoes/login.php" onsubmit="return logar(this);">
    <?php
    if( isset($_SESSION["sem_login"]) ){
        echo "<div class=\"erro_senha\">{$_SESSION["sem_login"]}</div>";
        $_SESSION["sem_login"] = null;
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
    <a class="btt exec" onclick="$(this).next().click();"><i class="fa fa-sign-in"></i>Entrar</a>
    <input style="display:none;" type="submit" value="Entrar"/>
</form>

