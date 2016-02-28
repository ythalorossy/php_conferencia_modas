<!DOCTYPE html> 
<html> 
	<head> 
	<title>Conferencia</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="css/jquery/mobile/jquery.mobile-1.1.0.css" />
	<script src="js/jquery/jquery-1.7.2.js"></script>
		
	<script>
		
		$(document).bind("pageinit", function(){
		
			$("#btnAutenticar").click(function(){
			
				var error = false;
				
				$('#errorAutenticacao #content').text("");
				
				if($("#txtLoginUsuario").val() == "") {
					error = true;
					$('#errorAutenticacao #content').append("Usuario invalido. <br/>");
				}

				if($("#txtLoginSenha").val() == "") {
					error = true;
					$('#errorAutenticacao #content').append("Senha invalida. <br/>");
				}

				if (error) {

					$('<a />')
						.attr('id', 'triggerShowError')
						.attr('href', '#errorAutenticacao')
						.attr('data-role', 'button')
						.attr('data-rel', 'dialog')
						.attr('data-transition', 'pop')
							.appendTo($('#paginaInicial #content'))
								.trigger('click');
				
					return false;
				}
			});
		
		});
	
	</script>
	
	<script src="js/jquery/mobile/jquery.mobile-1.1.0.js"></script>

	<script>
		$.mobile.ajaxEnabled=true;
	</script>

</head> 
<body> 

	<!-- page -->
	<div data-role="page" id="paginaInicial" data-title="Pagina Inicial">
	
		<!-- header -->
		<div data-role="header" data-theme="b">
			<h1>Autenticacao</h1>
		</div>
		
		<!-- content --> 
		<div data-role="content" id="content" class="ui-body ui-body-c">	
			
			<form action="autenticar.php" method="post" data-ajax="false">
	
				<input type="text" name="txtLoginUsuario" id="txtLoginUsuario" data-mini="true" placeholder="Usuario"/>
	
				<input type="password" name="txtLoginSenha" id="txtLoginSenha" data-mini="true" placeholder="Senha"/>
			
				<button type="submit" id="btnAutenticar" data-theme="b">Autenticar</button>
	
			</form>
			
		</div>
		
	</div>
	
	
	<!-- Start of third page: #popup -->
	<div data-role="page" id="errorAutenticacao">
		<div data-role="header" data-theme="b">
			<h1>Erro na autentica��o</h1>
		</div>
		<div data-role="content" id="content" data-theme="b"></div>
	</div>

</body>
</html>