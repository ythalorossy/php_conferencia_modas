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
		$.mobile.ajaxEnabled=true
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
		<div data-role="content" id="content" class="ui-body ui-body-b">	
			
			<form action="FormaPagamentoController.php" method="post" data-ajax="false">
				
				<?php 
					$opcao = "CADASTRAR";
					
					if(isset($_REQUEST['opcao'])){
						
						$opcao = $_REQUEST['opcao'];
						
						if ($opcao == "EDITAR") {
							$formaPagamentoManager = new FormaPagamentoManager();
							$resultado = $formaPagamentoManager->recuperarPorCodigo($_REQUEST['codigoFormaPagamento']);
							$formaPagamentoForm = mysql_fetch_object($resultado);
						}
					} 
				?>
				
				<input type="hidden" name="managerOpcao" id="managerOpcao" value="<?=$opcao; ?>"/>
				<input type="hidden" name="formaPagamentoForm_codigoFormaPagamento" id="formaPagamentoForm_codigoFormaPagamento" value="<?=@$formaPagamentoForm->codigo;?>"/>
	
				<input type="text" name="formaPagamentoForm_txtDescricao" id="formaPagamentoForm_txtDescricao" data-mini="false" placeholder="Descricao" value="<?=@$formaPagamentoForm->descricao;?>"/>

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