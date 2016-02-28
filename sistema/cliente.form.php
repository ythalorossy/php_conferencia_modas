<?php
	if (!isset($_SESSION)) {
		session_start();	
	}
	include("ClienteManager.php");
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
			$tituloPagina = "Clientes";
			$urlPadrao = "cliente";
			include("system.topo.php");
		?>
	
		<!-- content --> 
		<div data-role="content" id="content" class="ui-body ui-body-b">	
			
			<form action="ClienteController.php" method="post" data-ajax="false" >
				
				<?php
					$opcao = "CADASTRAR";
					
					if(isset($_REQUEST['opcao'])){
						
						$opcao = $_REQUEST['opcao'];
						
						if ($opcao == "EDITAR") {
							$clienteManager = new ClienteManager();
							$resultado = $clienteManager->recuperarPorCodigo($_REQUEST['codigoCliente']);
							$clienteForm = mysql_fetch_object($resultado);
						}
					} 
				?>
				
				<input type="hidden" name="managerOpcao" id="managerOpcao" value="<?=$opcao; ?>"/>
				<input type="hidden" name="clienteForm_codigoCliente" id="clienteForm_codigoCliente" value="<?=@$clienteForm->codigo;?>"/>
				<input type="hidden" name="clienteForm_codigoUsuario" id="clienteForm_codigoUsuario" value="<?=@$_SESSION["usuario"]["codigo"];?>"/>
	
				<input type="text" name="clienteForm_txtNome" id="clienteForm_txtNome" data-mini="false" placeholder="Nome" value="<?=@$clienteForm->nome;?>"/>
				
				<input type="email" name="clienteForm_txtEmail" id="clienteForm_txtEmail" data-mini="false" placeholder="Email" value="<?=@$clienteForm->email;?>"/>
				
				<input type="text" name="clienteForm_txtEndereco" id="clienteForm_txtEndereco" data-mini="false" placeholder="Endereco" value="<?=@$clienteForm->endereco;?>"/>
				
				<div class="ui-grid-b">
					
					<div class="ui-block-a">
				
						<input type="text" name="clienteForm_txtCidade" id="clienteForm_txtCidade" data-mini="false" placeholder="Cidade" value="<?=@$clienteForm->cidade;?>"/>
					</div>
					
					<div class="ui-block-b" >
						<input type="text" name="clienteForm_txtCep" id="clienteForm_txtCep" data-mini="false" placeholder="CEP" value="<?=@$clienteForm->cep;?>"/>
					</div>	
					
					<div class="ui-block-e" >
						
						<select  name="clienteForm_selectEstado" id="clienteForm_selectEstado" data-mini="false" data-theme="c" data-native-menu="false">
							<option>Estado</option>
							<?php
								$estados = array(
								'AC' => 'AC', 'AL' => 'AL', 'AM' => 'AM', 'AP' => 'AP', 'BA' => 'BA', 'CE' => 'CE',
								'DF' => 'DF', 'ES' => 'ES', 'GO' => 'GO', 'MA' => 'MA', 'MG' => 'MG', 'MS' => 'MS',
								'MT' => 'MT', 'PA' => 'PA', 'PB' => 'PB', 'PE' => 'PE', 'PI' => 'PI', 'PR' => 'PR',
								'RJ' => 'EJ', 'RN' => 'RN', 'RO' => 'RO', 'RR' => 'RR', 'RS' => 'RS', 'SC' => 'SC',
								'SE' => 'SE', 'SP' => 'SP', 'TO' => 'TO');
							
								foreach ($estados as $key => $value) {
								?>								
									<option value="<?=$value;?>" <?=(@$clienteForm->estado == $value) ? 'selected' : ''; ?>><?=$value;?></option>
								<?php	
								}
							
							?>
		          		</select>
	          		</div>
	          	
	          	</div>
								
				<input type="text" name="clienteForm_txtPais" id="clienteForm_txtPais" data-mini="false" placeholder="Pais" value="<?=@$clienteForm->pais;?>"/>
				
				<input type="tel" name="clienteForm_txtTelefone" id="clienteForm_txtTelefone" data-mini="false" placeholder="Telefone" value="<?=@$clienteForm->telefone;?>"/>
				
				<input type="tel" name="clienteForm_txtCelular" id="clienteForm_txtCelular" data-mini="false" placeholder="Celular" value="<?=@$clienteForm->celular;?>"/>
				
				<input type="text" name="clienteForm_txtFuncao" id="clienteForm_txtFuncao" data-mini="false" placeholder="Funcaoo" value="<?=@$clienteForm->funcao;?>"/>
				
				<textarea cols="40" rows="10" name="clienteForm_textareaObservacao" id="clienteForm_textareaObservacao" name="textareaObservacao" placeholder="Observacoes"><?=@$clienteForm->observacao;?></textarea>
				
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