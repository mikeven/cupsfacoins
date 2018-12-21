<?php
	/* ----------------------------------------------------------------------------------- */
	/* Cupfsa Coins - Accesos a roles de usuario */
	/* ----------------------------------------------------------------------------------- */
	/* ----------------------------------------------------------------------------------- */
	function obtenerListaAccesoSecciones( $data_accesos ){
		//Devuelve la lista de secciones accesibles por los permisos del usuario
		$lista = array();
		foreach ( $data_accesos as $a ) {
			$lista[] = $a["codigo"];
		}
		return $lista;
	}
	/* ----------------------------------------------------------------------------------- */
	function paV( $p, $area ){
		//Determina si un resultado de búsqueda parametrizado por país es visible para el usuario
		if( isSU() ) return true;
		
		$visible = false;
		$permisos = obtenerListaAccesoSecciones( $_SESSION["user"]["accesos"] );
		$paises = obtenerPaisesVisibles( $_SESSION["user"]["accesos"], $area );
		
		if ( in_array( $p, $paises ) || in_array( "todos", $paises ) ){
			$visible = true;
		}
		return $visible;
	}
	/* ----------------------------------------------------------------------------------- */
	function isV( $seccion ){
		//Determina si una sección del sistema es visible para el usuario
		if( isSU() ) return true;
		
		$visible = false;
		$permisos = obtenerListaAccesoSecciones( $_SESSION["user"]["accesos"] );
		if ( in_array( $seccion, $permisos ) ){
			$visible = true;
		}
		return $visible;
	}
	/* ----------------------------------------------------------------------------------- */
	function isAccesible( $pagina ){
		//Determina si una página del sistema es accesible para el usuario
		if( !isV( $pagina ) ) header('Location: inicio.php');
	}
	/* ----------------------------------------------------------------------------------- */
?>