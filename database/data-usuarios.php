<?php
	/* --------------------------------------------------------- */
	/* Cupfsa Coins - Datos sobre usuarios */
	/* --------------------------------------------------------- */
	/* --------------------------------------------------------- */
	function obtenerUsuarioPorId( $dbh, $id_u ){
		// Devuelve el registro de un usuario dado su id
		$q = "select idUSUARIO, nombre, apellido, email, cargo, 
		activo, date_format(fecha_creacion,'%d/%m/%Y') as fregistro 
		from usuario where idUSUARIO = $id_u";

		return mysqli_fetch_array( mysqli_query ( $dbh, $q ) );
	}
	/* --------------------------------------------------------- */
	function obtenerUsuariosRegistrados( $dbh ){
		// Devuelve todos los registros de usuarios
		$q = "select idUSUARIO, nombre, apellido, email, cargo, 
		activo, date_format(fecha_creacion,'%d/%m/%Y') as fregistro 
		from usuario order by nombre asc";
		
		$data = mysqli_query( $dbh, $q );

		return obtenerListaRegistros( $data );
	}
	/* --------------------------------------------------------- */
	function obtenerRolesRegistrados( $dbh ){
		// Devuelve todos los registros de usuarios
		$q = "select idROL, nombre, descripcion from rol";
		
		$data = mysqli_query( $dbh, $q );

		return obtenerListaRegistros( $data );
	}
	/* --------------------------------------------------------- */
	function rolesUsuario( $dbh, $idu ){
		// Devuelve los registros de roles de un usuario
		$q = "select r.idROL, r.nombre from rol r, usuario_rol ur 
		where ur.idROL = r.idROL and ur.idUSUARIO = $idu";
		
		$data = mysqli_query( $dbh, $q );
		$lista = obtenerListaRegistros( $data );
		return $lista;
	}
	/* --------------------------------------------------------- */
	function agregarUsuario( $dbh, $usuario ){
		// Guarda el registro de un usuario nuevo
		$q = "insert into usuario ( nombre, apellido, email, cargo, activo, 
		fecha_creacion ) values ( '$usuario[nombre]', '$usuario[apellido]', 
		'$usuario[email]', '$usuario[cargo]', 1, NOW() )";

		$data = mysqli_query( $dbh, $q );
		return mysqli_insert_id( $dbh );
	}
	/* --------------------------------------------------------- */
	function editarUsuario( $dbh, $usuario ){
		// Actualiza los datos de un usuario
		$q = "update usuario set nombre = '$usuario[nombre]', apellido = '$usuario[apellido]', 
		email = '$usuario[email]', cargo = '$usuario[cargo]', fecha_modificado = NOW() 
		where idUSUARIO = $usuario[idusuario]";
		
		$data = mysqli_query( $dbh, $q );
		return mysqli_affected_rows( $dbh );
	}
	/* --------------------------------------------------------- */
	function agregarAsociacionRolUsuario( $dbh, $idu, $idr ){
		// Registra la asociación de un usuario con su rol
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
		// Asigna cada rol asociado a un usuario para su registro
		foreach ( $usuario["rol"] as $rol ) {
			agregarAsociacionRolUsuario( $dbh, $usuario["idusuario"], $rol );
		}
	}
	/* --------------------------------------------------------- */
	function desvincularRolesUsuario( $dbh, $usuario ){
		// Elimina todos los roles que posee un registro de usuario
		$q = "delete from usuario_rol where idUSUARIO = $usuario[idusuario]";
		$data = mysqli_query( $dbh, $q );
		return mysqli_affected_rows( $dbh ); 
	}
	/* --------------------------------------------------------- */
	if( isset( $_POST["form_nu"] ) ){
		// Solicitud para registrar nuevo usuario

		include( "bd.php" );	
		
		parse_str( $_POST["form_nu"], $usuario );
		$usuario = escaparCampos( $dbh, $usuario );
		$id = agregarUsuario( $dbh, $usuario );
		$usuario["idusuario"] = $id;
		
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
	/* --------------------------------------------------------- */
	if( isset( $_POST["form_mu"] ) ){
		// Solicitud para modificar usuario

		include( "bd.php" );	
		
		parse_str( $_POST["form_mu"], $usuario );
		
		$usuario = escaparCampos( $dbh, $usuario );
		$rsp = editarUsuario( $dbh, $usuario );
		
		if( ( $rsp != 0 ) && ( $rsp != "" ) ){
			desvincularRolesUsuario( $dbh, $usuario );
			asociarRolesUsuario( $dbh, $usuario );
			$res["exito"] = 1;
			$res["mje"] = "Datos de usuario actualizados";
			$res["reg"] = $usuario;
		} else {
			$res["exito"] = 0;
			$res["mje"] = "Error al modificar usuario";
			$res["reg"] = NULL;
		}

		echo json_encode( $res );
	}
?>