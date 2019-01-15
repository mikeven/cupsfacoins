<?php 
	/* --------------------------------------------------------- */
	/* Cupfsa Coins - Funciones sobre productos */
	/* --------------------------------------------------------- */
	/* --------------------------------------------------------- */
	
	/* --------------------------------------------------------- */
	function solvente( $coins, $valor ){
		// Devuelve verdadero si los coins disponibles cubren el valor del producto
		return true;//$coins > $valor;
	}
	/* --------------------------------------------------------- */
	function esBorrable( $dbh, $idp ){
		// Devuelve verdadero si el producto puede mostrar opción para ser eliminado
		$borrable = false;
		if( isV( 'en_elim_prod' ) && ( !registrosAsociadosProducto( $dbh, $idp ) ) ){
			$borrable = true;
		}
		return $borrable;
	}
	/* --------------------------------------------------------- */
?>