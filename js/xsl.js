/**
 * Biblioteca de Matheus Pereira Amaral Moreira
 * Data: outono 2008
 * Referencia: http://www.w3schools.com/xsl/
 * Objetivo: geracao de codigo HTML interpretando XML atraves de XSL.
 */
<!--
	/**
	 * Funcao para carregar o conteudo de um arquivo de XML.
	 * @param name > nome do arquivo XML.
	 * @return xmlDoc > variavel com o conteudo do arquivo XML.
	 */
	function loadXML(name)
	{
		var xmlDoc;

		if (window.ActiveXObject)
		{
			xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
			xmlDoc.async = false;
			xmlDoc.load(name);
		}
		else if (document.implementation && document.implementation.createDocument)
		{
			var Loader = new XMLHttpRequest();
			Loader.open("GET", name ,false);
			Loader.send(null);
			xmlDoc = Loader.responseXML;
		}
		else
			alert('Não foi possível carregar a página, mude de navegador.');

		return(xmlDoc);
	}

	/**
	 * Metodo para gerar a transformacao do arquivo xsl, baseado em um xml, o resultado imprime no elemento informado.
	 * @example > gerarTransformacao('corpo', "teste.xml", "teste.xsl");
	 * @param id > elemento da pagina que recebera o codigo HTML gerado.
	 * @param nameXml > nome do arquivo com conteudo XML.
	 * @param nameXsl > nome do arquivo com conteudo XSL.
	 */
	function gerarTransformacao(id, nameXml, nameXsl)
	{
		var xml = loadXML(nameXml);
		var xsl = loadXML(nameXsl);
		if (window.ActiveXObject)
			document.getElementById(id).innerHTML = xml.transformNode(xsl);
		else if (document.implementation && document.implementation.createDocument)
		{
			xsltProcessor = new XSLTProcessor();
			xsltProcessor.importStylesheet(xsl);
			document.getElementById(id).appendChild(xsltProcessor.transformToFragment(xml, document));
		}
	}
-->