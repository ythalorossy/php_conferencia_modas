<?php
	if (!isset($_SESSION)) {
		session_start();	
	}
	
	include("ProdutoManager.php");
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
	</script>
	
</head> 
<body>
	
	<div data-role="page" data-title="Pagina Inicial" >
	
		<?php 
			$tituloPagina = "Produtos";
			$urlPadrao = "produto";
			include("system.topo.php");
		?>
		
		<div data-role="content" id="content" class="ui-body ui-body-b">	
			
			<form action="ProdutoController.php" method="post" data-ajax="false">
				
				<?php 
					$opcao = "CADASTRAR";
					
					if(isset($_REQUEST['opcao'])){
						
						$opcao = $_REQUEST['opcao'];
						
						if ($opcao == "EDITAR") {
							$produtoManager = new ProdutoManager();
							$resultado = $produtoManager->recuperarPorCodigo($_REQUEST['codigoProduto']);
							$produtoForm = mysql_fetch_object($resultado);
						}
					} 
				?>
				
				<input type="hidden" name="managerOpcao" id="managerOpcao" value="<?=$opcao; ?>"/>
				<input type="hidden" name="produtoForm_codigoProduto" id="produtoForm_codigoProduto" value="<?=@$produtoForm->codigo;?>"/>
	
				<input type="text" name="produtoForm_txtCodigoBarra" id="produtoForm_txtCodigoBarra" data-mini="false" placeholder="Codigo de barras" value="<?=@$produtoForm->codigo_barra;?>"/>
	
				<input type="text" name="produtoForm_txtDescricao" id="produtoForm_txtDescricao" data-mini="false" placeholder="Descricao" value="<?=@$produtoForm->descricao;?>"/>
				
				<input type="text" name="produtoForm_txtValor" id="produtoForm_txtValor" data-mini="false" placeholder="Valor" value="<?=@$produtoForm->valor;?>"/>
				
				<input type="text" name="produtoForm_txtQuantidade" id="produtoForm_txtQuantidade" data-mini="false" placeholder="Quantidade" value="<?=@$produtoForm->quantidade;?>"/>
				
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