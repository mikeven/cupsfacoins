<?php
	/* --------------------------------------------------------- */
	/* Cupfsa Coins - Datos sobre atributos */
	/* --------------------------------------------------------- */
	/* --------------------------------------------------------- */
	function obtenerAtributosRegistrados( $dbh ){
		//Devuelve todos los registros de atributos
		$q = "select idATRIBUTO, nombre, valor, prioridad from atributo";
		//echo $q;
		$data = mysqli_query( $dbh, $q );

		return obtenerListaRegistros( $data );
	}
	/* --------------------------------------------------------- */
?>