<?php

	include_once("ProdutoManager.php");

	$funcao = $_REQUEST['funcao'];

	switch ($funcao) {
		case 'recuperarPorCodigo':
			
			if(isset($_REQUEST['codigo'])) {

				$codigo = $_REQUEST['codigo'];
			
				$produtoManager = new ProdutoManager();
				
				$result = $produtoManager->recuperarPorCodigo($codigo);
				
				$produto = mysql_fetch_object($result);
				
				echo json_encode($produto);

			} else {
				
				echo "{error:'Codigo nao enviado.'}";
			}
			
			break;
		
		default:
			
			break;
	}

?>