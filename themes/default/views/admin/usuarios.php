<link href="<?php echo Yii::app()->baseUrl; ?>/assets/site/css/profile_admin/usuarios.css" rel="stylesheet" type="text/css" />

<div class="cont_home" id="usuarios">
	<section class="conten_inicial">
		<section class="wrapper_l dashContent p_t_25">
			<section class="padding">
				<div class="block">
					<ul class="tabs tab_usuarios" data-tabs id="example-tabs">
						<?php $active = ( isset($_GET['tab']) && $_GET['tab'] == 'formulario')  ? 2 : 0?>
						<li class="tab">
							<a href="#coordinadores" <?php echo ($active == 0) ? 'class="active"' : 0 ?> >
								Listado de coodinadores
							</a>
						</li>
						<li class="tab">
							<a href="#asesores">
								Listado de asesores
							</a>
						</li>
						<li class="tab">
							<a href="#formulario" <?php echo ($active == 2) ? 'class="active"' : 0 ?> >
								Agregar usuario
							</a>
						</li>
					</ul>
				</div>

				<section class="panelBG wow fadeInUp m_b_20 animated padding">
					<section class="padd_v">
						<div class="row">
							<article id="coordinadores" class="block">
								<?php require_once realpath('./') . '/themes/default/views/admin/usuarios/listado_coordinadores.php'; ?>
							</article>

							<article id="asesores" class="block">
								<?php require_once realpath('./') . '/themes/default/views/admin/usuarios/listado_asesores.php'; ?>
							</article>

							<article id="formulario" class="block">
								<?php require_once realpath('./') . '/themes/default/views/admin/usuarios/forms/coordinador.php'; ?>
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