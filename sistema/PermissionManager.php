<?php

	require_once("UsuarioManager.php");

	class PermissionManager {

		public static $ADMIN	= "ADMIN";
		public static $USER		= "USER";

		public static function validarUsuarioAutenticado($nomeVariavel, $paginaError) {
			
			if (empty($_SESSION[$nomeVariavel])) {

				header("location: $paginaError");
			}
		}

		public static function validarPermissaoAcessoPagina($permissaoUsuario, $permissaoNecessaria, $paginaError) {
			
			if ($permissaoUsuario == $permissaoNecessaria) {

				return TRUE;	
			}
			
			die("sem permissao de acesso: $usuario->perfil != $permissao");
			
			header("location: $paginaError");
		}
		
				
	}
?>