// Usuarios
/*
 * fn-usuarios.js
 *
 */
/* --------------------------------------------------------- */	
/* --------------------------------------------------------- */
(function() {

	'use strict';

	// basic
	$("#frm_nusuario").validate({
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

	$("#frm_nusuario").on('submit', function(e) {
        if ( $("#frm_nusuario").valid() ) {
            e.preventDefault();
            agregarUsuario();
        }
    });

	// validation summary
	var $summaryForm = $("#summary-form");
	$summaryForm.validate({
		errorContainer: $summaryForm.find( 'div.validation-message' ),
		errorLabelContainer: $summaryForm.find( 'div.validation-message ul' ),
		wrapper: "li"
	});

	// checkbox, radio and selects
	$("#chk-radios-form, #selects-form").each(function() {
		$(this).validate({
			highlight: function(element) {
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
			},
			success: function(element) {
				$(element).closest('.form-group').removeClass('has-error');
			}
		});
	});

}).apply( this, [ jQuery ]);

/* --------------------------------------------------------- */
function agregarUsuario(){

	var fs = $('#frm_nusuario').serialize();
	var bot_reset = $("#btn_res_fnu");
	var espera = "<img src='assets/images/loading.gif' width='35'>";	

	$.ajax({
        type:"POST",
        url:"database/data-usuarios.php",
        data:{ form_nu: fs },
        beforeSend: function() {
        	$("#response").html( espera );
        	$("#btn_nvo_usuario").hide( 200 );
        },
        success: function( response ){
        	console.log( response );
			res = jQuery.parseJSON( response );
			if( res.exito == 1 ){
				$( bot_reset ).click();
				notificar( "Nuevo usuario", res.mje, "success" );
			}
			else
				notificar( "Nuevo usuario", res.mje, "error" );

			$("#response").html( "" );
			$("#btn_nvo_usuario").fadeIn( 200 );
        }
    });
}
