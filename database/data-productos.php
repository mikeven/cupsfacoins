<?php
	/* --------------------------------------------------------- */
	/* Cupfsa Coins - Datos sobre productos */
	/* --------------------------------------------------------- */
	/* --------------------------------------------------------- */

	define( "RUTA_CATALOGO", "../upload/productos/" );

	/* --------------------------------------------------------- */
	function obtenerProductoPorId( $dbh, $idp ){
		//Devuelve el registro de una nominacion dado su id
		$q = "select idPRODUCTO, nombre, descripcion, valor, imagen,  
		date_format(fecha_creacion,'%d/%m/%Y') as fregistro from producto where 
		idPRODUCTO = $idp";
		
		$data = mysqli_query( $dbh, $q );
		return mysqli_fetch_array( $data );
	}
	/* --------------------------------------------------------- */
	function obtenerProductosRegistrados( $dbh ){
		//Devuelve todos los registros de productos
		$q = "select idPRODUCTO, nombre, descripcion, valor, imagen,  
		date_format(fecha_creacion,'%d/%m/%Y') as fregistro from producto 
		order by nombre asc";
		
		$data = mysqli_query( $dbh, $q );

		return obtenerListaRegistros( $data );
	}
	/* --------------------------------------------------------- */
	function nombrePrefijo(){
		// Devuelve un prefijo de nombre a un archivo basado en una marca de tiempo
		return date_timestamp_get( date_create() );
	}
	/* --------------------------------------------------------- */
	function agregarProducto( $dbh, $producto ){
		// Guarda un nuevo registro de nominación

		$q = "insert into producto ( nombre, valor, descripcion, imagen, fecha_creacion ) 
		values ( '$producto[nombre]', $producto[valor], '$producto[descripcion]', 
		'$producto[imagen]', NOW() )";
		
		$data = mysqli_query( $dbh, $q );
		return mysqli_insert_id( $dbh );
	}
	/* --------------------------------------------------------- */
	function agregarCanje( $dbh, $canje ){
		// Guarda el registro de un caje de producto
		$q = "insert into canje ( idUSUARIO, idPRODUCTO, valor, fecha_canje ) 
		values ( $canje[idusuario], $canje[idproducto], $canje[valor], NOW() )";

		$data = mysqli_query( $dbh, $q );
		return mysqli_insert_id( $dbh );
	}
	/* --------------------------------------------------------- */
	function obtenerCanjesRegistrados( $dbh, $idu ){
		// Devuelve los registros de canjes de un usuario. Si no se especifica id de usuario, retorna todos los registros.
		$sq = "";
		if( $idu != "" ) $sq = "and c.idUSUARIO = $idu";
		$q = "select c.idCANJE, c.idUSUARIO, c.idPRODUCTO, c.valor, 
		date_format(c.fecha_canje,'%d/%m/%Y') as fregistro, u.nombre, u.apellido, 
		p.nombre as producto from canje c, usuario u, producto p  
		where u.idUSUARIO = c.idUSUARIO and c.idPRODUCTO = p.idPRODUCTO $sq 
		order by c.fecha_canje desc";
		
		$data = mysqli_query( $dbh, $q );

		return obtenerListaRegistros( $data );
	}
	/* --------------------------------------------------------- */
	// Solicitudes asíncronas
	/* --------------------------------------------------------- */

	if( isset( $_POST["form_np"] ) ){
		//Solicitud para registrar nuevo producto

		include( "bd.php" );	
		
		parse_str( $_POST["form_np"], $producto );
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
	/* --------------------------------------------------------- */
	if( isset( $_POST["form_ncje"] ) ){
		//Solicitud para registrar nuevo canje de producto

		include( "bd.php" );
		
		parse_str( $_POST["form_ncje"], $canje );
		$id = agregarCanje( $dbh, $canje );
		
		if( ( $id != 0 ) && ( $id != "" ) ){
			$res["exito"] = 1;
			$res["mje"] = "Canje realizado con éxito";
		} else {
			$res["exito"] = 0;
			$res["mje"] = "Error al canjear producto";
		}

		echo json_encode( $res );
	}
	/* --------------------------------------------------------- */
	if ( !empty( $_FILES ) ) {
		$url = "";

		$tempFile = $_FILES['file']['tmp_name'];     
    	$prefijo = nombrePrefijo();
    	$targetFile =  RUTA_CATALOGO . $prefijo ."-". $_FILES['file']['name'];
 
    	if( move_uploaded_file( $tempFile, $targetFile ) )
    		$url = substr( $targetFile, 3 );

    	echo $url;
	}
?>