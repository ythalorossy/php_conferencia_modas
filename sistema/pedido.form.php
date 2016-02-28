<?php
	if (!isset($_SESSION)) {
		session_start();	
	}
	include("ClienteManager.php");
	include("ProdutoManager.php");
	include("PedidoManager.php");
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
	
	<script>
		/*
		* Funcao baseada na solucao do problema apresentada no stackoverflow:
		* http://stackoverflow.com/questions/149055/how-can-i-format-numbers-as-money-in-javascript
		*
		* Fiz agumas alteracoes para melhorar a inteligibilidade da funcao.
		* Aldo Monteiro (c) 2011
		* !!!! Atencao: Se o numero passado como parametro for passado como string,
		* este devera obrigatoriamente ser passado com separador decimal . - ponto.
		*/
		function formataMoeda(numero, casasDecimais, separadorDecimal, separadorMilhar, unidadeMoeda){
			casasDecimais = isNaN(casasDecimais = Math.abs(casasDecimais)) ? 2 : casasDecimais;
			separadorDecimal = separadorDecimal == undefined ? "," : separadorDecimal;
			separadorMilhar = separadorMilhar == undefined ? "." : separadorMilhar;
			unidadeMoeda = unidadeMoeda == undefined ? "" : unidadeMoeda + " ";
			var sinal = numero < 0 ? "-" : "";
			var parteInteira = parseInt(numero = Math.abs(+numero || 0).toFixed(casasDecimais)) + "";

			var j = (j = parteInteira.length) > 3 ? j % 3 : 0;
			return unidadeMoeda + sinal + (j ? parteInteira.substr(0, j) + separadorMilhar : "") + parteInteira.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + separadorMilhar) + (casasDecimais ? separadorDecimal + Math.abs(numero - parteInteira).toFixed(casasDecimais).slice(2) : "");
 		}
		
		$(document).bind("pageinit", function(){
			
			$("input[type='checkbox']").checkboxradio({ mini: "false" });

			$("#valorTotal").html(formataMoeda(0, 2, ',', '.', 'R$'));
		
			// Dispara quando o usuario digita uma quantidade de produto.
			// Verifica se o usuario esta digitando valores numericos
			$("input[id^='pedidoForm_textItemProduto']").bind('keyup focusout', function () {

				var quantidade = $(this).val();

				if (( isNaN(parseFloat(quantidade)) || isNaN(parseInt(quantidade)) ) && !isFinite(quantidade)) {
					alert("Valor invalido");
					$(this).val("").focus();
					return;
				}

				// Recalcula o valor total do pedido				
				var valorTotalPedido = 0;
				
				$("input[id^='pedidoForm_textItemProduto']").each(function(i) {
					
					var id = $(this).attr("id");
					
					// Valor do Produto
					var idValorProduto = 'pedidoForm_textValorProduto' + id.substr(id.length - 3);
					var valorProduto = $("input[id='" + idValorProduto + "']");
					
					// Valor calculado do item (valor produto X quantidade)
					var idValorCalculadoItem = 'pedidoForm_textValorCalculadoItem' + id.substr(id.length - 3);
					var valorCalculadoItem = $("span[id='" + idValorCalculadoItem + "']");
					valorCalculadoItem.text("");
					
					if (!isNaN( parseInt( $(this).val() ) ) ) {
						
						var quantidadeItem = $(this).val();
						
						valorCalculadoItem.text("").html(formataMoeda((parseFloat(valorProduto.val()) * parseFloat(quantidadeItem)), 2, ',', '.', 'R$') );
						
						valorTotalPedido += (parseFloat(valorProduto.val()) * parseFloat(quantidadeItem));
					}
					
				});
				
				$("#valorTotal").html(formataMoeda(valorTotalPedido,2,',','.','R$'));
				
			});
			
			
			// Botão responsavel por efetuar o pedido
			$("#btnSalvarPedido").click(function(){
			
				var error = false;
				
				$('#errorFormPedido #content').text("");
				
				// Regras de Negocio para validação da solicitaca de pedido
				var codigoCliente = $("select[id='pedidoForm_selectCliente'] option:selected").val();
				
				// Regra - Cliente Selecionado
				if (codigoCliente == 0) {
					error = true;
					$('#errorFormPedido #content').append("Nenhum cliente selecionado. <br/>");
				}

				// Regra - Forma de Pagamento Selecionada
				var codigoFormaPagamento = $("select[id='pedidoForm_selectFormaPagamento'] option:selected").val();
				
				if (codigoFormaPagamento == 0) {
					error = true;
					$('#errorFormPedido #content').append("Nenhuma Forma de Pagamento selecionada. <br/>");
				}
				
				// Regra - Pelo menos um produto selecionado
				var quantidadeProdutoSelecionado = $("input[id^='pedidoForm_checkItemProduto']:checked").length;

				if (quantidadeProdutoSelecionado == 0) {
					error = true;
					$('#errorFormPedido #content').append("Nenhum produto selecionado. <br/>");
				}				
				
				// Verifica se alguma regra de negócio falhou na validação.
				if (error) {

					$('<a />')
						.attr('id', 'triggerShowError')
						.attr('href', '#errorFormPedido')
						.attr('data-role', 'button')
						.attr('data-rel', 'dialog')
						.attr('data-transition', 'pop')
							.appendTo($('#paginaInicial #content'))
								.trigger('click');
				
					return false;
				}
			});

			// Este ponto sera util apenas na edicao do Pedido			
			$("input[id^='pedidoForm_textItemProduto']").each(function() {
				$(this).trigger("keyup");
			});
		
		});
	
	</script>
	
	<script src="js/jquery/mobile/jquery.mobile-1.1.0.js"></script>
	<script>
		$.mobile.ajaxEnabled=false;
	</script>
