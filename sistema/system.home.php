<?php
	if (!isset($_SESSION)) {
		session_start();	
	}
	include("UsuarioManager.php");
	include("PermissionManager.php");
	
	PermissionManager::validarUsuarioAutenticado("usuario", "system.exit.php");
?>

<!DOCTYPE html> 
<html> 
	<head> 
	<title>Conferencia Modas</title>
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="css/jquery/mobile/jquery.mobile-1.1.0.css" />
	<link rel="stylesheet" href="css/jquery/mobile/jqm-docs.css"/>

	<script src="js/jquery/jquery-1.7.2.js"></script>
	<script src="js/jquery/mobile/jqm-docs.js"></script>
	<script src="js/jquery/mobile/jquery.mobile-1.1.0.js"></script>
	<script>
		$.mobile.ajaxEnabled=false;
	</script>	
</head> 
<body> 

<div data-role="page" id="paginaInicial" data-title="Pagina Inicial">

	<div data-role="header" data-position="fixed" data-theme="b">
		<h1>Conferencia Modas</h1>
		<a href="system.exit.php?<?=microtime()?>" data-iconpos="text">Sair</a>
	</div>

	<div data-role="content" class="ui-body ui-body-b">
		<div data-role="collapsible" data-collapsed="true" data-theme="c" data-content-theme="c">
			<h3>Pedidos</h3>
			<p style="color: green"><strong>Concluido - aguardando homologacao</strong></p>
			<ul data-role="listview" data-inset="true">
				<li><a href="pedido.form.php?<?=microtime()?>" data-rel="external">Efetuar Pedido</a></li>
				<li><a href="pedido.list.php?<?=microtime()?>">Listagem</a></li>
			</ul>			
		</div>
		<div data-role="collapsible" data-collapsed="true" data-theme="c" data-content-theme="c">
			<h3>Produtos</h3>
			<p style="color: green"><strong>Concluido - aguardando homologacao</strong></p>
			<ul data-role="listview" data-inset="true">
				<li><a href="produto.form.php?<?=microtime()?>" date_rel="external">Cadastrar</a></li>
				<li><a href="produto.list.php?<?=microtime()?>" date_rel="external">Listagem</a></li>
			</ul>			
		</div>
		<div data-role="collapsible" data-collapsed="true" data-theme="c" data-content-theme="c">
			<h3>Clientes</h3>
			<p style="color: green"><strong>Concluido - aguardando homologacao</strong></p>
			<ul data-role="listview" data-inset="true">
				<li><a href="cliente.form.php?<?=microtime()?>" date_rel="external">Cadastrar</a></li>
				<li><a href="cliente.list.php?<?=microtime()?>" date_rel="external">Listagem</a></li>
			</ul>			
		</div>		
		<div data-role="collapsible" data-collapsed="true" data-theme="c" data-content-theme="c"
		<?= @($_SESSION['usuario']['perfil'] == PermissionManager::$ADMIN)? '' : 'style="display:none"';?>>
			<h3>Formas de Pagamento</h3>
			<p style="color: green"><strong>Concluido - aguardando homologacao</strong></p>
			<ul data-role="listview" data-inset="true">
				<li><a href="forma.pagamento.form.php?<?=microtime()?>" date_rel="external">Cadastrar</a></li>
				<li><a href="forma.pagamento.list.php?<?=microtime()?>" date_rel="external">Listagem</a></li>
			</ul>			
		</div>	
		<div data-role="collapsible" data-collapsed="true" data-theme="c" data-content-theme="c" 
		<?= @($_SESSION['usuario']['perfil'] == PermissionManager::$ADMIN)? '' : 'style="display:none"';?>>
			<h3>Usuarios</h3>
			<p style="color: green"><strong>Concluido - aguardando homologacao</strong></p>
			<ul data-role="listview" data-inset="true">
					<li><a href="usuario.form.php?<?=microtime()?>" date_rel="external">Cadastrar</a></li>
					<li><a href="usuario.list.php?<?=microtime()?>" date_rel="external">Listagem</a></li>
			</ul>			
		</div>			
		<div data-role="collapsible" data-collapsed="true" data-theme="c" data-content-theme="c" 
		<?= @($_SESSION['usuario']['perfil'] == PermissionManager::$ADMIN)? '' : 'style="display:none"';?>>
			<h3>Exportacao de dados</h3>
			<p style="color: green"><strong>Concluido - aguardando homologacao</strong></p>
			<ul data-role="listview" data-inset="true">
					<li><a href="cliente.download.php?<?=microtime()?>" target="_blank">Clientes</a></li>
					<li><a href="produto.download.php?<?=microtime()?>" target="_blank" >Produtos</a></li>
					<li><a href="pedido.download.php?<?=microtime()?>" target="_blank" >Pedidos</a></li>
			</ul>			
		</div>		
	</div>

</div>

</body>
</html>