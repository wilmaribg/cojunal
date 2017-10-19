<link href="<?php echo Yii::app()->baseUrl; ?>/assets/site/css/profile_admin/usuarios.css" rel="stylesheet" />

<style>
  .item.input {display: none; }
  .item.item-text-0 {display: block; }
  a {cursor: pointer; }
</style>

<div id="usuarios">
	<section class="conten_inicial">
		<section class="wrapper_l dashContent p_t_25">
			<section class="padding panelBG">				
        
        <p>Por favor seleccion el cliente a generar el reporte</p>
        <section class="formweb">
          <select id="selectReporteCampanas"></select>
        </section>

			</section>
		</section>
	</section>

</div>

<script>
  window.baseUrl = "<?php echo Yii::app()->baseUrl; ?>";
  <?php include realpath('./') . '/themes/default/views/admin/campana/reportes.js' ?>
</script>

