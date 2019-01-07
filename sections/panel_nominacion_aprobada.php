<hr class="solid short">
<div id="panel_aprobacion">
	<?php if ( $nominacion["estado"] == "pendiente" ){ ?>
		Fecha nominación: <?php echo $nominacion["fregistro"]; ?>
	<?php } else { ?>
		<p>Fecha nominación: <?php echo $nominacion["fregistro"]; ?></p>
		<p>Fecha cierre: <?php echo $nominacion["fcierre"]; ?></p>
	<?php } ?>
</div>