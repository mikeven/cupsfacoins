// Nominaciones
/*
 * fn-nominaciones.js
 *
 */
/* --------------------------------------------------------- */	
/* --------------------------------------------------------- */

(function() {

	'use strict';

	// basic
	$("#frm_nnominacion").validate({
		highlight: function( label ) {
			$(label).closest('.form-group').removeClass('has-success').addClass('has-error');
		},
		success: function( label ) {
			$(label).closest('.form-group').removeClass('has-error');
			label.remove();
		},
		errorPlacement: function( error, element ) {
			var placement = element.closest('.input-group');
			if (!placement.get(0)) {
				placement = element;
			}
			if (error.text() !== '') {
				placement.after(error);
			}
		}
	});

	// validation summary
	var $summaryForm = $("#summary-form");
	$summaryForm.validate({
		errorContainer: $summaryForm.find( 'div.validation-message' ),
		errorLabelContainer: $summaryForm.find( 'div.validation-message ul' ),
		wrapper: "li"
	});


}).apply( this, [ jQuery ]);

$('.modal-with-move-anim').magnificPopup({
	type: 'inline',

	fixedContentPos: false,
	fixedBgPos: true,

	overflowY: 'auto',

	closeBtnInside: true,
	preloader: false,
	
	midClick: true,
	removalDelay: 300,
	mainClass: 'my-mfp-slide-bottom',
	modal: true
});

/* --------------------------------------------------------- */
function votar(){
	//Invoca al servidor para registrar el voto del usuario
	var fs = $('#nvoto').serialize();

	$.ajax({
        type:"POST",
        url:"database/data-nominaciones.php",
        data:{ votar: fs  },
        success: function( response ){
        	console.log( response );
			res = jQuery.parseJSON( response );
			if( res.exito == 1 ){
				$("#panel_voto").fadeOut(360);
				$("#panel_resultado").fadeIn(4000);
				notificar( "Votación", res.mje, "success" );
			}
			else
				notificar( "Votación", res.mje, "error" );
        }
    });	
}
/* --------------------------------------------------------- */
$("#atributo").on('change', function (e) {
	// Asigna el valor del atributo de la lista al campo oculto
	var valor = $( 'option:selected', $(this) ).attr("data-v");
	$("#valattr").val( valor );
});

$(".sel_persona").on('click', function (e) {
	// Asigna el valor del id de la persona seleccionada al campo oculto, 
	// muestra el nombre de la persona seleccionada y cierra la ventana emergente
	var idp = $(this).attr("data-idp");
	$("#idpersona").val( idp );
	$("#persona_seleccion").val( $(this).html() );
	$("#btn_cerrar_usuarios").click();
	$("#persona_seleccion").focus();
});

/* --------------------------------------------------------- */ 
$('#frm_nnominacion').ajaxForm({ 
	// Invocación asíncrona del registro de una nominación nueva a través del formulario
	//parámetro de invocación: nva_nominacion

    type: 		"POST",
    url:        'database/data-nominaciones.php', 
    success:    function(response) { 
    	console.log(response);
    	res = jQuery.parseJSON( response );
    	if( res.exito == 1 ){
    		var idr = res.reg.id;
    		enviarRespuesta( res, "redireccion", "nominacion.php?id=" + idr );
    	}
    }
});
/* --------------------------------------------------------- */ 
$("#frm_nnominacion").on('submit', function(e) {
	// Evita el envío del formulario para checar su validez
    if ( $("#frm_nnominacion").valid() ) {
        e.preventDefault();
    }
});
/* --------------------------------------------------------- */ 
$(".sel_panel_nom").on('click', function (e) {
	// 
	var orig = $(this).attr("data-i");
	var dest = $(this).attr("data-d");
	$(orig).fadeOut(300);
	$(dest).fadeIn(300);
});
/* --------------------------------------------------------- */ 
$(".cnf-voto").on('click', function (e) {
	// Asigna el valor del voto seleccionado y destaca la opción seleccionada
	$(".cnf-voto").removeClass("game_now");
	$(this).addClass("game_now");
	var valor = $(this).attr("data-valor");
	$("#valor_voto").val(valor);
	$("#confirmar_seleccion").fadeIn(300);

});
/* --------------------------------------------------------- */ 
$("#btn_votar").on('click', function (e) {
	// Invoca el registro de la votación hecha
	votar();
});

$(".adminev").on('click', function (e) {
	// Muestra el panel de comentario de administrador
	$(".panel_comentario").fadeIn(300);
});
/* --------------------------------------------------------- */ 