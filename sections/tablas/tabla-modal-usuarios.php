<table class="table table-bordered table-striped mb-none" id="datatable-editable">
	<thead>
		<tr>
			<th>Nombre completo</th>
			<th>Email</th>
			<th>Rol</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ( $usuarios as $usuario ){ ?>
		<tr class="gradeX">
			<td>
				<a class="sel_persona" href="#!" 
				data-idp="<?php echo $usuario["idUSUARIO"] ?>"><?php echo $usuario["nombre"]." ".$usuario["apellido"] ?> </a>
			</td>
			<td><?php echo $usuario["email"] ?></td>
			<td><?php echo $usuario["rol"] ?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>