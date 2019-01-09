<?php
	/* --------------------------------------------------------- */
	/* Cupfsa Coins - Datos sobre usuarios */
	/* --------------------------------------------------------- */
	/* --------------------------------------------------------- */
	function obtenerUsuariosRegistrados( $dbh ){
		//Devuelve todos los registros de usuarios
		$q = "select u.idUSUARIO, u.nombre, u.apellido, u.email, u.cargo, r.idROL, 
		u.activo, date_format(u.fecha_creacion,'%d/%m/%Y') as fregistro, 
		r.nombre as rol from usuario u, usuario_rol ur, rol r 
		where u.idUSUARIO = ur.idUSUARIO and ur.idROL = r.idROL";
		
		$data = mysqli_query( $dbh, $q );

		return obtenerListaRegistros( $data );
	}
	/* --------------------------------------------------------- */
	function obtenerRolesRegistrados( $dbh ){
		//Devuelve todos los registros de usuarios
		$q = "select idROL, nombre, descripcion from rol";
		
		$data = mysqli_query( $dbh, $q );

		return obtenerListaRegistros( $data );
	}
	/* --------------------------------------------------------- */
	function agregarUsuario( $dbh, $usuario ){
		//Guarda el registro de un usuario nuevo
		$q = "insert into usuario ( nombre, apellido, email, cargo, activo, 
		fecha_creacion ) values ( '$usuario[nombre]', '$usuario[apellido]', 
		'$usuario[email]', '$usuario[cargo]', 1, NOW() )";

		$data = mysqli_query( $dbh, $q );
		return mysqli_insert_id( $dbh );
	}
	/* --------------------------------------------------------- */
	function agregarAsociacionRolUsuario( $dbh, $idu, $idr ){
		//Registra la asociación de un usuario con su rol
		$q = "insert into usuario_rol ( idUSUARIO, idROL ) values ( $idu, $idr )";
		
		$data = mysqli_query( $dbh, $q );
	}
	/* --------------------------------------------------------- */
	function obtenerSumaAdjudicada( $dbh, $idu ){
		// Devuelve la suma acumulada de nominaciones adjudicadas por un usuario
		$q = "select sum( valor_atributo ) as coins from nominacion 
		where estado = 'adjudicada' and idNOMINADO = $idu";

		return mysqli_fetch_array( mysqli_query ( $dbh, $q ) );
	}
	/* --------------------------------------------------------- */
	function obtenerSumaCanjes( $dbh, $idu ){
		// Devuelve la suma acumulada de canjes realizados por un usuario
		$q = "select sum( valor ) as coins from canje where idUSUARIO = $idu";

		return mysqli_fetch_array( mysqli_query ( $dbh, $q ) );
	}
	/* --------------------------------------------------------- */
	function obtenerCoinsUsuario( $dbh ,$idu ){
		// Devuelve la cantidad de coins disponibles de un usuario
		$coins_adjudicados 	= obtenerSumaAdjudicada( $dbh, $idu );
		$coins_canjeados 	= obtenerSumaCanjes( $dbh, $idu );

		return $coins_adjudicados["coins"] - $coins_canjeados["coins"];
	}
	/* --------------------------------------------------------- */
	function asociarRolesUsuario( $dbh, $usuario ){
		//Asigna cada rol asociado a un usuario para su registro
		foreach ( $usuario["rol"] as $rol ) {
			agregarAsociacionRolUsuario( $dbh, $usuario["id"], $rol );
		}
	}
	/* --------------------------------------------------------- */

	if( isset( $_POST["form_nu"] ) ){
		include( "bd.php" );	
		
		parse_str( $_POST["form_nu"], $usuario );
		$id = agregarUsuario( $dbh, $usuario );
		$usuario["id"] = $id;
		
		if( ( $id != 0 ) && ( $id != "" ) ){
			asociarRolesUsuario( $dbh, $usuario );
			$res["exito"] = 1;
			$res["mje"] = "Registro de usuario exitoso";
			$res["reg"] = $usuario;
		} else {
			$res["exito"] = 0;
			$res["mje"] = "Error al registrar usuario";
			$res["reg"] = NULL;
		}

		echo json_encode( $res );
	}
?>