</head> 
<body>
	
	<div data-role="page" id="paginaInicial" data-title="Pagina Inicial" >
	
		<?php 
			$tituloPagina = "Pedidos";
			$urlPadrao = "pedido";
			include("system.topo.php");
		?>
		
		<!-- content --> 
		<div data-role="content" id="content" class="ui-body ui-body-b">	
			
			<form action="PedidoController.php" method="post" data-ajax="false">
				
				<?php 
					$opcao = "CADASTRAR";
					
					if(isset($_REQUEST['opcao'])){
						
						$opcao = $_REQUEST['opcao'];
						
						if ($opcao == "EDITAR") {
							$pedidoManager = new PedidoManager();
							$pedido = $pedidoManager->recuperarPorCodigoObject($_REQUEST['codigoPedido']);
						}
					} 
				?>
				
				<input type="hidden" name="managerOpcao" id="managerOpcao" value="<?=$opcao;?>"/>
				<input type="hidden" name="pedidoForm_codigoPedido" id="pedidoForm_codigoPedido" value="<?=@$pedido->codigo;?>"/>
				<input type="hidden" name="pedidoForm_codigoUsuario" id="pedidoForm_codigoUsuario" value="<?=@$_SESSION["usuario"]["codigo"];?>"/>
				<select name="pedidoForm_selectCliente" id="pedidoForm_selectCliente" data-mini="false" data-theme="c" data-native-menu="false" data-transition="none">
					
					<option value="0">Clientes</option>
				<?php
					$clienteManager = new ClienteManager();
					$resultado = $clienteManager->recuperarTodos($_SESSION["usuario"]["codigo"]);
					
					while ($cliente = mysql_fetch_object($resultado)) {
						
						$selected = "";
						
						if (($opcao == "EDITAR") && ($cliente->codigo == $pedido->codigoCliente)) {
						
							$selected = "selected='selected'";
						} 
							
						echo "<option $selected value='$cliente->codigo'>$cliente->nome</option>";
					}
				?>
				</select>
				
				<select name="pedidoForm_selectFormaPagamento" id="pedidoForm_selectFormaPagamento" data-mini="false" data-theme="c" data-native-menu="false" data-transition="none">
					
					<option value="0">Formas de Pagamento</option>
				<?php
					$formaPagamentoManager = new FormaPagamentoManager();
					$resultado = $formaPagamentoManager->recuperarTodos();
					
					while ($formaPagamento = mysql_fetch_object($resultado)) {
						
						$selected = "";
						
						if (($opcao == "EDITAR") && ($formaPagamento->codigo == $pedido->codigoFormaPagamento)) {
							
							$selected = "selected='selected'";
						}
						
						echo "<option $selected value='$formaPagamento->codigo'>$formaPagamento->descricao</option>";
					}
				?>
				</select>				
				
				<ul data-role="listview" data-inset="true">
				<?php
				
					$produtoManager = new ProdutoManager();
					$resultado = $produtoManager->recuperarTodos();
					
					while ($produto = mysql_fetch_object($resultado)) {
						
						// Marca o produto na edicao do pedido.
						$checked = FALSE;		
						$itemPedido = "";
							
						if ($opcao == 'EDITAR') {
								
							foreach ($pedido->itens as $key => $item) {
								if ($produto->codigo == $item->codigoProduto) {
									$checked = TRUE;
									$itemPedido = $item;
									break;
								}
							}
						}
				?>
					<li data-theme="c">
						<div data-role="footer" data-theme="c" class="ui-bar ui-grid-c">
							<div class="ui-block-a">
								<label>
									<input type="checkbox" style="width: 10px;height: 10px" <?=($checked)?"checked='checked'":"";?> id="pedidoForm_checkItemProduto[<?=$produto->codigo;?>]" name="pedidoForm_checkItemProduto[<?=$produto->codigo;?>]"/><?=$produto->descricao;?>
								</label>
							</div>
							<div class="ui-block-b" style="padding: 10px 0 0 0">
								<input type="hidden" id="pedidoForm_textValorProduto[<?=$produto->codigo;?>]" name="pedidoForm_textValorProduto[<?=$produto->codigo;?>]" value="<?=$produto->valor;?>"/>
								R$ <?=number_format($produto->valor, 2, ",",".");?>
							</div>
							<div class="ui-block-c" style="text-align: right">
								<input type="number" size="10" id="pedidoForm_textItemProduto[<?=$produto->codigo;?>]" name="pedidoForm_textItemProduto[<?=$produto->codigo;?>]" value="<?=@$itemPedido->quantidade;?>"/>
							</div>	 
							<div class="ui-block-d">
								<div style="padding: 10px 0 0 0; text-align: right">
									<span id="pedidoForm_textValorCalculadoItem[<?=$produto->codigo;?>]"></span>
								</div>
							</div>
						</div>
					</li>				
				<?php		
					}
					
				?>
					<li  data-theme="c">
					<div style="text-align: right; font-size: 24px;"><span id="valorTotal"></span></div>
					</li>
				
				</ul>

				<fieldset class="ui-grid-a">
					
					<button type="submit" id="btnSalvarPedido" name="btnSalvarPedido" data-theme="b">Salvar</button>
	
		    	</fieldset>
	
			</form>
			
		</div>
		
	</div>
	
	<!-- Em caso de erros -->
	<div data-role="page" id="errorFormPedido">
		<div data-role="header" data-theme="b">
			<h1>Erro no Pedido</h1>
		</div>
		<div data-role="content" id="content" data-theme="b"></div>
	</div>
	
</body>
	
</html>