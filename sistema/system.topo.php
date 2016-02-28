	<div data-role="header" data-theme="b">
		<h1><?=$tituloPagina;?></h1>
		<div data-role="navbar" data-theme="b">
			<ul>
				<li><a href="<?=$urlPadrao;?>.form.php?<?=microtime();?>" class="ui-btn-active" >Cadastrar</a></li>
				<li><a href="<?=$urlPadrao;?>.list.php?<?=microtime();?>">Listar</a></li>
			</ul>
		</div>
		<a href="system.home.php?<?=microtime();?>" data-iconpos="text"  data-rel="external">Inicio</a>
		<a href="system.exit.php?<?=microtime();?>" data-iconpos="text"  data-rel="external">Sair</a>
	</div>