<?php
	if (!isset($_SESSION)) {
		session_start();	
	}
	
	include("FormaPagamentoManager.php");
	include("PermissionManager.php");
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
			
			$("#confirmaDelete #linkConfirmaDelete").attr('href','FormaPagamentoController.php?managerOpcao=DELETAR&codigoFormaPagamento=' + codigo);
			
		}
		
	</script>	
</head> 
<body>
	
	<div data-role="page" data-title="Pagina Inicial" >
	
		<?php 
			$tituloPagina = "Formas de Pagamento";
			$urlPadrao = "forma.pagamento";
			include("system.topo.php");
		?>
		
		<!-- content --> 
		<div data-role="content" id="content" class="ui-body ui-body-b" data-inset="true">	
			
		<?php
			$formaPagamentoManager = new FormaPagamentoManager();
			$resultado = $formaPagamentoManager->recuperarTodos();
			
			if (mysql_num_rows($resultado) > 0) { ?>
			
			<ul data-role="listview" data-filter="true"  data-theme="c" data-inset="true">
				
			<?php
				while ($formaPagamento = mysql_fetch_object($resultado)) {
			?>	
					<li><a href="forma.pagamento.form.php?opcao=EDITAR&codigoFormaPagamento=<?=$formaPagamento->codigo;?>&<?=microtime();?>" data-transition="fade">
						<h3><?=$formaPagamento->descricao ;?></h3>
						</a>
						<a href="#confirmaDelete" onclick="deleteItem('<?=$formaPagamento->codigo;?>','<?=$formaPagamento->descricao;?>')" data-icon="delete" data-rel="dialog">Deletar</a>
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
			<h1>Deletar Forma de Pagamento?</h1>
			<p id="descricao"></p>
			<a href="#" data-role="button" data-rel="back" data-theme="b">Nao</a>       
			<a id="linkConfirmaDelete" href="" data-role="button" data-theme="c">Sim</a>    
		</div>
	</div>	
	
</body>
	
</html>