<?php
	include_once("DownloadManager.php");
	include_once("Uteis.php");

	$isDownload = isset($_REQUEST['isDownload']);
	
	$filename = "arqcliente.cfm";

	if ($isDownload) {

		$downloadManager = new DownloadManager();
		$downloadManager->atualizarData(DownloadManager::$CLIENTE);

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

		$resultado = $downloadManager->recuperarTodosCliente();
		
		if (mysql_num_rows($resultado) > 0) {
			
			if (is_writable($filename)) {
	
				if (!$handler = fopen($filename, "w+")) {
					echo "Não pode abrir o arquivo ($filename)";
					exit;
				}
				
				while ($cliente = mysql_fetch_object($resultado)) {
		
					$line1 = Uteis::preencherEsquerda($cliente->codigo, "0", 6) . "|";
					$line1.= Uteis::preencherEsquerda($cliente->nome, " ", 80) . "|";
					$line1.= Uteis::preencherEsquerda($cliente->email, " ", 50);
					
					fwrite($handler, $line1 . "\r");
					
					$line2 = Uteis::preencherEsquerda($cliente->endereco, " ", 100) . "|";
					$line2.= $cliente->cep . "|";
					$line2.= Uteis::preencherEsquerda($cliente->cidade, " ", 20) . "|";
					$line2.= $cliente->estado;
					
					fwrite($handler, $line2 . "\r"); 
					
					$line3 = Uteis::preencherEsquerda($cliente->telefone, " ", 20) . "|";
					$line3.= Uteis::preencherEsquerda($cliente->celular, " ", 20) . "|";
					$line3.= Uteis::preencherEsquerda($cliente->funcao, " ", 50);
					
					fwrite($handler, $line3 . "\r");
					
					$line4 = Uteis::preencherEsquerda($cliente->observacao, " ", 200);
					
					fwrite($handler, $line4 . "\r");
					
				} 
				
				fclose($handler);

				echo "Arquivo gerado. <a href='cliente.download.php?isDownload=TRUE'>Efetuar o download </a>";
					
			} else {
				
				echo "O arquivo $filename não possui permissão de escrita";
			}
	
		}

	}

	
?>
