<?php

	require_once("GenericManager.php");

	require_once("ProdutoManager.php");
	
	require_once("ClienteManager.php");
	
	require_once("UsuarioManager.php");

	class Pedido {

		public $codigo;
		public $codigoUsuario;
		public $usuario;
		public $codigoCliente;
		public $cliente;	
		public $codigoFormaPagamento;
		public $itens;
		public $data;
		public $dataAlteracao;
	}
	
	class ItemPedido {

		public $codigo;
		public $codigoPedido;
		public $codigoProduto;
		public $produto = array();
		public $quantidade;
	}

	class PedidoManager extends GenericManager {
		
		public function inserirPedido(Pedido $pedido) {
					
			$query = "INSERT INTO `$this->TBL_PEDIDOS` (
				codigo,
				codigo_usuario,
				codigo_cliente,
				codigo_forma_pag,
				data,
				data_alteracao) 
			VALUES (
			NULL, 
			'$pedido->codigoUsuario',
			'$pedido->codigoCliente',
			'$pedido->codigoFormaPagamento', 
			'$pedido->data',
			'$pedido->dataAlteracao');";
			
			$codigoPedido = 0;
			
			$resultInsertPedido = $this->executeQuery($query);
			
			if ($resultInsertPedido) {
				
				$codigoPedido = mysql_insert_id();
				
				if (!empty($pedido->itens)) {
				
					foreach ($pedido->itens as $key => $value) {
						
						$itemPedido = new ItemPedido();
						$itemPedido->codigoPedido = $codigoPedido;
						$itemPedido->codigoProduto = $value->codigoProduto;
						$itemPedido->quantidade = $value->quantidade;
						
						$this->inserirItens($itemPedido);
						
					}
					
				}
				
			}
			
			return $codigoPedido;
		}

		public function atualizarPedido(Pedido $pedido) {
			
			$queryPedidoUpdate = "UPDATE `$this->TBL_PEDIDOS`
					SET 
						`codigo_cliente` = '$pedido->codigoCliente', 
						`codigo_forma_pag` = '$pedido->codigoFormaPagamento',
						`data_alteracao` = '$pedido->dataAlteracao'
						WHERE `codigo` = $pedido->codigo";
						
			if($this->executeQuery($queryPedidoUpdate)){
				
				$queryItemDelete = "DELETE FROM `$this->TBL_PEDIDOS_ITENS` WHERE codigo_pedido=$pedido->codigo";
				
				print_r($queryItemDelete);
				
				if($this->executeQuery($queryItemDelete)){
					
					foreach ($pedido->itens as $key => $value) {
						
						$itemPedido = new ItemPedido();
						$itemPedido->codigoPedido = $pedido->codigo;
						$itemPedido->codigoProduto = $value->codigoProduto;
						$itemPedido->quantidade = $value->quantidade;
						
						$this->inserirItens($itemPedido);
						
					}					
					
				}
			}
						
		}
		
		public function inserirItens(ItemPedido $itemPedido) {
			
			$query = "INSERT INTO `$this->TBL_PEDIDOS_ITENS` (
				codigo,
				codigo_pedido,
				codigo_produto,
				quantidade) 
			VALUES (
			NULL,
			'$itemPedido->codigoPedido',
			'$itemPedido->codigoProduto',
			'$itemPedido->quantidade');";
			
			return $this->executeQuery($query);
		}

		public function recuperarPorCodigoObject($codigo) {
				
			$query = "select * from `$this->TBL_PEDIDOS` where codigo = $codigo";
			
			$result = $this->executeQuery($query);
			
			$pedido = mysql_fetch_object($result);

			$p = new Pedido();
			$p->codigo = $pedido->codigo;
			$p->codigoCliente = $pedido->codigo_cliente;
			$p->codigoUsuario = $pedido->codigo_usuario;
			$p->data = $pedido->data;
			$p->codigoFormaPagamento = $pedido->codigo_forma_pag;
			$p->itens = $this->recuperarItensByPedido($p);

			return $p;				
		}
		
		public function recuperarTodosObject($codigoUsuario) {
				
			if (is_null($codigoUsuario)) {
			
				$query = "SELECT * FROM $this->TBL_PEDIDOS";
				
			} else {
					
				$query = "SELECT * FROM $this->TBL_PEDIDOS WHERE codigo_usuario='$codigoUsuario'";
			}	
			
			$result = $this->executeQuery($query);
			
			return $this->carregarPedidos($result);
		}

		public function carregarPedidos($result) {

			$retorno = array();
			
			while ($pedido = mysql_fetch_object($result)) {
				$p = new Pedido();
				$p->codigo = $pedido->codigo;
				$p->codigoCliente = $pedido->codigo_cliente;
				
				$clienteManager = new ClienteManager();
				$p->cliente = mysql_fetch_object($clienteManager->recuperarPorCodigo($pedido->codigo_cliente));
				
				$p->codigoUsuario = $pedido->codigo_usuario;
				
				$usuarioManager = new UsuarioManager();
				$p->usuario = mysql_fetch_object($usuarioManager->recuperarPorCodigo($pedido->codigo_usuario));
				
				$p->data = $pedido->data;
				$p->codigoFormaPagamento = $pedido->codigo_forma_pag;
				$p->itens = $this->recuperarItensByPedido($p);
				
				$retorno[] = $p;
			}
			
			return $retorno;
		}


		public function recuperarItensByPedido(Pedido $pedido) {
					
			$retorno = array();
			
			$query = "select * from pedido_itens where codigo_pedido=$pedido->codigo";
			
			$result = $this->executeQuery($query);
			
			while ($item = mysql_fetch_object($result)) {
				
				$it = new ItemPedido();
				$it->codigo = $item->codigo;
				$it->codigoPedido = $item->codigo_pedido;
				$it->codigoProduto = $item->codigo_produto;
				$it->quantidade = $item->quantidade;
				
				$produtoManager = new ProdutoManager();
				$resultProduto = $produtoManager->recuperarPorCodigo($item->codigo_produto);
				$produto = mysql_fetch_object($resultProduto);
						
				$it->produto = $produto;

				$retorno[] = $it;				
			}
			
			return $retorno;
		}
	}
?>
