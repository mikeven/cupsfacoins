<?php 
	/* --------------------------------------------------------- */
	/* Cupfsa Coins - Funciones auxiliares sobre nominaciones */
	/* --------------------------------------------------------- */
	/* --------------------------------------------------------- */
	
	/* --------------------------------------------------------- */
	function enlaceVerNominacion( $dbh, $idu, $nom ){
		// Devuelve el enlace correspondiente a una nominación segun rol/estado 
		// de votación
		if( isV( "en_votar" ) ){
			if( esVotada( $dbh, $idu, $nom["idNOMINACION"] ) )
				$enl = '<i class="fa fa-eye"></i> Ver</a>';
			else
				$enl = '<i class="fa fa-hand-o-down"></i> Votar</a>';
		}
		if( isV( "en_ver_nom" ) ){
			$enl = '<i class="fa fa-eye"></i> Ver</a>';
		}
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
	function nominacionVisible( $idu, $nominacion ){
		// Devuelve verdadero si el contenido de una nominación es visible según perfil y estado
		$visible = false;

		// Si es perfil colaborador siendo nominador o nominado con nominación aprobada
		if( isV( 'pan_nom_aprob' ) && (( $nominacion["idNOMINADOR"] == $idu ) || 
										(	$nominacion["idNOMINADO"] == $idu && 
											$nominacion["estado"] == "aprobada" ) ) )
			$visible = true;

		// Perfiles evaluador o administrador
		if( isV( 'en_aprob_nom' ) || isV( 'en_votar' ) ) $visible = true;

		return $visible;
	}
	/* --------------------------------------------------------- */
?>