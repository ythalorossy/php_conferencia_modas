<?php

	require_once("UsuarioManager.php");
	require_once("Uteis.php");

	$managerOpcao = isset($_REQUEST['managerOpcao']) ? $_REQUEST['managerOpcao'] : "";
	
	switch ($managerOpcao) {
		
		case 'CADASTRAR':
			
			$usuario = new Usuario();
			$usuario->usuario 	= $_REQUEST['usuarioForm_txtUsuario'];
			$usuario->senha  	= $_REQUEST['usuarioForm_txtSenha'];
			$usuario->perfil 	= $_REQUEST['usuarioForm_selectPerfil'];
			$usuario->nome 		= $_REQUEST['usuarioForm_txtNome'];
			$usuario->email 	= $_REQUEST['usuarioForm_txtEmail'];
			$usuario->telefone 	= $_REQUEST['usuarioForm_txtTelefone'];
			$usuario->dataAlteracao	= Uteis::dataAtual("Y/m/d H:i:s");
			
			$usuarioManager = new UsuarioManager();
				
			$usuarioManager->inserirUsuario($usuario);
			
		break;
		
		case 'EDITAR':
			
			$usuario = new Usuario();
			$usuario->codigo 	= $_REQUEST['usuarioForm_codigoUsuario'];
			$usuario->usuario 	= $_REQUEST['usuarioForm_txtUsuario'];
			$usuario->senha  	= $_REQUEST['usuarioForm_txtSenha'];
			$usuario->perfil 	= $_REQUEST['usuarioForm_selectPerfil'];
			$usuario->nome 		= $_REQUEST['usuarioForm_txtNome'];
			$usuario->email 	= $_REQUEST['usuarioForm_txtEmail'];
			$usuario->telefone 	= $_REQUEST['usuarioForm_txtTelefone'];
			$usuario->dataAlteracao	= Uteis::dataAtual("Y/m/d H:i:s");
			
			$usuarioManager = new UsuarioManager();
			$usuarioManager->atualizarUsuario($usuario);
			
		break;
		
		case 'DELETAR':
			
			$usuario = new Usuario();
			$usuario->codigo 	= $_REQUEST['codigoUsuario'];
			
			$usuarioManager = new UsuarioManager();
			$usuarioManager->deletar($usuario);
			
		break;	
	}

	header("location: usuario.list.php");

?>