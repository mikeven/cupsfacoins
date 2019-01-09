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
			"pendiente" => "Pendiente",
			"aprobada"	=> "Aprobada",
			"rechazada"	=> "Rechazada",
			"sustento"	=> "Espera por sustento",
		);

		return $etiquetas[$estado];
	}	
	/* --------------------------------------------------------- */
	function iconoEstadoNominacion( $estado ){
		// Devuelve el ícono de estado de nominación según valor
		$iconos = array(
			"pendiente" => "<i class='fa fa-clock-o'></i>",
			"aprobada"	=> "<i class='fa fa-check-square-o'></i>",
			"rechazada"	=> "<i class='fa fa-times'></i>",
			"sustento"	=> "<i class='fa fa-file-o'></i>",
		);

		return $iconos[$estado];
	}
?>