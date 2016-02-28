<?php
	if (!isset($_SESSION)) {
		session_start();	
	}
	
	include("PedidoManager.php");
	include("PermissionManager.php");
	include("Uteis.php");
	PermissionManager::validarUsuarioAutenticado("usuario", "system.exit.php");
?>
<html> 
	<head> 
	<title>Listagem de Pedidos</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="css/jquery/mobile/jquery.mobile-1.1.0.css" />
	<script src="js/jquery/jquery-1.7.2.js"></script>
	<script src="js/jquery/mobile/jquery.mobile-1.1.0.js"></script>
	<script>
		$.mobile.ajaxEnabled=false;
	</script>
</head> 
<body>
	
	<div data-role="page" data-title="Pagina Inicial" >
	
		<?php 
			$tituloPagina = "Pedidos";
			$urlPadrao = "pedido";
			include("system.topo.php");
		?>
		
		<!-- content --> 
		<div data-role="content" id="content" class="ui-body ui-body-b" data-inset="true">	
		
		<?php
			$pedidoManager = new PedidoManager();
			$resultado = $pedidoManager->recuperarTodosObject(($_SESSION["usuario"]["perfil"]==PermissionManager::$ADMIN) ? NULL : $_SESSION["usuario"]["codigo"]);
			
			?>
			<ul data-role="listview" data-filter="true" data-theme="c" data-inset="false">
				
			<?php
			
				foreach ($resultado as $key => $pedido) {
					
					$valorTotal = 0.0; 
			?>	
				<li>
					<a href="pedido.form.php?opcao=EDITAR&codigoPedido=<?=$pedido->codigo;?>&<?=microtime();?>" data-transition="fade">
						<h3><?=Uteis::preencherEsquerda($pedido->codigo, "0", 10);?></h3>
						<p>Cliente: <?=$pedido->cliente->nome ;?></p>
						<p>Usuario: <?=$pedido->usuario->nome ;?> (<?=$pedido->usuario->usuario ;?>)</p>
						<p class="ui-li-aside"><strong><?=$pedido->data;?></strong></p>
					</a>
					<div data-role="collapsible" data-theme="c" data-content-theme="c">
						<h3>Produtos</h3>
						<?php
							foreach ($pedido->itens as $key => $item) {
								
								$valorPorItem = (float) ($item->quantidade * $item->produto->valor);
								
								$valorTotal = (float) $valorTotal + $valorPorItem;
						?>
							<p><?=$item->quantidade;?> - <? //Uteis::preencherEsquerda($item->produto->codigo, "0", 10);?> <?=$item->produto->descricao;?> - R$<?=number_format($valorPorItem, 2, ",", ".");?> </p>
						<?php
							}
						?>
						<p>Valor Total: <b>R$<?=number_format($valorTotal, 2, ",", ".");?></b></p>
					</div>
				</li>						
			<?php
				} 
			?>
			</ul>
			
		</div>
		
	</div>
	
</body>
	
</html>