<?php
	include_once("DownloadManager.php");
	include_once("Uteis.php");

	$isDownload = isset($_REQUEST['isDownload']);
	
	$filename = "arqpedido.cfm";

	if ($isDownload) {
		
		
		$downloadManager = new DownloadManager();
		$downloadManager->atualizarData(DownloadManager::$PEDIDO);
		
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);  
		header("Content-Type: text/html");
		header("Content-Disposition: attachment; filename=\"".basename($filename)."\";" );
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".filesize($filename));
		readfile("$filename");
		exit();

	} else {
		
		$downloadManager = new DownloadManager();

		$resultado = $downloadManager->recuperarTodosPedido();
		
			if (is_writable($filename)) {
	
				if (!$handler = fopen($filename, "w+")) {
					echo "Não pode abrir o arquivo ($filename)";
					exit;
				}
				
				foreach ($resultado as $key => $pedido) {

					$dataAux = explode("-", substr($pedido->data, 0, 10));
					$data = $dataAux[2] ."-".$dataAux[1]."-".$dataAux[0];
					$hora = substr($pedido->data, 11, 5);
					
					foreach($pedido->itens as $key => $item) {

						$line1 = Uteis::preencherEsquerda($item->codigoPedido, "0", 10) . "|";
						$line1.= Uteis::preencherEsquerda($data, "0", 10) . "|";
						$line1.= Uteis::preencherEsquerda($hora, "0", 5) . "|";
						$line1.= Uteis::preencherEsquerda($pedido->codigoCliente, "0", 6) . "|";
						$line1.= Uteis::preencherEsquerda($pedido->codigoUsuario, "0", 6);
						fwrite($handler, $line1 . "\r");
						
						$line2 = Uteis::preencherEsquerda($item->codigoProduto, "0", 6) . "|";
						$line2.= Uteis::preencherEsquerda($item->quantidade, "0", 6);
						fwrite($handler, $line2 . "\r");
						
						$line3 = Uteis::preencherEsquerda($pedido->codigoFormaPagamento, "0", 6);
						fwrite($handler, $line3 . "\r");
					}
				}
				
				fclose($handler);

				echo "Arquivo gerado. <a href='pedido.download.php?isDownload=TRUE'>Efetuar o download </a>";
					
			} else {
				
				echo "O arquivo $filename não possui permissão de escrita";
			}

	}
?>