<?php

	require_once("ProdutoManager.php");
	require_once("Uteis.php");

	$managerOpcao = isset($_REQUEST['managerOpcao']) ? $_REQUEST['managerOpcao'] : "";

	switch ($managerOpcao) {
		
		case 'CADASTRAR':
		
			$produto = new Produto();
			$produto->codigoBarra 	= $_REQUEST['produtoForm_txtCodigoBarra']; 
			$produto->descricao 	= $_REQUEST['produtoForm_txtDescricao'];
			$produto->valor 		= $_REQUEST['produtoForm_txtValor'];
			$produto->quantidade 	= $_REQUEST['produtoForm_txtQuantidade'];
			$produto->dataAlteracao	= Uteis::dataAtual("Y/m/d H:i:s");
			
			$produtoManager = new ProdutoManager();
				
			$produtoManager->inserirProduto($produto);
				
		break;
		
		case 'EDITAR':
			
			$produto = new Produto();
			$produto->codigo		= $_REQUEST['produtoForm_codigoProduto'];
			$produto->codigoBarra 	= $_REQUEST['produtoForm_txtCodigoBarra']; 
			$produto->descricao 	= $_REQUEST['produtoForm_txtDescricao'];
			$produto->valor 		= $_REQUEST['produtoForm_txtValor'];
			$produto->quantidade 	= $_REQUEST['produtoForm_txtQuantidade'];
			$produto->dataAlteracao	= Uteis::dataAtual("Y/m/d H:i:s");
			
			$produtoManager = new ProdutoManager();
			
			$produtoManager->atualizarProduto($produto);
					
		break;
		
		case 'DELETAR':
			
			$produto = new Produto();
			$produto->codigo = $_REQUEST['codigoProduto'];
			
			$produtoManager = new ProdutoManager();
			$produtoManager->deletarProduto($produto);
			
		break;	
		
	}

	header("location: produto.list.php");

?>