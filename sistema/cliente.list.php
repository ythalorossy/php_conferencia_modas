<?php
	if (!isset($_SESSION)) {
		session_start();	
	}
	include_once("ClienteManager.php");
	include_once("PermissionManager.php");
	include_once("UsuarioManager.php");
	include_once("Uteis.php");
	
	PermissionManager::validarUsuarioAutenticado("usuario", "system.exit.php");
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
			
			$("#confirmaDelete #descricao").text("");
			
			$("#confirmaDelete #descricao").text(descricao);
			
			$("#confirmaDelete #linkConfirmaDelete").attr('href','ClienteController.php?managerOpcao=DELETAR&codigoCliente=' + codigo);
			
		}
		
	</script>	
</head> 
<body>
	
	<div data-role="page" data-title="Pagina Inicial" >
	
		<?php 
			$tituloPagina = "Clientes";
			$urlPadrao = "cliente";
			include("system.topo.php");
		?>
		
		<!-- content --> 
		<div data-role="content" id="content" class="ui-body ui-body-b" data-inset="true">	
			
		<?php
			$clienteManager = new ClienteManager();
			$resultado = $clienteManager->recuperarTodos(($_SESSION["usuario"]["perfil"]==PermissionManager::$ADMIN) ? NULL : $_SESSION["usuario"]["codigo"]);
			
			if (mysql_num_rows($resultado) > 0) { ?>
			
			<ul data-role="listview" data-filter="true"  data-theme="c" data-inset="true">
				
			<?php
				
				$usuarioManager = new UsuarioManager();
			
				while ($cliente = mysql_fetch_object($resultado)) {
					
					$resultCliente = $usuarioManager->recuperarPorCodigo($cliente->codigo_usuario);
					$usuarioCliente = mysql_fetch_object($resultCliente); 
			?>	
					<li>
						<a href="cliente.form.php?opcao=EDITAR&codigoCliente=<?=$cliente->codigo;?>&<?=microtime();?>" data-transition="fade">
							<h3><?=$cliente->nome ;?></h3>
							<p>e-mail: <?=$cliente->email ;?></p>
							<p>telefone: <?=$cliente->telefone ;?></p>
							<p>cadastrado por: <?=$usuarioCliente->nome ;?> (<?=$usuarioCliente->usuario;?>)</p>
						</a>
						<a <?=Uteis::showHideElement($_SESSION["usuario"]["perfil"], PermissionManager::$ADMIN);?> href="#confirmaDelete" onclick="deleteItem('<?=$cliente->codigo;?>','<?=$cliente->nome;?>')" data-icon="delete" data-rel="dialog">Deletar</a>
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
			<h1>Deletar Cliente?</h1>
			<p id="descricao"></p>
			<a href="#" data-role="button" data-rel="back" data-theme="b">Nao</a>       
			<a id="linkConfirmaDelete" href="" data-role="button" data-theme="c">Sim</a>    
		</div>
	</div>
	
</body>
	
</html>