<?php
	/* --------------------------------------------------------- */
	/* Cupfsa Coins - Datos sobre nominaciones */
	/* --------------------------------------------------------- */
	/* --------------------------------------------------------- */
	define( "RUTA_SUSTENTOS", "../upload/" );

	function obtenerNominacionPorId( $dbh, $idn ){
		//Devuelve el registro de una nominacion dado su id
		$q = "select n.idNOMINACION, n.idNOMINADOR, n.idNOMINADO, n.idATRIBUTO, 
		u1.nombre as nombre1, u1.apellido as apellido1, u2.nombre as nombre2, 
		u2.apellido as apellido2, n.valor_atributo as valor, a.nombre as atributo, 
		a.imagen, n.estado, n.motivo1, n.sustento1, n.motivo2, n.sustento2, 
		n.comentario, date_format(n.fecha_nominacion,'%d/%m/%Y') as fregistro, 
		date_format(n.fecha_cierre,'%d/%m/%Y') as fcierre,
		date_format(n.fecha_adjudicacion,'%d/%m/%Y') as fadjudicada 
		from nominacion n, usuario u1, usuario u2, atributo a 
		where n.idNOMINADOR = u1.idUSUARIO and n.idNOMINADO = u2.idUSUARIO 
		and n.idATRIBUTO = a.idATRIBUTO and n.idNOMINACION = $idn";
		
		$data = mysqli_query( $dbh, $q );
		$data ? $registro = mysqli_fetch_array( $data ) : $registro = NULL;
		return $registro;
	}
	/* --------------------------------------------------------- */
	function obtenerNominacionesRegistradas( $dbh ){
		//Devuelve los registros de todas las nominaciones

		$q = "select n.idNOMINACION, n.idNOMINADOR, n.idNOMINADO, n.idATRIBUTO, 
		n.estado, u2.nombre as nombre2, u2.apellido as apellido2, a.nombre as atributo, 
		a.valor, a.imagen, date_format(n.fecha_nominacion,'%d/%m/%Y') as fregistro 
		from nominacion n, usuario u2, atributo a where n.idNOMINADO = u2.idUSUARIO 
		and n.idATRIBUTO = a.idATRIBUTO order by fregistro desc";

		$data = mysqli_query( $dbh, $q );
		return obtenerListaRegistros( $data );
	}
	/* --------------------------------------------------------- */
	function obtenerNominacionesPersonales( $dbh, $idu, $p, $p2 ){
		//Devuelve los registros de nominaciones hechas o recibidas por un usuario.

		$q = "select n.idNOMINACION, n.idNOMINADOR, n.idNOMINADO, n.idATRIBUTO, 
		n.estado, u2.nombre as nombre2, u2.apellido as apellido2, a.nombre as atributo,  
		a.imagen, a.valor, date_format(n.fecha_nominacion,'%d/%m/%Y') as fregistro 
		from nominacion n, usuario u2, atributo a where n.idNOMINADO = u2.idUSUARIO 
		and n.idATRIBUTO = a.idATRIBUTO and $p = $idu $p2 order by fregistro desc";

		$data = mysqli_query( $dbh, $q );
		return obtenerListaRegistros( $data );
	}


	/* --------------------------------------------------------- */
	function obtenerNominacionesPorVotar( $dbh, $idu ){
		//Devuelve los registros de nominaciones que no ha sido votada por un usuario dado su id.

		$q = "select n.idNOMINACION as id, n.idNOMINADOR, n.idNOMINADO, 
		u2.nombre as nombre2, u2.apellido as apellido2, a.nombre as atributo,  
		a.valor, a.imagen, date_format(n.fecha_nominacion,'%d/%m/%Y') as fregistro 
		from nominacion n, usuario u2, atributo a where n.idNOMINADO = u2.idUSUARIO 
		and n.idATRIBUTO = a.idATRIBUTO and n.idNOMINACION not in 
		(select idNOMINACION from voto where idUSUARIO = $idu ) 
		order by fregistro desc";

		$data = mysqli_query( $dbh, $q );
		return obtenerListaRegistros( $data );
	}
	/* --------------------------------------------------------- */
	function obtenerNominacionesAccion( $dbh, $idu, $accion ){
		//Invoca la obtención de nominaciones hechas/recibidas/no votadas por un usuario
		
		if( $accion == "hechas" ){ 		
			$p = "n.idNOMINADOR";
			$nominaciones = obtenerNominacionesPersonales( $dbh, $idu, $p, "" );
		}
		if( $accion == "recibidas" ){
			$p = "n.idNOMINADO";
			$p2 = "and estado = 'aprobada'";
			$nominaciones = obtenerNominacionesPersonales( $dbh, $idu, $p, $p2 );
		}
		if( $accion == "votar" ){
			$nominaciones = obtenerNominacionesPorVotar( $dbh, $idu );
		}

		return $nominaciones;
	}
	/* --------------------------------------------------------- */
	function nombrePrefijo(){
		//Devuelve un prefijo de nombre a un archivo basado en una marca de tiempo
		return date_timestamp_get( date_create() );
	}
	/* --------------------------------------------------------- */
	function cargarArchivo( $archivo, $dir ){
		//Ubica el archivo subido en la ruta indicada

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
	function agregarSustento( $dbh, $nominacion ){
		// Actualiza una nominación con los datos del segundo sustento
		$q = "update nominacion set motivo2 = '$nominacion[motivo2]', 
		sustento2 = '$nominacion[sustento2]', estado = 'pendiente' 
		where idNOMINACION = $nominacion[idnominacion]";
		
		$data = mysqli_query( $dbh, $q );

		return mysqli_affected_rows( $dbh );
	}
	/* --------------------------------------------------------- */
	function registrarVoto( $dbh, $voto ){
		//Guarda un nuevo registro de voto

		$q = "insert into voto ( idUSUARIO, idNOMINACION, valor, fecha_voto ) 
		values ( $voto[idusuario], $voto[idnominacion], '$voto[voto]', NOW() )";
		
		$data = mysqli_query( $dbh, $q );

		return mysqli_affected_rows( $dbh );
	}
	/* --------------------------------------------------------- */
	function registrarEvaluacion( $dbh, $evaluacion, $cierre ){
		//Actualiza una nominación con los datos de su evaluación
		$fc = "";
		if( $cierre ) $fc = ", fecha_cierre = NOW() ";
		
		$q = "update nominacion set idADMIN = $evaluacion[idusuario], 
		estado = '$evaluacion[estado]', comentario = '$evaluacion[comentario]'$fc 
		where idNOMINACION = $evaluacion[idnominacion]";
		
		$data = mysqli_query( $dbh, $q );

		return mysqli_affected_rows( $dbh );
	}
	/* --------------------------------------------------------- */
	function esVotada( $dbh, $idu, $idn ){
		//Devuelve si una nominación fue votada por un usuario
		$votada = false;

		$q = "select idUSUARIO, idNOMINACION from voto 
		where idUSUARIO = $idu and idNOMINACION = $idn";
		
		$nrows 	= mysqli_num_rows( mysqli_query ( $dbh, $q ) );
		if( $nrows > 0 ) 
			$votada = true;

		return $votada;
	}
	/* --------------------------------------------------------- */
	function obtenerVotosNominacion( $dbh, $idn, $cond ){
		//Devulve la cantidad de registros de votos de una nominación
		$c["todos"] = "";
		$c["si"] = "and valor = 'si'";
		$c["no"] = "and valor = 'no'";

		$q = "select count( idNOMINACION ) as votos from voto 
				where idNOMINACION = $idn $c[$cond]";

		$data = mysqli_query( $dbh, $q );
		$cant = mysqli_fetch_array( $data );
		
		return $cant["votos"];
	}
	/* --------------------------------------------------------- */
	function contarVotos( $dbh, $idn ){
		//Devuelve la cantidad de votos totales, y votos por cada opción
		$votacion["votos"] 	= obtenerVotosNominacion( $dbh, $idn, 'todos' );
		$votacion["si"] 	= obtenerVotosNominacion( $dbh, $idn, 'si' );
		$votacion["no"] 	= obtenerVotosNominacion( $dbh, $idn, 'no' );

		return $votacion;
	}
	/* --------------------------------------------------------- */
	function adjudicarNominacion( $dbh, $idn ){
		// Adjudica una nominación al nominado: hace disponible los coins
		$q = "update nominacion set estado = 'adjudicada', 
		fecha_adjudicacion = NOW() where idNOMINACION = $idn";
		
		mysqli_query( $dbh, $q );
		return mysqli_affected_rows( $dbh );
	}
	/* --------------------------------------------------------- */
	// Solicitudes asíncronas
	/* --------------------------------------------------------- */
	if( isset( $_POST["nva_nominacion"] ) ){
		//Solicitud para registrar una nueva nominación

		include( "bd.php" );

		$nominacion["idnominador"] 	= $_POST["nva_nominacion"];
		$nominacion["idnominado"] 	= $_POST["id_persona"];
		$nominacion["idatributo"] 	= $_POST["atributo"];
		$nominacion["valor"] 		= $_POST["valor_atributo"];
		$nominacion["motivo"] 		= $_POST["motivo"];
		$nominacion["sustento"]		= "";
		$nominacion["estado"] 		= "pendiente";

		if( isset( $_FILES["archivo"] ) ){
			$archivo = cargarArchivo( $_FILES["archivo"], RUTA_SUSTENTOS );
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
	if( isset( $_POST["votar"] ) ){
		//Solicitud para registrar un voto sobre nominación
		include( "bd.php" );

		parse_str( $_POST["votar"], $voto );
		$id = registrarVoto( $dbh, $voto );
		
		if( ( $id != 0 ) && ( $id != "" ) ){
			$res["exito"] = 1;
			$res["mje"] = "Voto registrado con éxito";
		} else {
			$res["exito"] = 0;
			$res["mje"] = "Error al registrar voto";
		}
		echo json_encode( $res );
	}
	/* --------------------------------------------------------- */
	if( isset( $_POST["evaluar"] ) ){
		//Solicitud para registrar un voto sobre nominación
		include( "bd.php" );

		parse_str( $_POST["evaluar"], $evaluacion );
		if( $evaluacion["estado"] == "sustento" ) $cierre = false;
		else $cierre = true;

		$rsp = registrarEvaluacion( $dbh, $evaluacion, $cierre );
		
		if( ( $rsp != 0 ) && ( $rsp != "" ) ){
			$res["exito"] = 1;
			$res["mje"] = "Evaluación registrada con éxito";
		} else {
			$res["exito"] = 0;
			$res["mje"] = "Error al registrar evaluación";
		}
		echo json_encode( $res );
	}
	/* --------------------------------------------------------- */
	if( isset( $_POST["seg_sustento"] ) ){
		//Solicitud para registrar segundo sustento sobre nominación

		include( "bd.php" );

		$nominacion["idnominacion"] = $_POST["seg_sustento"];
		$nominacion["motivo2"] 		= $_POST["motivo2"];
		$nominacion["sustento2"]	= "";

		if( isset( $_FILES["archivo"] ) ){
			$archivo = cargarArchivo( $_FILES["archivo"], RUTA_SUSTENTOS );
			if( $archivo["exito"] == 1 )
				$nominacion["sustento2"] = $archivo["ruta"];
		}
		
		$rsp = agregarSustento( $dbh, $nominacion );
		
		if( ( $rsp != 0 ) && ( $rsp != "" ) ){
			$res["exito"] = 1;
			$res["mje"] = "Registro de sustento exitoso";			
		} else {
			$res["exito"] = 0;
			$res["mje"] = "Error al registrar sustento";
		}

		echo json_encode( $res );
	}
	/* --------------------------------------------------------- */
	if( isset( $_POST["adjudicar"] ) ){
		//Solicitud para adjudicar una nominación
		include( "bd.php" );
		
		$rsp = adjudicarNominacion( $dbh, $_POST["adjudicar"] );
		
		if( ( $rsp != 0 ) && ( $rsp != "" ) ){
			$res["exito"] = 1;
			$res["mje"] = "Nominación adjudicada";			
		} else {
			$res["exito"] = 0;
			$res["mje"] = "Error al adjudicar nominación";
		}

		echo json_encode( $res );
	}
?>