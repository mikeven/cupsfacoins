<?php 
	/* --------------------------------------------------------- */
	/* Cupfsa Coins - Esquema de acciones y accesos */
	/* --------------------------------------------------------- */
	/* --------------------------------------------------------- */

	//Rol: ADMINISTRADOR - ACCIONES:
	$esq_secciones["agregar_usuario"] = array(
		array('id'=>'mp_titm_us', 'desc'=>'Menu ppal Usuarios'),
		array('id'=>'pg_usuarios', 'desc'=>'Página consulta de usuarios'),
		array('id'=>'pg_nvo_usuario', 'desc'=>'Página nuevo usuario')
	);

	$esq_secciones["agregar_atributo"] = array(
		array('id'=>'mp_ver_atrib', 'desc'=>'Menu ppal Atributos')
	);

	$esq_secciones["consultrar_atributo"] = array(
		array('id'=>'pg_atributos', 'desc'=>'Menu ppal Atributos')
	);

	$esq_secciones["agregar_producto"] = array(
		array('id'=>'mp_titm_pro', 'desc'=>'Menu ppal Productos'),
		array('id'=>'mp_ag_pro', 'desc'=>'Menu ppal Nuevo producto'),
		array('id'=>'pg_nvo_producto', 'desc'=>'Página nuevo producto') 	
	);

	$esq_secciones["consultar_producto"] = array(
		array('id'=>'mp_titm_pro', 'desc'=>'Menu ppal Productos'),
		array('id'=>'mp_ver_pro', 'desc'=>'Menu ppal Ver productos'),
		array('id'=>'pg_productos', 'desc'=>'Página consulta de productos')
	);

	$esq_secciones["consultar_todos_canjes"] = array(
		array('id'=>'mp_ver_canj', 'desc'=>'Menu ppal Consultar canjes'),
		array('id'=>'pg_canjes', 'desc'=>'Página consulta de canjes')
	);

	$esq_secciones["ver_todas_nominaciones"] = array(
		array('id'=>'mp_ver_nom', 'desc'=>'Menu ppal Ver nominaciones'),
		array('id'=>'ver_tnominac', 'desc'=>'Menu ppal Ver nominaciones'),
		array('id'=>'pg_nominaciones', 'desc'=>'Página consulta nominaciones')
	);

	$esq_secciones["aprobar_nominacion"] = array(
		array('id'=>'pg_nominacion', 'desc'=>'Página ficha nominación'),
		array('id'=>'en_ver_nom', 'desc'=>'Enlace para ver nominación'),
		array('id'=>'en_aprob_nom', 'desc'=>'Enlace para aprobar nominación'),
		array('id'=>'result_nom', 'desc'=>'Resultados de nominaciones')
	);
	
	/* --------------------------------------------------------- */
	/* --------------------------------------------------------- */
	/* --------------------------------------------------------- */

	//Rol: COLABORADOR - ACCIONES:
	$esq_secciones["agregar_nominacion"] = array(
		array('id'=>'mp_nom_pers', 'desc'=>'Menu ppal Nueva nominación'),
		array('id'=>'pg_nvo_nominacion', 'desc'=>'Página nueva nominación')
	);

	$esq_secciones["ver_nominaciones_hechas"] = array(
		array('id'=>'mp_nom_pers', 'desc'=>'Menu ppal Ver nominaciones hechas'),
		array('id'=>'pg_nominaciones', 'desc'=>'Página consulta nominaciones'),
		array('id'=>'en_ver_nom', 'desc'=>'Enlace para ver nominación'),
		array('id'=>'pg_nominacion', 'desc'=>'Página ficha nominación')
	);

	$esq_secciones["ver_nominaciones_recibidas"] = array(
		array('id'=>'mp_nom_pers', 'desc'=>'Menu ppal Ver nominaciones recibidas'),
		array('id'=>'pg_nominaciones', 'desc'=>'Página consulta nominaciones'),
		array('id'=>'pg_nominacion', 'desc'=>'Página ficha nominación'),
		array('id'=>'pan_nom_aprob', 'desc'=>'Información de nominación aprobada')
	);

	$esq_secciones["consultar_canjes_propios"] = array(
		array('id'=>'mp_ver_miscanj', 'desc'=>'Menu ppal Ver mis canjes'),
		array('id'=>'pg_mis_canjes', 'desc'=>'Página consulta canjes de usuario')
	);

	/* --------------------------------------------------------- */
	/* --------------------------------------------------------- */
	/* --------------------------------------------------------- */

	//Rol: EVALUADOR - ACCIONES:
	$esq_secciones["votar_nominacion"] = array(
		array('id'=>'en_votar', 'desc'=>'Enlace para votar nominación'),
		array('id'=>'pg_nominacion', 'desc'=>'Página ficha nominación')
	);
?>