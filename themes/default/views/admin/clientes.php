<link href="<?php 
	echo Yii::app()->baseUrl.'/assets/site/css/profile_admin/usuarios.css'; ?>" 
	rel="stylesheet" type="text/css" />

<div class="cont_home" id="usuarios">
	<section class="conten_inicial">
		<section class="wrapper_l dashContent p_t_25">
			<section class="padding">
				<div class="block">
					<ul class="tabs tab_usuarios" data-tabs id="example-tabs">
						<li class="tab"><a href="#clientes" class="active">Clientes</a></li>
						<li class="tab"><a href="#formulario">Agregar cliente</a></li>
						<li class="tab"><a href="#remisionar">Orden de servicios</a></li>
						<li class="tab"><a href="#remisiones">Historial Orden de servicios</a></li>
					</ul>
				</div>

				<section class="panelBG wow fadeInUp m_b_20 animated">
					<section class="padd_v">
						<div class="row">
							<article id="clientes" class="block">
								<?php require_once realpath('./') . '/themes/default/views/admin/clientes/listado.php'; ?>
							</article>

							<article id="formulario" class="block">
								<?php require_once realpath('./') . '/themes/default/views/admin/clientes/formulario.php'; ?>
							</article>

							<article id="remisionar" class="block">
								<?php require_once realpath('./') . '/themes/default/views/admin/clientes/remision.php'; ?>
							</article>

							<article id="remisiones" class="block">
								<?php require_once realpath('./') . '/themes/default/views/admin/clientes/remisiones.php'; ?>
							</article>

						</div>
						<div class="clear"></div>
					</section>
				</section>
			</section>
		</section>
	</section>

</div>

<script>
	<?php include realpath('./').'/themes/default/views/admin/main.js' ?>
</script>