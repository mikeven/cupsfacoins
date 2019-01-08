<?php
    /*
     * Cupfsa Coins - Nominaciones
     * 
     */
    session_start();
    $pagina = "pg_nominaciones";
    ini_set( 'display_errors', 1 );
    
    include( "database/bd.php" );
    include( "database/data-acceso.php" );
    include( "database/data-nominaciones.php" );
    include( "fn/fn-acceso.php" );
    include( "fn/fn-nominaciones.php" );
    $idu = $_SESSION["user"]["idUSUARIO"];
    isAccesible( $pagina );
?>
<!doctype html>
<html class="fixed">
	<head>
		<!-- Basic -->
		<meta charset="UTF-8">

		<title>Nominaciones :: Cupfsa Coins</title>
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
		<link rel="stylesheet" href="assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="assets/vendor/modernizr/modernizr.js"></script>
	</head>
	<?php 
		if( isset( $_GET["param"] ) ){
			$nominaciones = obtenerNominacionesAccion( $dbh, $idu, $_GET["param"] );
		}
		else{
			$nominaciones = obtenerNominacionesAccion( $dbh, $idu, "hechas" );
		}
		if( isV( 'en_votar' ) )
			$nominaciones = obtenerNominacionesAccion( $dbh, $idu, "votar" );
		if( isV( 'ver_tnominac' ) )
			$nominaciones = obtenerNominaciones( $dbh );
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
						<h2><i class="fa fa-bookmark"></i> Nominaciones</h2>
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.php">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Nominaciones</span></li>
							</ol>
					
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>
					<!-- start: page -->
					<div id="nom_paneles">
						<h5>
							<a href="#!" class="sel_panel_nom" data-i="#nom_paneles" 
							data-d="#nom_tabla">
							<i class="fa fa-table"></i> Ver tabla</a>
						</h5>
						
						<?php foreach ( $nominaciones as $nom ) { 
							$enl = enlaceVerNominacion();//
						?>
							<div class="col-sm-6 col-xs-6">
								<section class="panel panel-horizontal">
									<header class="panel-heading bg-primary" style="width: 30%;">
										<div class="panel-heading-icon">
											<i class="fa fa-bookmark"></i>
										</div>
									</header>
									<div class="panel-body p-lg" style="width: 70%;">
										<h4 class="text-semibold mt-sm">
											<?php echo $nom["nombre2"]." ".
														$nom["apellido2"]; ?>
										</h4>
										<h5 class=""><?php echo $nom["atributo"]?></h5>
										<p>
											<a href="nominacion.php?id=<?php echo $nom["id"];?>">
											<?php echo $enl; ?>
										</p>
									</div>
								</section>
							</div>
						<?php } ?>
					</div>
					<div id="nom_tabla" style="display: none;">
						<h5>
							<a href="#!" class="sel_panel_nom" data-i="#nom_tabla" 
							data-d="#nom_paneles">
							<i class="fa fa-th-large"></i> Ver fichas</a>
						</h5>
						<table class="table table-bordered table-striped mb-none" 
						id="datatable-tnominaciones">
							<thead>
								<tr>
									<th>Fecha</th>
									<th>Participante</th>
									<th>Atributo</th>
									<th>Valor</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ( $nominaciones as $nom ) { ?>
								<tr class="gradeX">
									<td><?php echo $nom["fregistro"]; ?></td>
									<td>
										<a href="nominacion.php?id=<?php echo $nom['id'];?>"><?php echo $nom["nombre2"]." ".$nom["apellido2"]; ?>
										</a>
									</td>
									<td><?php echo $nom["atributo"]?></td>
									<td class="actions">
										
									</td>
								</tr>
								<?php } ?>
								
							</tbody>
						</table>
					</div>
					<!-- end: page -->
				</section>
			</div>

		</section>

		<div id="dialog" class="modal-block mfp-hide">
			<section class="panel">
				<header class="panel-heading">
					<h2 class="panel-title">Are you sure?</h2>
				</header>
				<div class="panel-body">
					<div class="modal-wrapper">
						<div class="modal-text">
							<p>Are you sure that you want to delete this row?</p>
						</div>
					</div>
				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-md-12 text-right">
							<button id="dialogConfirm" class="btn btn-primary">Confirm</button>
							<button id="dialogCancel" class="btn btn-default">Cancel</button>
						</div>
					</div>
				</footer>
			</section>
		</div>

		<!-- Vendor -->
		<script src="assets/vendor/jquery/jquery.js"></script>
		<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="assets/vendor/jquery-form/jquery.form.js"></script>
		<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		<script src="assets/vendor/jquery-validation/jquery.validate.js"></script>
		
		<!-- Specific Page Vendor -->
		<script src="assets/vendor/select2/select2.js"></script>
		<script src="assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
		<script src="assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>


		<!-- Examples -->
		<!-- <script src="assets/javascripts/tables/examples.datatables.editable.js"></script> -->
		<script src="js/tabla-nominaciones.js"></script>
		<script src="js/fn-nominaciones.js"></script>
	</body>
</html>