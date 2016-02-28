<?php

	require_once("GenericManager.php");

	class Cliente {
		
		public $codigo;	
		public $codigoUsuario;
		public $nome;
		public $email;
		public $endereco;
		public $cidade;
		public $cep;
		public $estado;
		public $pais;
		public $telefone;
		public $celular;
		public $funcao;
		public $observacao;
		public $dataAlteracao;
	}

	class ClienteManager extends GenericManager {
		
		public function inserirCliente(Cliente $cliente) {
					
			$query = "INSERT INTO `$this->TBL_CLIENTES` (
				codigo,
				nome,
				email,
				endereco,
				cidade,
				cep,
				estado,
				pais,
				telefone,
				celular,
				funcao,
				observacao,
				data_alteracao,
				codigo_usuario) 
			VALUES (
			NULL, 
			'$cliente->nome', 
			'$cliente->email', 
			'$cliente->endereco', 
			'$cliente->cidade', 
			'$cliente->cep', 
			'$cliente->estado',
			'$cliente->pais',
			'$cliente->telefone',
			'$cliente->celular',
			'$cliente->funcao',
			'$cliente->observacao',	
			'$cliente->dataAlteracao',
			'$cliente->codigoUsuario');";
			
			return $this->executeQuery($query);
		}
		
		public function atualizarCliente(Cliente $cliente) {
			
			$query = "UPDATE `$this->TBL_CLIENTES` 
						SET  
						nome = '$cliente->nome',
						email = '$cliente->email',
						endereco = '$cliente->endereco',
						cidade = '$cliente->cidade',
						cep = '$cliente->cep',
						estado = '$cliente->estado',
						pais = '$cliente->pais',
						telefone = '$cliente->telefone',
						celular = '$cliente->celular',
						funcao = '$cliente->funcao',
						observacao = '$cliente->observacao',
						data_alteracao = '$cliente->dataAlteracao'
						WHERE codigo = $cliente->codigo;";
						
			return $this->executeQuery($query);			
		}
		
		public function deletar(Cliente $cliente) {
			$query = "DELETE FROM `$this->TBL_CLIENTES` WHERE codigo='$cliente->codigo'";

			$this->executeQuery($query);
		}
		
		public function recuperarTodos($codigoUsuario) {
			
			if (is_null($codigoUsuario)) {
				
				$query = "SELECT * FROM `$this->TBL_CLIENTES` ORDER BY nome ASC;";
			
			} else {
				
				$query = "SELECT * FROM `$this->TBL_CLIENTES` WHERE codigo_usuario='$codigoUsuario' ORDER BY nome ASC;";
				
			}
			
			return $this->executeQuery($query);	
		}
		
		public function recuperarPorCodigo($codigo) {
			
			$query = "SELECT * FROM `$this->TBL_CLIENTES` WHERE codigo='$codigo';";
			
			return $this->executeQuery($query);
		}
	}

?>

