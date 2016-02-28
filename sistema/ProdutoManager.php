<?php

	require_once("GenericManager.php");

	class Produto {

		public $codigo;	
		public $codigoBarra;
		public $descricao;
		public $valor;
		public $quantidade;
		public $dataAlteracao;
	}

	class ProdutoManager extends GenericManager {
		
		public function inserirProduto(Produto $produto) {
					
			$query = "INSERT INTO `$this->TBL_PRODUTOS` (
				codigo,
				codigo_barra,
				descricao,
				valor,
				quantidade,
				data_alteracao) 
			VALUES (
			NULL, 
			'$produto->codigoBarra', 
			'$produto->descricao', 
			'$produto->valor', 
			'$produto->quantidade',
			'$produto->dataAlteracao');";
			
			return $this->executeQuery($query);
		}
		
		public function atualizarProduto(Produto $produto) {
			
			$query = "UPDATE `$this->TBL_PRODUTOS` 
						SET  
						codigo_barra = '$produto->codigoBarra',
						descricao = '$produto->descricao',
						valor = '$produto->valor',
						quantidade = '$produto->quantidade',
						data_alteracao = '$produto->dataAlteracao'
						WHERE codigo = '$produto->codigo';";
						
			return $this->executeQuery($query);			
		}	
		
		
		public function recuperarTodos() {
			
			$query = "SELECT * FROM `$this->TBL_PRODUTOS` ORDER BY descricao ASC;";
			
			return $this->executeQuery($query);	
		}
		
		public function recuperarPorCodigo($codigo) {
			
			$query = "SELECT * FROM `$this->TBL_PRODUTOS` WHERE codigo='$codigo';";
			
			return $this->executeQuery($query);
		}
		
		public function deletarProduto(Produto $produto) {
				
			$query = "DELETE FROM `$this->TBL_PRODUTOS` WHERE codigo='$produto->codigo';";
			
			return $this->executeQuery($query);
		}
		
	}

?>
