// Productos
/*
 * fn-productos.js
 *
 */
/* --------------------------------------------------------- */	
/* --------------------------------------------------------- */
(function() {
	
	'use strict';

	// basic
	$("#frm_nproducto").validate({
		highlight: function( label ) {
			$(label).closest('.form-group').removeClass('has-success').addClass('has-error');
		},
		success: function( label ) {
			$(label).closest('.form-group').removeClass('has-error');
			label.remove();
		},
		rules: {
		    valor: {
		      digits: true
		    }
		},
		errorPlacement: function( error, element ) {
			var placement = element.closest('.input-group');
			if (!placement.get(0)) {
				placement = element;
			}
			if (error.text() !== '') {
				placement.after(error);
			}
		},
		
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
function agregarProducto(){
	// Invocación asíncrona para agregar nuevo producto
	var fs = $('#frm_nproducto').serialize();
	var espera = "<img src='assets/images/loading.gif' width='35'>";
	
	$.ajax({
        type:"POST",
        url:"database/data-productos.php",
        data:{ form_np: fs  },
        beforeSend: function() {
        	$("#response").html( espera );
        	$("#btn_nvo_prod").prop("disabled", "true");
        },
        success: function( response ){
        	console.log( response );
			res = jQuery.parseJSON( response );
			if( res.exito == 1 ){
				$("#response").fadeOut();
				var idr = res.reg.id;
    			enviarRespuesta( res, "redireccion", "producto.php?id=" + idr );
			}
			else
				notificar( "Producto", res.mje, "error" );
        }
    });
}
/* --------------------------------------------------------- */
$("#btn_nvo_prod").on('click', function (e) {
	// Invoca el envío del formulario de nuevo producto
	$("#frm_nproducto").submit();
	
});
/* --------------------------------------------------------- */
$("#frm_nproducto").on('submit', function(e) {
	// Evita el envío del formulario al ser validado
    if ( $("#frm_nproducto").valid() ) {
        e.preventDefault();
        agregarProducto();
    }
});
/* --------------------------------------------------------- */
$("#btn_canje").on('click', function (e) {
	// Invocación asíncrona para canjear producto
	var fs = $('#frm_ncanje').serialize();
	var espera = "<img src='assets/images/loading.gif' width='35'>";

	$.ajax({
        type:"POST",
        url:"database/data-productos.php",
        data:{ form_ncje: fs  },
        beforeSend: function() {
        	$('#frm_ncanje').slideUp( 300 );
        	$('#frm_ncanje').html( espera );
        },
        success: function( response ){
        	console.log( response );
			res = jQuery.parseJSON( response );
			if( res.exito == 1 ){
				$('#frm_ncanje').html( "" );
    			enviarRespuesta( res, "redireccion", "mis-canjes.php" );
			}
			else
				notificar( "Producto", res.mje, "error" );
        }
    });
	
});
/* --------------------------------------------------------- */