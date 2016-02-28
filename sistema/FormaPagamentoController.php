<?php
	
	require_once("FormaPagamentoManager.php");
	require_once("Uteis.php");

	$managerOpcao = isset($_REQUEST['managerOpcao']) ? $_REQUEST['managerOpcao'] : "";

	switch ($managerOpcao) {

		case 'CADASTRAR':
			$formaPagamento = new FormaPagamento();
			$formaPagamento->descricao 	= $_REQUEST['formaPagamentoForm_txtDescricao'];
			$formaPagamento->dataAlteracao	= Uteis::dataAtual("Y/m/d H:i:s");
			
			$formaPagamentoManager = new FormaPagamentoManager();
				
			$formaPagamentoManager->inserirFormaPagamento($formaPagamento);
			
		break;
		
		case 'EDITAR':

			$formaPagamento = new FormaPagamento();
			$formaPagamento->codigo = $_REQUEST['formaPagamentoForm_codigoFormaPagamento'];
			$formaPagamento->descricao 	= $_REQUEST['formaPagamentoForm_txtDescricao'];
			$formaPagamento->dataAlteracao	= Uteis::dataAtual("Y/m/d H:i:s");
			
			$formaPagamentoManager = new FormaPagamentoManager();
			
			$formaPagamentoManager->atualizarFormaPagamento($formaPagamento);
			
		break;
	}

	header("location: forma.pagamento.list.php");

?>