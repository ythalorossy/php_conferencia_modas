<?php

	require_once("ClienteManager.php");
	require_once("Uteis.php");

	$managerOpcao = isset($_REQUEST['managerOpcao']) ? $_REQUEST['managerOpcao'] : "";
	
	switch ($managerOpcao) {

		case 'CADASTRAR':

			$cliente = new Cliente();
			$cliente->codigoUsuario = $_REQUEST['clienteForm_codigoUsuario'];
			$cliente->nome 			= $_REQUEST['clienteForm_txtNome'];
			$cliente->email  		= $_REQUEST['clienteForm_txtEmail'];
			$cliente->endereco 		= $_REQUEST['clienteForm_txtEndereco'];
			$cliente->cidade 		= $_REQUEST['clienteForm_txtCidade'];
			$cliente->cep 			= $_REQUEST['clienteForm_txtCep'];
			$cliente->estado 		= $_REQUEST['clienteForm_selectEstado'];
			$cliente->pais 			= $_REQUEST['clienteForm_txtPais'];
			$cliente->telefone 		= $_REQUEST['clienteForm_txtTelefone'];
			$cliente->celular 		= $_REQUEST['clienteForm_txtCelular'];
			$cliente->funcao 		= $_REQUEST['clienteForm_txtFuncao'];
			$cliente->observacao 	= $_REQUEST['clienteForm_textareaObservacao'];
			$cliente->dataAlteracao	= Uteis::dataAtual("Y/m/d H:i:s");
			
			$clienteManager = new ClienteManager();
			
			$clienteManager->inserirCliente($cliente);

		break;
		
		case 'EDITAR':
			
			$cliente = new Cliente();
			$cliente->codigo 		= $_REQUEST['clienteForm_codigoCliente'];
			$cliente->nome 			= $_REQUEST['clienteForm_txtNome'];
			$cliente->email  		= $_REQUEST['clienteForm_txtEmail'];
			$cliente->endereco 		= $_REQUEST['clienteForm_txtEndereco'];
			$cliente->cidade 		= $_REQUEST['clienteForm_txtCidade'];
			$cliente->cep 			= $_REQUEST['clienteForm_txtCep'];
			$cliente->estado 		= $_REQUEST['clienteForm_selectEstado'];
			$cliente->pais 			= $_REQUEST['clienteForm_txtPais'];
			$cliente->telefone 		= $_REQUEST['clienteForm_txtTelefone'];
			$cliente->celular 		= $_REQUEST['clienteForm_txtCelular'];
			$cliente->funcao 		= $_REQUEST['clienteForm_txtFuncao'];
			$cliente->observacao 	= $_REQUEST['clienteForm_textareaObservacao'];
			$cliente->dataAlteracao	= Uteis::dataAtual("Y/m/d H:i:s");
			
			$clienteManager = new ClienteManager();

			$clienteManager->atualizarCliente($cliente);
					
		break;
		
		case 'DELETAR':
			
			$cliente = new Cliente();
			$cliente->codigo 		= $_REQUEST['codigoCliente'];
			
			$clienteManager = new ClienteManager();
			
			$clienteManager->deletar($cliente);
			
		break;	
		
	}

	header("location: cliente.list.php");

?>