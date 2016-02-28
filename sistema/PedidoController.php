<?php
	require_once("ProdutoManager.php");
	require_once("PedidoManager.php");
	require_once("Uteis.php");
	
	$managerOpcao = isset($_REQUEST['managerOpcao']) ? $_REQUEST['managerOpcao'] : "";
	
	switch ($managerOpcao) {
		
		case 'CADASTRAR':
			
			$codigoCliente = $_REQUEST['pedidoForm_selectCliente'];
			$codigoFormaPagamento = $_REQUEST['pedidoForm_selectFormaPagamento'];
			
			$checkItemProduto = $_REQUEST['pedidoForm_checkItemProduto'];
			$textItemProduto = $_REQUEST['pedidoForm_textItemProduto'];
			
			$pedido = new Pedido();
			$pedido->codigoCliente = $codigoCliente;
			$pedido->codigoFormaPagamento = $codigoFormaPagamento;
			$pedido->codigoUsuario = $_REQUEST['pedidoForm_codigoUsuario'];;
			$pedido->data = date("Y-m-d H:i:s");
			$pedido->dataAlteracao = Uteis::dataAtual("Y/m/d H:i:s");
			
			foreach ($checkItemProduto as $codigoProduto => $value) {
				
				$itemPedido = new ItemPedido();
				$itemPedido->codigoProduto = $codigoProduto;
				$itemPedido->quantidade = $textItemProduto[$codigoProduto];

				$pedido->itens[] = $itemPedido;
			}

			$pedidoManager = new PedidoManager();
			$codigoPedido = $pedidoManager->inserirPedido($pedido);
			
		break;
		
		case 'EDITAR':
			
			$codigoCliente = $_REQUEST['pedidoForm_selectCliente'];
			$codigoFormaPagamento = $_REQUEST['pedidoForm_selectFormaPagamento'];
			
			$checkItemProduto = $_REQUEST['pedidoForm_checkItemProduto'];
			$textItemProduto = $_REQUEST['pedidoForm_textItemProduto'];
			
			$pedido = new Pedido();
			$pedido->codigo = $_REQUEST['pedidoForm_codigoPedido'];
			$pedido->codigoCliente = $codigoCliente;
			$pedido->codigoFormaPagamento = $codigoFormaPagamento;
			$pedido->dataAlteracao = Uteis::dataAtual("Y/m/d H:i:s");
			
			foreach ($checkItemProduto as $codigoProduto => $value) {
				
				$itemPedido = new ItemPedido();
				$itemPedido->codigoProduto = $codigoProduto;
				$itemPedido->quantidade = $textItemProduto[$codigoProduto];

				$pedido->itens[] = $itemPedido;
			}			
			
			$pedidoManager = new PedidoManager();
			$codigoPedido = $pedidoManager->atualizarPedido($pedido);
			
		break;
		
	}

	header("location: pedido.list.php");

?>
