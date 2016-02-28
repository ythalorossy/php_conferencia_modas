<?php

	class Uteis {
		
		public static function dataAtual($formato) {
			
			$dateTime = new DateTime();

			return $dateTime->format($formato);
		}
		
		public static function preencherEsquerda($valor, $caracter, $quantidade) {
			
			return str_pad($valor, $quantidade, "$caracter", STR_PAD_LEFT);
		}		
		
		public static function showHideElement($perfil, $permissao) {
			
			$display = ($perfil == $permissao) ? "" : " style='display: none'";
			
			return $display;
		}
		
		/**
		 * Class casting
		 * @author Esta funcionalidade foi copiada da internet, o seu criador não foi descrito no site.
		 * @author Ythalo Rossy Saldanha lira
		 * @param string|object $destination
		 * @param object $sourceObject
		 * @return object
		 */
		public static function cast($destination, $sourceObject) {
		    if (is_string($destination)) {
		    	
		        $destination = new $destination();
		    }
			
		    $sourceReflection = new ReflectionObject($sourceObject);
			
		    $destinationReflection = new ReflectionObject($destination);
			
		    $sourceProperties = $sourceReflection->getProperties();
			
		    foreach ($sourceProperties as $sourceProperty) {
		    	
		       // $sourceProperty->setAccessible(true);
				
		        $name = $sourceProperty->getName();
				
		        $value = $sourceProperty->getValue($sourceObject);
				
		        if ($destinationReflection->hasProperty($name)) {
		        	
		            $propDest = $destinationReflection->getProperty($name);
					
		           // $propDest->setAccessible(true);
					
		            $propDest->setValue($destination,$value);
					
		        } else {
		        	
		            $destination->$name = $value;
		        }
		    }
			
		    return $destination;
		}	
		
		
	}
