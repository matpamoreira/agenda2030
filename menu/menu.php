<?php
header("Content-type: text/xml; charset=utf-8");
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<menu>
	<opcao nome="Início" link="." chave="home">
		<desc>O Centro de Recursos Computacionais</desc>
	</opcao>

	<opcao nome="Mapa" link="mapa.php" tipo="relatorio">
		<desc>Mapa dos dados do DATASUS.</desc>
	</opcao>

</menu>