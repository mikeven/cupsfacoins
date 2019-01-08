<hr class="solid short">
<div id="panel_aprobacion">
	<div id="confirmar_seleccion">
		<?php if( $votacion["si"] > $votacion["no"] ) { ?>
		<button id="btn_aprobar" type="button" class="mb-xs mt-xs mr-xs btn btn-primary adminev">
			<i class="fa fa-check"></i> Aprobar</button>
		<?php } else { ?>
		<button id="btn_aprobar" type="button" class="mb-xs mt-xs mr-xs btn btn-primary adminev">
			<i class="fa fa-times"></i> Rechazar</button>
		<?php } ?>
		<button id="btn_sustento" type="button" class="mb-xs mt-xs mr-xs btn btn-primary adminev">
			<i class="fa fa-file-o"></i> Solicitar sustento</button>
	</div>
</div>
<div id="panel_comentario1" style="display: none;" class="panel_comentario">
	<hr class="solid short">
	<form id="frm_admineval">
		<div class="form-group">
			<label class="col-sm-12 control-label">Comentario </label>
			<div class="col-sm-12">
				<textarea class="form-control" rows="3" id="textareaAutosize" name="comentario" data-plugin-textarea-autosize="" style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 74px; width: 100%;"></textarea>
			</div>
		</div>
	</form>
	
</div>