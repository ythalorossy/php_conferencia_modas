<?php

	require_once("GenericManager.php");

	class FormaPagamento {

		public $codigo;	
		public $descricao;
		public $dataAlteracao;
	}

	class FormaPagamentoManager extends GenericManager {
		
		public function inserirFormaPagamento(FormaPagamento $formaPagamento) {
					
			$query = "INSERT INTO `$this->TBL_FORMA_PAGAMENTO` (
				codigo,
				descricao, 
				data_alteracao) 
			VALUES (
			NULL, 
			'$formaPagamento->descricao',
			'$formaPagamento->dataAlteracao');";
			
			return $this->executeQuery($query);
		}
		
		public function atualizarFormaPagamento(FormaPagamento $formaPagamento) {
			
			$query = "UPDATE `$this->TBL_FORMA_PAGAMENTO` 
						SET  
						descricao = '$formaPagamento->descricao',
						data_alteracao = '$formaPagamento->dataAlteracao'
						WHERE codigo = $formaPagamento->codigo;";
						
			return $this->executeQuery($query);			
		}	
		
		
		public function recuperarTodos() {
			
			$query = "SELECT * FROM `$this->TBL_FORMA_PAGAMENTO` ORDER BY descricao ASC;";
			
			return $this->executeQuery($query);	
		}
		
		public function recuperarPorCodigo($codigo) {
			
			$query = "SELECT * FROM `$this->TBL_FORMA_PAGAMENTO` WHERE codigo='$codigo';";
			
			return $this->executeQuery($query);
		}
	}

?>
