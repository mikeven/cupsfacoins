<?php 
	/* --------------------------------------------------------- */
	/* Cupfsa Coins - Funciones auxiliares sobre nominaciones */
	/* --------------------------------------------------------- */
	/* --------------------------------------------------------- */
	
	/* --------------------------------------------------------- */
	function esVotable( $dbh, $idu, $nominacion ){
		// Devuelve verdadero/falso sobre si el usuario puede votar una nominación
		$vota = false;
		if( !esVotada( $dbh, $idu, $nominacion["idNOMINACION"] ) 
			&& ( $nominacion["estado"] == "pendiente" || 
				 $nominacion["estado"] == "sustento" ) ){
			$vota = true;
		}
		return $vota;
	}
	/* --------------------------------------------------------- */
	function enlaceVerNominacion( $dbh, $idu, $nom ){
		// Devuelve el enlace correspondiente a una nominación segun rol/estado 
		// de votación
		if( isV( "en_votar" ) ){ 	// Acceso a votación
			if( esVotable( $dbh, $idu, $nom ) )
				$enl = '<i class="fa fa-hand-o-down"></i> Votar</a>';
			else
				$enl = '<i class="fa fa-eye"></i> Ver</a>';
		}
		if( isV( "en_ver_nom" ) ) 	// Acceso a ver nominaciones
			$enl = '<i class="fa fa-eye"></i> Ver</a>';
		
		return $enl;
	}
	/* --------------------------------------------------------- */
	function estadoNominacion( $estado ){
		// Devuelve la etiqueta de estado de nominación según valor
		$etiquetas = array(
			"pendiente" 	=> "Pendiente",
			"sustento"		=> "Espera por sustento",
			"aprobada"		=> "Aprobada",
			"rechazada"		=> "Rechazada",
			"adjudicada"	=> "Adjudicada"
		);

		return $etiquetas[$estado];
	}	
	/* --------------------------------------------------------- */
	function iconoEstadoNominacion( $estado ){
		// Devuelve el ícono de estado de nominación según valor
		$iconos = array(
			"pendiente" 	=> "<i class='fa fa-clock-o'></i>",
			"sustento"		=> "<i class='fa fa-file-o'></i>",
			"aprobada"		=> "<i class='fa fa-check-square-o'></i>",
			"rechazada"		=> "<i class='fa fa-times'></i>",
			"adjudicada"	=> "<i class='fa fa-gift'></i>"
		);

		return $iconos[$estado];
	}
	/* --------------------------------------------------------- */
	function claseEstadoNominacion( $estado ){
		// Devuelve la clase para asignar fondo de nominaciones según estado
		$iconos = array(
			"pendiente" 	=> "bg-primary",
			"sustento"		=> "bg-warning",
			"aprobada"		=> "bg-success",
			"rechazada"		=> "bg-secondary",
			"adjudicada"	=> "bg-quartenary"
		);

		return $iconos[$estado];
	}
	/* --------------------------------------------------------- */
	function nominacionVisible( $idu, $nominacion ){
		// Devuelve verdadero si el contenido de una nominación es visible según perfil y estado
		$visible = false;

		if( $nominacion == NULL ) return false;

		// Si es perfil colaborador siendo nominador o nominado con nominación aprobada
		if( isV( 'pan_nom_apoyo' ) && (( $nominacion["idNOMINADOR"] == $idu ) || 
										(	$nominacion["idNOMINADO"] == $idu && 
											$nominacion["estado"] == "aprobada" ) ) )
			$visible = true;

		// Perfiles administrador o evaluador
		if( isV( 'en_aprob_nom' ) || isV( 'en_votar' ) ) $visible = true;

		return $visible;
	}
	/* --------------------------------------------------------- */
	function obtenerNombreTitulo( $p ){
		// Devuelve el texto complementario para mostrar en la página de nominaciones
		$titulo = "";
		if( $p == "hechas" || $p == "recibidas" )
			$titulo = $p;

		return $titulo;
	}
	/* --------------------------------------------------------- */
	function obtenerListadoNominaciones( $dbh, $idu ){
		// Devuelve los registros de nominaciones de acuerdo al perfil para mostrar en la página de nominaciones

		if( isV( 'mp_nom_pers' ) ){ 		// Acceso a nominaciones hechas/recibidas
			if( isset( $_GET["param"] ) ){
				$data["titulo"] = obtenerNombreTitulo( $_GET["param"] );
				$data["nominaciones"] = obtenerNominacionesAccion( $dbh, $idu, $_GET["param"] );
			}else{
				$data["titulo"] = obtenerNombreTitulo( "hechas" );
				$data["nominaciones"] = obtenerNominacionesAccion( $dbh, $idu, "hechas" );
			}
		}
		if( isV( 'ver_tnominac' ) ){		// Acceso a ver todas las nominaciones
			$data["titulo"] = obtenerNombreTitulo( "" );
			$data["nominaciones"] = obtenerNominacionesRegistradas( $dbh );
		}

		return $data;
	}
	/* --------------------------------------------------------- */
?>