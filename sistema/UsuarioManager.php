<?php

	require_once("GenericManager.php");

	class Usuario {
		public $codigo;	
		public $usuario;
		public $senha;
		public $perfil;
		public $nome;
		public $email;
		public $telefone;
		public $dataAlteracao;
	}

	class UsuarioManager extends GenericManager {
		
		public function usuarioValido(Usuario $usuario) {
			
			$query = "SELECT * FROM `$this->TBL_USUARIOS` WHERE usuario='%s' AND senha='%s'";
			
			$resultado = $this->query($query, $usuario->usuario, $usuario->senha);
			
			//$resultado = $this->executeQuery($query);
			
			if (mysql_num_rows($resultado) > 0) {
				return TRUE;			
			} 
			
			return FALSE;			
		}
		
		public function inserirUsuario(Usuario $usuario) {
					
			$query = "INSERT INTO `$this->TBL_USUARIOS` (
			`codigo`, 
			`usuario`, 
			`senha`, 
			`perfil`, 
			`nome`, 
			`email`, 
			`telefone`,
			`data_alteracao`) 
			VALUES (
			NULL, 
			'$usuario->usuario', 
			'$usuario->senha', 
			'$usuario->perfil', 
			'$usuario->nome', 
			'$usuario->email', 
			'$usuario->telefone',
			'$usuario->dataAlteracao'
			);";
			
			return $this->executeQuery($query);
		}
		
		public function atualizarUsuario(Usuario $usuario) {
			
			$query = "UPDATE `$this->TBL_USUARIOS`
						SET  
						usuario = '$usuario->usuario',
						senha = '$usuario->senha',
						nome = '$usuario->nome',
						email = '$usuario->email',
						telefone = '$usuario->telefone',
						perfil = '$usuario->perfil',
						data_alteracao = '$usuario->dataAlteracao' 
						WHERE codigo = $usuario->codigo;";
			
			return $this->executeQuery($query);			
		}	

		public function deletar(Usuario $usuario){
			
			$query = "DELETE FROM `$this->TBL_USUARIOS` WHERE codigo = '$usuario->codigo'";
			
			$this->executeQuery($query);
		}
		
		public function recuperarTodos() {
			
			$query = "SELECT * FROM `$this->TBL_USUARIOS` ORDER BY nome ASC;";
			
			return $this->executeQuery($query);	
		}
		
		public function recuperarPorCodigo($codigo) {
			$query = "SELECT * FROM usuarios WHERE codigo='$codigo';";
			return $this->executeQuery($query);
		}
		
		public function recuperarPorUsuarioSenha($nomeusuario, $senha) {
			
			$query = "SELECT * FROM usuarios WHERE usuario='%s' AND senha='%s'";

			$result = $this->query($query, $nomeusuario, $senha);
			
			//$result = $this->executeQuery($query);
			
			$usuario = mysql_fetch_object($result);
			
			return $usuario;
		}
	}

?>

