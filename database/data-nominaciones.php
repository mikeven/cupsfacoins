<?php
	/* --------------------------------------------------------- */
	/* Cupfsa Coins - Datos sobre nominaciones */
	/* --------------------------------------------------------- */
	/* --------------------------------------------------------- */
	function obtenerNominacionPorId( $dbh, $idn ){
		//Devuelve el registro de una nominacion dado su id
		$q = "select n.idNOMINACION, n.idNOMINADOR, n.idNOMINADO, n.idATRIBUTO, 
		u1.nombre as nombre1, u1.apellido as apellido1, u2.nombre as nombre2, 
		u2.apellido as apellido2, n.valor_atributo as valor, a.nombre as atributo, 
		n.estado, n.motivo1, n.sustento1, n.motivo2, n.sustento2, 
		date_format(n.fecha_nominacion,'%d/%m/%Y') as fregistro, 
		date_format(n.fecha_cierre,'%d/%m/%Y') as fcierre 
		from nominacion n, usuario u1, usuario u2, atributo a 
		where n.idNOMINADOR = u1.idUSUARIO and n.idNOMINADO = u2.idUSUARIO 
		and n.idATRIBUTO = a.idATRIBUTO and n.idNOMINACION = $idn";
		
		$data = mysqli_query( $dbh, $q );
		return mysqli_fetch_array( $data );
	}
	/* --------------------------------------------------------- */
	function obtenerNominaciones( $dbh ){
		//
	}
	/* --------------------------------------------------------- */
	function obtenerNominacionesPersonales( $dbh, $idu, $p ){
		//Devuelve los registros de nominaciones hechas o recibidas por un usuario dado por un parámetro.

		$q = "select n.idNOMINACION as id, n.idNOMINADOR, n.idNOMINADO, n.idATRIBUTO, 
		u2.nombre as nombre2, u2.apellido as apellido2, a.nombre as atributo,  
		date_format(n.fecha_nominacion,'%d/%m/%Y') as fregistro   
		from nominacion n, usuario u2, atributo a where n.idNOMINADO = u2.idUSUARIO 
		and n.idATRIBUTO = a.idATRIBUTO and $p = $idu order by fregistro desc";

		$data = mysqli_query( $dbh, $q );
		return obtenerListaRegistros( $data );
	}
	/* --------------------------------------------------------- */
	function obtenerNominacionesAccion( $dbh, $idu, $accion ){
		//Invoca la obtención de nominaciones hechas o recibidas por un usuario
		if( $accion == "hechas" ) 		$p = "n.idNOMINADOR";
		if( $accion == "recibidas" ) 	$p = "n.idNOMINADO";

		return obtenerNominacionesPersonales( $dbh, $idu, $p );
	}
	/* --------------------------------------------------------- */
	function nombrePrefijo(){
		//Devuelve un prefijo de nombre a un archivo basado en una marca de tiempo
		return date_timestamp_get( date_create() );
	}
	/* --------------------------------------------------------- */
	function cargarArchivo( $archivo ){
		//Ubica el archivo subido en la ruta indicada
		$dir = '../upload/';
		$pref = nombrePrefijo( $archivo['name'] );
		$destino = $dir . $pref ."-". basename( $archivo['name'] );

		if ( move_uploaded_file( $archivo['tmp_name'], $destino  ) ) {
		    $carga["exito"] = 1;
		    $carga["ruta"] = substr( $destino, 3 );
		} else {
		    $carga["exito"] = 0;
		    $carga["ruta"] = "";
		}

		return $carga;
	}
	/* --------------------------------------------------------- */
	function agregarNominacion( $dbh, $nominacion ){
		//Guarda un nuevo registro de nominación

		$q = "insert into nominacion ( idNOMINADOR, idNOMINADO, idATRIBUTO, 
		valor_atributo, estado, motivo1, sustento1, fecha_nominacion ) values 
		( $nominacion[idnominador], $nominacion[idnominado], $nominacion[idatributo], 
		$nominacion[valor], '$nominacion[estado]', '$nominacion[motivo]', 
		'$nominacion[sustento]', NOW() )";
		
		$data = mysqli_query( $dbh, $q );
		return mysqli_insert_id( $dbh );
	}
	/* --------------------------------------------------------- */
	// Solicitudes asíncronas
	/* --------------------------------------------------------- */
	if( isset( $_POST["nva_nominacion"] ) ){
		include( "bd.php" );	
		$nominacion["idnominador"] 	= $_POST["nva_nominacion"];
		$nominacion["idnominado"] 	= $_POST["id_persona"];
		$nominacion["idatributo"] 	= $_POST["atributo"];
		$nominacion["valor"] 		= $_POST["valor_atributo"];
		$nominacion["motivo"] 		= $_POST["motivo"];
		$nominacion["sustento"]		= "";
		$nominacion["estado"] 		= "pendiente";

		if( isset( $_FILES["archivo"] ) ){
			$archivo = cargarArchivo( $_FILES["archivo"] );
			if( $archivo["exito"] == 1 )
				$nominacion["sustento"] = $archivo["ruta"];
		}
		
		$id = agregarNominacion( $dbh, $nominacion );
		$nominacion["id"] = $id;
		
		if( ( $id != 0 ) && ( $id != "" ) ){
			$res["exito"] = 1;
			$res["mje"] = "Registro de nominación exitoso";
			$res["reg"] = $nominacion;
		} else {
			$res["exito"] = 0;
			$res["mje"] = "Error al registrar nominación";
			$res["reg"] = NULL;
		}
		echo json_encode( $res );
	}
	/* --------------------------------------------------------- */
?>