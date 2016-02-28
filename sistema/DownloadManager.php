<?php

	include_once("GenericManager.php");
	include_once("PedidoManager.php");
	include_once("Uteis.php");

	class DownloadManager extends GenericManager {
		
		public static $CLIENTE = "CLIENTE";
		public static $PRODUTO = "PRODUTO";
		public static $PEDIDO = "PEDIDO";
		
		public function atualizarData($tipo) {
			
			$query = "UPDATE `$this->TBL_DOWNLOAD` SET data = '". Uteis::dataAtual("Y/m/d H:i:s") ."' WHERE tipo = '$tipo'";
			
			$this->executeQuery($query);
			
		}

		public function recuperarData($tipo) {
			
			$query = "SELECT * FROM $this->TBL_DOWNLOAD WHERE tipo= '$tipo'";
			
			$result = $this->executeQuery($query);
			
			$object = mysql_fetch_object($result);
			
			return $object->data;
		}
		
		
		public function recuperarTodosCliente() {
					
			$dataUltimoDownload = $this->recuperarData(DownloadManager::$CLIENTE);

			$query = "SELECT * FROM `$this->TBL_CLIENTES` WHERE data_alteracao > '$dataUltimoDownload' ORDER BY nome ASC;";
			
			return $this->executeQuery($query);
		}

		public function recuperarTodosProduto() {
					
			$dataUltimoDownload = $this->recuperarData(DownloadManager::$PRODUTO);

			$query = "SELECT * FROM `$this->TBL_PRODUTOS` WHERE data_alteracao > '$dataUltimoDownload' ORDER BY descricao ASC;";
			
			return $this->executeQuery($query);
		}

		public function recuperarTodosPedido() {

			$dataUltimoDownload = $this->recuperarData(DownloadManager::$PEDIDO);		

			$query = "SELECT * FROM `$this->TBL_PEDIDOS` WHERE data_alteracao > '$dataUltimoDownload' ORDER BY codigo ASC;";

			$result = $this->executeQuery($query);
						
			$pedidoManager = new PedidoManager();
			
			return $pedidoManager->carregarPedidos($result);
		}

		
	}

?>