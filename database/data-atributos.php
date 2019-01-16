<?php
	/* --------------------------------------------------------- */
	/* Cupfsa Coins - Datos sobre atributos */
	/* --------------------------------------------------------- */
	/* --------------------------------------------------------- */
	function obtenerAtributosRegistrados( $dbh ){
		//Devuelve todos los registros de atributos
		$q = "select idATRIBUTO, nombre, valor, prioridad, definicion, imagen  
		from atributo order by nombre asc";
		
		$data = mysqli_query( $dbh, $q );

		return obtenerListaRegistros( $data );
	}
	/* --------------------------------------------------------- */
	function registrosAsociadosAtributo( $dbh, $ida ){
		// Determina si existe un registro de tabla asociada a un atributo
		// Tablas relacionadas: nominacion

		return registroAsociadoTabla( $dbh, "nominacion", "idATRIBUTO", $ida );
	}
	/* --------------------------------------------------------- */
	function eliminarAtributo( $dbh, $idu ){
		// Elimina un registro de atributo
		$q = "delete from atributo where idATRIBUTO = $idu";
		
		return mysqli_query( $dbh, $q );
	}
	/* --------------------------------------------------------- */
	if( isset( $_POST["elim_atributo"] ) ){
		// Solicitud para eliminar atributo

		include( "bd.php" );
		$rsp = eliminarAtributo( $dbh, $_POST["elim_atributo"] );
		
		if( ( $rsp != 0 ) && ( $rsp != "" ) ){
			$res["exito"] = 1;
			$res["mje"] = "Atributo eliminado con éxito";
		} else {
			$res["exito"] = 0;
			$res["mje"] = "Error al eliminar atributo";
			$res["reg"] = NULL;
		}
		
		echo json_encode( $res );
	}
?>