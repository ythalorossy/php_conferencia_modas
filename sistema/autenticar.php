<?php

	ini_set('register_globals', 'off');

	include("UsuarioManager.php");
	
	$usuarioResquest = new Usuario();
	$usuarioResquest->usuario = $_POST['txtLoginUsuario'];
	$usuarioResquest->senha = $_POST['txtLoginSenha'];;  
	
	$usuarioManager = new UsuarioManager();
	
	if ($usuarioManager->usuarioValido($usuarioResquest)) {
	
		$result = $usuarioManager->recuperarPorUsuarioSenha($usuarioResquest->usuario, $usuarioResquest->senha);

		$usuarioSessao = array();
		$usuarioSessao['codigo'] = $result->codigo;
		$usuarioSessao['nome'] = $result->nome; 
		$usuarioSessao['usuario'] = $result->usuario;
		$usuarioSessao['perfil'] = $result->perfil;

		session_start();
		session_cache_expire(60);
		
		if (PHP_VERSION >= 5.1) {
			session_regenerate_id(true);
		} else {
			session_regenerate_id();
		}
		
		$_SESSION['usuario'] = $usuarioSessao;
		
		session_register('usuario');
		
		header("location: system.home.php");

	} else {

		header("location: system.exit.php");
		
	}

?>

