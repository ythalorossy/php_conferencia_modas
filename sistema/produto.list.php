<?php
	if (!isset($_SESSION)) {
		session_start();	
	}
	
	include("ProdutoManager.php");
	include("PermissionManager.php");
	include_once("Uteis.php");
	PermissionManager::validarUsuarioAutenticado("usuario", "system.exit.php");
?>
<!DOCTYPE html> 
<html> 
	<head> 
	<title>Listagem de Produtos</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="css/jquery/mobile/jquery.mobile-1.1.0.css" />
	<script src="js/jquery/jquery-1.7.2.js"></script>
	<script src="js/jquery/mobile/jquery.mobile-1.1.0.js"></script>
	<script>
		$.mobile.ajaxEnabled=true;
		
		function deleteItem(codigo, descricao) {
			
			$("#confirmaDelete #descricao").text("");
			
			$("#confirmaDelete #descricao").text(descricao);
			
			$("#confirmaDelete #linkConfirmaDelete").attr('href','ProdutoController.php?managerOpcao=DELETAR&codigoProduto=' + codigo);
			
		}
		
	</script>
</head> 
<body>
	
	<div data-role="page" data-title="Pagina Inicial" >
	
		<?php 
			$tituloPagina = "Produtos";
			$urlPadrao = "produto";
			include("system.topo.php");
		?>
		
		<!-- content --> 
		<div data-role="content" id="content" class="ui-body ui-body-b" data-inset="true">	
			
		<?php
			$produtoManager = new ProdutoManager();
			$resultado = $produtoManager->recuperarTodos();
			
			if (mysql_num_rows($resultado) > 0) { ?>
			
			<ul data-role="listview" data-filter="true" data-theme="c" data-inset="true">
				
			<?php
				while ($produto = mysql_fetch_object($resultado)) {
			?>	
					<li>
						<a href="produto.form.php?opcao=EDITAR&codigoProduto=<?=$produto->codigo;?>&<?=microtime();?>" data-transition="fade">
							<h3><?=$produto->descricao;?></h3>
							<p>Codigo de barras: <?=$produto->codigo_barra;?></p>
							<p>Valor: <?=$produto->valor ;?></p>
							<p>Quantidade: <?=$produto->quantidade ;?></p>
						</a>
						<a <?=Uteis::showHideElement($_SESSION["usuario"]["perfil"], PermissionManager::$ADMIN);?> href="#confirmaDelete" onclick="deleteItem('<?=$produto->codigo;?>','<?=$produto->descricao;?>')" data-icon="delete" data-rel="dialog">Deletar</a>
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
			<h1>Deletar Produto?</h1>
			<p id="descricao"></p>
			<a href="#" data-role="button" data-rel="back" data-theme="b">Nao</a>       
			<a id="linkConfirmaDelete" href="" data-role="button" data-theme="c">Sim</a>    
		</div>
	</div>	
	
</body>
	
</html>