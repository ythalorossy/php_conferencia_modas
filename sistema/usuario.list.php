<?php
	if (!isset($_SESSION)) {
		session_start();	
	}

	include("UsuarioManager.php");
	include("PermissionManager.php");
	
	$usuarioSessao = $_SESSION['usuario'];

	PermissionManager::validarUsuarioAutenticado("usuario", "system.exit.php");
	
	PermissionManager::validarPermissaoAcessoPagina($_SESSION['usuario']['perfil'], PermissionManager::$ADMIN, 'system.home.php');
?>

<!DOCTYPE html> 
<html> 
	<head> 
	<title>Conferencia</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="css/jquery/mobile/jquery.mobile-1.1.0.css" />
	<script src="js/jquery/jquery-1.7.2.js"></script>
	<script src="js/jquery/mobile/jquery.mobile-1.1.0.js"></script>
	<script>
		$.mobile.ajaxEnabled=true;
		
		function deleteItem(codigo, descricao) {
			
			$("#confirmaDelete #descricao").text("").text(descricao);
			
			$("#confirmaDelete #linkConfirmaDelete").attr('href','UsuarioController.php?managerOpcao=DELETAR&codigoUsuario=' + codigo);
			
		}
				
	</script>	
</head> 
<body>
	<div data-role="page" data-title="Pagina Inicial" >
	
		<?php 
			$tituloPagina = "Usuarios";
			$urlPadrao = "usuario";
			include("system.topo.php");
		?>
		
		<!-- content --> 
		<div data-role="content" id="content" class="ui-body ui-body-b" data-inset="true">	
			
		<?php
			$usuarioManager = new UsuarioManager();
			$resultado = $usuarioManager->recuperarTodos();
			
			if (mysql_num_rows($resultado) > 0) {
		?>
			
			<ul data-role="listview" data-filter="true"  data-theme="c" data-inset="true">
			<?php
				while ($usuarioDB = mysql_fetch_object($resultado)) {
			?>	
				<li><a href="usuario.form.php?opcao=EDITAR&codigoUsuario=<?=$usuarioDB->codigo;?>&<?=microtime()?>">
					<h3><?=$usuarioDB->nome ;?></h3>
					<p>e-mail: <?=$usuarioDB->email ;?></p>
					<p>telefone: <?=$usuarioDB->telefone ;?></p>
					<p>usuario: <?=$usuarioDB->usuario ;?> perfil: <?=$usuarioDB->perfil;?></p>
					</a>
					<a href="#confirmaDelete" onclick="deleteItem('<?=$usuarioDB->codigo;?>','<?=$usuarioDB->nome;?>')" data-icon="delete" data-rel="dialog">Deletar</a>					
				</li>						
			<?php
				} 
			?>
			</ul>	
			<?php				
			}
			?>
			
		</div>
		
	</div>

	<div data-role="dialog" id="confirmaDelete">
		<div data-role="content" data-theme="c">
			<h1>Deletar Usuario?</h1>
			<p id="descricao"></p>
			<a href="#" data-role="button" data-rel="back" data-theme="b">Nao</a>       
			<a id="linkConfirmaDelete" href="" data-role="button" data-theme="c">Sim</a>    
		</div>
	</div>	
	
</body>
	
</html>