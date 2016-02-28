<?php
	if (!isset($_SESSION)) {
		session_start();	
	}

	include("UsuarioManager.php");
	include("PermissionManager.php");
	
	$usuarioSessao = $_SESSION['usuario'];

	PermissionManager::validarUsuarioAutenticado("usuario", "system.exit.php");
	
	PermissionManager::validarPermissaoAcessoPagina($usuarioSessao['perfil'], PermissionManager::$ADMIN, 'system.home.php');
?>

<html> 
	<head> 
	<title>Conferencia</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="css/jquery/mobile/jquery.mobile-1.1.0.css" />
	<script src="js/jquery/jquery-1.7.2.js"></script>
	<script src="js/jquery/mobile/jquery.mobile-1.1.0.js"></script>
	<script>
		$.mobile.ajaxEnabled=true;
	</script>	
</head> 
<body>
	
	<div data-role="page" data-title="Pagina Inicial" >
	
		<?php 
			$tituloPagina = "Usuarios";
			$urlPadrao = "usuario";
			include("system.topo.php");
		?>
		
		<div data-role="content" id="content" class="ui-body ui-body-b">	
			
			<form action="UsuarioController.php" method="post" data-ajax="false">
				
				<?php 
					$opcao = "CADASTRAR";
					
					if(isset($_REQUEST['opcao'])){
						
						$opcao = $_REQUEST['opcao'];
						
						if ($opcao == "EDITAR") {
							$usuarioManager = new UsuarioManager();
							$resultado = $usuarioManager->recuperarPorCodigo($_REQUEST['codigoUsuario']);
							$usuarioForm = mysql_fetch_object($resultado);
						}
					} 
				?>
				
				<input type="hidden" name="managerOpcao" id="managerOpcao" value="<?=$opcao; ?>"/>
				<input type="hidden" name="usuarioForm_codigoUsuario" id="usuarioForm_codigoUsuario" value="<?=@$usuarioForm->codigo;?>"/>
	
				<input type="text" name="usuarioForm_txtUsuario" id="usuarioForm_txtUsuario" data-mini="false" placeholder="Usuario" value="<?=@$usuarioForm->usuario;?>"/>
	
				<input type="password" name="usuarioForm_txtSenha" id="usuarioForm_txtSenha" data-mini="false" placeholder="Senha" value="<?=@$usuarioForm->senha;?>"/>
				
				<input type="text" name="usuarioForm_txtNome" id="usuarioForm_txtNome" data-mini="false" placeholder="Nome" value="<?=@$usuarioForm->nome;?>"/>
				
				<input type="text" name="usuarioForm_txtEmail" id="usuarioForm_txtEmail" data-mini="false" placeholder="Email" value="<?=@$usuarioForm->email;?>"/>
				
				<input type="text" name="usuarioForm_txtTelefone" id="usuarioForm_txtTelefone" data-mini="false" placeholder="Telefone" value="<?=@$usuarioForm->telefone;?>"/>
			
					<select name="usuarioForm_selectPerfil" id="usuarioForm_selectPerfil" data-role="slider" data-mini="false">
						<option value="<?=PermissionManager::$ADMIN;?>" <?=(@$usuarioForm->perfil==PermissionManager::$ADMIN)?"selected":""; ?>>Admin</option>
						<option value="<?=PermissionManager::$USER;?>" <?=(@$usuarioForm->perfil==PermissionManager::$USER)?"selected":""; ?>>User</option>
					</select>
			
				<fieldset class="ui-grid-a">
					
					<div class="ui-block-a">
						<button type="submit" id="btnCadastrar" data-theme="b">Salvar</button>
					</div>
	
		    	</fieldset>
	
			</form>
			
		</div>
		
	</div>
	
</body>
	
</html>