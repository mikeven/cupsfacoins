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
function agregarNominacion(){

	/*var fs = $('#frm_nnominacion').serialize();
	var bot_reset = $("#btn_res_fnu");	*/
	alert("submit");
	
}
/* --------------------------------------------------------- */
$("#atributo").on('change', function (e) {
	var valor = $( 'option:selected', $(this) ).attr("data-v");
	$("#valattr").val( valor );
});

$(".sel_persona").on('click', function (e) {
	var idp = $(this).attr("data-idp");
	$("#idpersona").val( idp );
	$("#persona_seleccion").val( $(this).html() );
	$("#btn_cerrar_usuarios").click();
	$("#persona_seleccion").focus();
});

/* --------------------------------------------------------- */ 
$('#frm_nnominacion').ajaxForm({ 
    type: 		"POST",
    url:        'database/data-nominaciones.php', 
    success:    function(response) { 
    	res = jQuery.parseJSON( response );
    	if( res.exito == 1 ){
    		var idr = res.reg.id;
    		enviarRespuesta( res, "redireccion", "nominacion.php?id=" + idr );
    	}
    }
});

$("#frm_nnominacion").on('submit', function(e) {
    if ( $("#frm_nnominacion").valid() ) {
        e.preventDefault();
    }
});

/* --------------------------------------------------------- */ 