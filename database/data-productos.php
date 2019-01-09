<?php
	/* --------------------------------------------------------- */
	/* Cupfsa Coins - Datos sobre productos */
	/* --------------------------------------------------------- */
	/* --------------------------------------------------------- */
	function obtenerProductosRegistrados( $dbh ){
		//Devuelve todos los registros de usuarios
		$q = "select u.idUSUARIO, u.nombre, u.apellido, u.email, u.cargo, r.idROL, 
		u.activo, date_format(u.fecha_creacion,'%d/%m/%Y') as fregistro, 
		r.nombre as rol from usuario u, usuario_rol ur, rol r 
		where u.idUSUARIO = ur.idUSUARIO and ur.idROL = r.idROL";
		
		$data = mysqli_query( $dbh, $q );

		return obtenerListaRegistros( $data );
	}

	/* --------------------------------------------------------- */
	// Solicitudes asíncronas
	/* --------------------------------------------------------- */

	if( isset( $_POST["form_np"] ) ){
		include( "bd.php" );	
		
		parse_str( $_POST["form_nu"], $producto );
		$id = agregarProducto( $dbh, $producto );
		$producto["id"] = $id;
		
		if( ( $id != 0 ) && ( $id != "" ) ){
			$res["exito"] = 1;
			$res["mje"] = "Registro de producto exitoso";
			$res["reg"] = $producto;
		} else {
			$res["exito"] = 0;
			$res["mje"] = "Error al registrar producto";
			$res["reg"] = NULL;
		}

		echo json_encode( $res );
	}
?>