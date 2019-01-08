<?php
    /*
     * Cupfsa Coins - Nominaciones
     * 
     */
    session_start();
    $pagina = "pg_nominacion";
    ini_set( 'display_errors', 1 );
    include( "database/bd.php" );
    include( "database/data-nominaciones.php" );
    include( "database/data-acceso.php" );
    include( "fn/fn-acceso.php" );

    isAccesible( $pagina );
    $idu = $_SESSION["user"]["idUSUARIO"];
    if( isset( $_GET["id"] ) )
    	$idn = $_GET["id"];
?>
<!doctype html>
<html class="fixed">
	<head>
		<!-- Basic -->
		<meta charset="UTF-8">

		<title>Nominación :: Cupfsa Coins</title>
		<meta name="keywords" content="HTML5 Admin Template" />
		<meta name="description" content="Porto Admin - Responsive HTML5 Template">
		<meta name="author" content="okler.net">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

		<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/select2/select2.css" />
		<link rel="stylesheet" href="assets/vendor/pnotify/pnotify.custom.css" />
		<link rel="stylesheet" href="assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

		<style type="text/css">
			.seleccion_opcion{
				padding: 12px; 
			}

			.game_nows{
				-webkit-border-radius: 7px;
				-moz-border-radius: 7px;
				border-radius: 7px;
				-webkit-animation-name: gtoday;  /* Safari and Chrome */
				-webkit-animation-duration: 0.5s;  /* Safari and Chrome */
				-webkit-animation-iteration-count: infinite; /* Safari and Chrome */
		    	animation-iteration-count: infinite;
			}
			
			@-webkit-keyframes gtoday {
				from {
					padding: 0px 0px; 
				}
				to {
					padding: 12px 16px; 
				}
			}

			.game_now {
				-webkit-animation: zoom-in-out 1s linear 0s infinite normal ;
 				animation: zoom-in-out 1s linear 0s infinite normal ;
			}

			@-webkit-keyframes zoom-in-out {			
				0%{
					-webkit-transform: scale(1);
					transform: scale(1);
				}
			  	50%{
					-webkit-transform: scale(1.2);
					transform: scale(1.2);
			  	}
			  	100%{
					-webkit-transform: scale(1);
					transform: scale(1);
			  	}
			}

			@keyframes zoom-in-out {
				0%{
					-ms-transform: scale(1);
					transform: scale(1);
			  	}	
			  	50%{
					-ms-transform: scale(1.2);
					transform: scale(1.2);
			  	}
			  	100%{
					-ms-transform: scale(1);
					transform: scale(1);
			  	}
			}
		</style>

		<!-- Head Libs -->
		<script src="assets/vendor/modernizr/modernizr.js"></script>
	</head>
	<?php 
		$votacion = contarVotos( $dbh, $idn );
		$nominacion = obtenerNominacionPorId( $dbh, $idn );
		if( isV( 'en_votar' ) ) { //Evaluador
			$votada = esVotada( $dbh, $idu, $idn );
		}
	?>
	<body>
		<section class="body">

			<!-- start: header -->
			<?php include( "sections/header.php" );?>
			<!-- end: header -->

			<div class="inner-wrapper">
				<!-- start: sidebar -->
				<?php include( "sections/left-sidebar.php" );?>
				<!-- end: sidebar -->

				<section role="main" class="content-body">
					<header class="page-header">
						<h2><i class="fa fa-bookmark"></i> Nominación</h2>
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.php">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span><a href="nominaciones.php">Nominaciones</a></span></li>
								<li><span>Nominación</span></li>
							</ol>
					
							<a class="sidebar-right-toggle" data-open=""></a>
						</div>
					</header>
					<!-- start: page -->
					
					<div class="col-sm-6 col-xs-6">
						<section class="panel">
							<header class="panel-heading bg-primary">
								<div class="panel-heading-icon">
									<i class="fa fa-bookmark"></i>
								</div>
							</header>
							<div class="panel-body text-center">
								<h3 class="text-semibold mt-sm text-center">
									<?php echo $nominacion["atributo"]; ?>
								</h3>
								<p class="text-center">
									<?php echo $nominacion['valor']." coins"; ?>
								</p>
								<h4 class="text-semibold mt-sm text-center">
								<?php echo $nominacion["nombre2"]." ".
												$nominacion["apellido2"]; ?>
								</h4>
								<hr class="solid short">
								<!-- ------------------------------ SUSTENTO -->
								<div class="form-group">
									<label class="col-sm-4">Motivo: </label>
									<div class="col-sm-8 text-left">
										<?php echo $nominacion["motivo1"]; ?>
									</div>
								</div>
								<div class="form-group">
									<?php if( $nominacion["sustento1"] != "" ) { ?>
									<div class="col-sm-4"></div>
									<div class="col-sm-8 text-left">
										<a href="<?php echo $nominacion["sustento1"]; ?>" target="_blank">
										<i class="fa fa-file-text-o"></i> Sustento </a>
									</div>
									<?php } ?>
								</div>
								<!-- ------------------------------ SUSTENTO -->
								<?php if( $nominacion["motivo2"] != "" ) { ?>
								<div class="form-group">
									<label class="col-sm-4">Motivo 2: </label>
									<div class="col-sm-8 text-left">
										<?php echo $nominacion["motivo2"]; ?>
									</div>
								</div>
								<?php } ?>
								
								<?php if( $nominacion["sustento2"] != "" ) { ?>
								<div class="form-group">
									<div class="col-sm-4"></div>
									<div class="col-sm-8 text-left">
										<a href="<?php echo $nominacion["sustento2"]; ?>" target="_blank">
										<i class="fa fa-file-text-o"></i> Sustento 2 </a>
									</div>
								</div>
								<?php } ?>
								
								<div class="form-group">
									<label class="col-sm-4">Nominado por: </label>
									<div class="col-sm-8 text-left">
										<?php echo $nominacion["nombre1"]." ".
												$nominacion["apellido1"]; ?>
									</div>
								</div>
								<!-- ------------------------------ SUSTENTO -->
								<?php
									if( isV( 'en_votar' ) ) { 		//Evaluador
										include( "sections/panel_voto.php" );
									}
									if( isV( 'en_aprob_nom' ) ) { 	//Administrador
										include( "sections/panel_aprobacion.php" );
									}
									if( isV( 'pan_nom_aprob' ) ) { 	//Colaborador 
										include( "sections/panel_nominacion_aprobada.php" );
									}
								?>
							</div>
							<!-- ---------------------------------------- PIE FORMULARIOS -->
							<?php if( isV( 'en_aprob_nom' ) ) { 	//Administrador ?>	
							<footer class="panel-footer panel_comentario" style="display: none;">
								<div class="row">
									<div class="col-sm-12" align="right">
										<button id="btn_evaladmin" onclick="evaluar()" 
										class="btn btn-primary">Enviar</button>
									</div>
								</div>
							</footer>
							<?php } ?>
							<!-- ---------------------------------------- PIE FORMULARIOS -->
							<?php if( isV( 'pan_nom_aprob' ) ) { 	//Administrador 	
									if ( $nominacion["estado"] == "sustento" 
									  && $nominacion["idNOMINADOR"] == $idu ) { 
								// Perfil colaborador, nominación pendiente por segundo sustento, 
								// Usuario en sesión = nominador de la actual nominación
							?>
							<footer class="panel-footer panel_sustento2">
								<div class="row">
									<div class="col-sm-12" align="right">
										<button id="btn_sustento2" onclick="sustento2()" 
										class="btn btn-primary">Enviar</button>
									</div>
								</div>
							</footer>
							<?php } } ?>
							<!-- ---------------------------------------- PIE FORMULARIOS -->
						</section>
					</div>
					<?php if( isV( "result_nom" ) || ( isV( "en_votar" ) && ( $votada ) ) ) { ?>
						<div class="col-sm-6 col-xs-6">
							<section class="panel">
								<header class="panel-heading">
									<h2 class="panel-title">Resultados</h2>
									<p class="panel-subtitle">
										Votación final: <?php echo $votacion["votos"]; ?> votos
									</p>
								</header>
								<div class="panel-body text-center">
									<div class="chart chart-md" id="flotPie"></div>
									<div id="detalle_resuktados">
										<div class="col-sm-6" style="color: #47a447;">
											<i class="fa fa-thumbs-up"></i>
											Sí: <?php echo $votacion["si"]; ?>
										</div>
										<div class="col-sm-6" style="color: #d64742;">
											<i class="fa fa-thumbs-down"></i>
											No: <?php echo $votacion["no"]; ?>
										</div>
									</div>
											
									<script type="text/javascript">
							
										var flotPieData = [{
											label: "Sí",
											data: [
												[1, <?php echo $votacion["si"]; ?>]
											],
											location_value: "Majiwada,Pune",
											color: '#47a447'
										}, {
											label: "No",
											data: [
												[1, <?php echo $votacion["no"]; ?>]
											],
											location_value: "2222",
											color: '#d64742'
										}];
					
									</script>
								</div>
							</section>
						</div>
					<?php } ?>	
					<!-- end: page -->
				</section>
			</div>

		</section>

		<!-- Vendor -->
		<script src="assets/vendor/jquery/jquery.js"></script>
		<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="assets/vendor/jquery-form/jquery.form.js"></script>
		<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<!-- Specific Page Vendor -->
		<script src="assets/vendor/select2/select2.js"></script>
		<script src="assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
		<script src="assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
		<script src="assets/vendor/pnotify/pnotify.custom.js"></script>
		<script src="assets/vendor/flot/jquery.flot.js"></script>
		<script src="assets/vendor/flot-tooltip/jquery.flot.tooltip.js"></script>
		<script src="assets/vendor/flot/jquery.flot.pie.js"></script>
		<script src="assets/vendor/jquery-validation/jquery.validate.js"></script>
		<script src="assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>

		<!-- Func. particular -->
		<script src="js/fn-ui.js"></script>
		<script src="js/fn-nominaciones.js"></script>
		<script src="js/tabla-nominaciones.js"></script>
		<?php if( isV( "result_nom" ) || ( isV( "en_votar" ) && ( $votada ) ) ) { ?>
		<script>
			/*
			Flot: Pie
			*/
			(function() {
				var plot = $.plot('#flotPie', flotPieData, {
					series: {
						pie: {
							show: true,
							combine: {
								color: '#999',
								threshold: 0.05
							}
						}
					},
					legend: {
						show: false
					},
					grid: {
						hoverable: true,
						clickable: true
					}
				});
			})();
		</script>
		<?php } ?>
	</body>
</html>