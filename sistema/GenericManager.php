<?php

	class GenericManager {
			
		public $host;
		public $user;
		public $pass;
		public $db;
		public $conexao;
		
		public $TBL_PRODUTOS = "produtos";
		public $TBL_CLIENTES = "clientes";
		public $TBL_FORMA_PAGAMENTO = "formas_pagamento";
		public $TBL_USUARIOS = "usuarios";
		public $TBL_PEDIDOS = "pedidos";
		public $TBL_PEDIDOS_ITENS = "pedido_itens";
		public $TBL_DOWNLOAD = "download";
		/*

  		public function __construct(){
			$this->host = "mysql02.conferenciamodas.hospedagemdesites.ws";
			$this->user = "conferenciamod";
			$this->pass = "conferencia1";
			$this->db = "conferenciamod";
		}

*/
   		public function __construct(){
			$this->host = "localhost";
			$this->user = "root";
			$this->pass = "";
			$this->db = "conferenciamod";
		}

		private function openConnection() {
			$this->conexao = mysql_connect($this->host, $this->user, $this->pass) or die(mysql_error());
			mysql_select_db($this->db, $this->conexao) or die(mysql_error());
		}
		
		public function executeQuery($query) {
			
			$this->openConnection();
			
			$result = mysql_query($query, $this->conexao) or die(mysql_error());
			
			return $result;
		}
	
		/**
		 * @param string $query
		 * @param mixed $arg1, $arg2...$argN 
		 */
		function query($query)
		{
		    $args = func_get_args();
		    $query = array_shift($args);
		    
		    foreach ($args as $key => $arg) {
		        if (is_string($arg)) {
		            $args[$key] = mysql_escape_string($arg);
		        }
		    }
		    
		    array_unshift($args, $query);

		    $query = call_user_func_array('sprintf', $args);

			$this->openConnection();
			
			$result = mysql_query($query, $this->conexao) or die(mysql_error());
			
		    return $result;
		}
	
	}
	
?>