<hr class="solid short">
<div id="panel_voto">
	<button type="button" class="mb-xs mt-xs mr-xs btn btn-success btn-lg cnf-voto" data-valor="si"><i class="fa fa-thumbs-up"></i> </button>
	<button type="button" class="mb-xs mt-xs mr-xs btn btn-danger btn-lg cnf-voto" data-valor="no"><i class="fa fa-thumbs-down"></i> </button>
	<div id="confirmar_seleccion" style="display: none;">
		<hr class="solid short">
		<div>Haga clic en Votar para confirmar su selección</div>
		<input id="valor_voto" type="hidden" name="voto" value="">
		<button id="btn_votar" type="button" class="mb-xs mt-xs mr-xs btn btn-primary"><i class="fa fa-hand-o-down"></i> Votar</button>
	</div>
</div>
<div id="panel_resultado" style="display: none;">
	<i class="fa fa-3x fa-check-square-o"></i>
	Voto registrado
</div>