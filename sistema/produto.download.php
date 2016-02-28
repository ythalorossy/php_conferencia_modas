<?php
	include_once("DownloadManager.php");
	include_once("Uteis.php");

	$isDownload = isset($_REQUEST['isDownload']);
	
	$filename = "arqproduto.cfm";

	if ($isDownload) {
		
		$downloadManager = new DownloadManager();
		$downloadManager->atualizarData(DownloadManager::$PRODUTO);
		
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

		$resultado = $downloadManager->recuperarTodosProduto();
		
		if (is_writable($filename)) {

			if (!$handler = fopen($filename, "w+")) {
				echo "Não pode abrir o arquivo ($filename)";
				exit;
			}
			
			while ($produto = mysql_fetch_object($resultado)) {
	
				$line1 = Uteis::preencherEsquerda($produto->codigo, "0", 6) . "|";
				$line1.= Uteis::preencherEsquerda($produto->codigo_barra, " ", 13) . "|";
				$line1.= Uteis::preencherEsquerda($produto->descricao, " ", 80) . "|";
				$line1.= Uteis::preencherEsquerda($produto->quantidade, "0", 10) . "|";
				$line1.= Uteis::preencherEsquerda($produto->valor, "0", 10);
				
				fwrite($handler, $line1 . "\r");
			} 
			
			fclose($handler);

			echo "Arquivo gerado. <a href='produto.download.php?isDownload=TRUE'>Efetuar o download </a>";
				
		} else {
			
			echo "O arquivo $filename não possui permissão de escrita";
		}
	
	}
?>