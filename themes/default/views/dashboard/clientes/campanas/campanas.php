<link href="<?php echo Yii::app()->baseUrl; ?>/assets/site/css/profile_admin/usuarios.css" rel="stylesheet" type="text/css" />

<style>
  .item.input {display: none; }
  .item.item-text-0 {display: block; }
  a {cursor: pointer; }
  .financialData {color: #25a8e8; font-weight: 500; cursor: pointer;
  }
</style>

<div id="usuarios">
	<section class="conten_inicial">
		<section class="wrapper_l dashContent">
			<section class="padding panelBG">				
			
        <table class="bordered highlight responsive-table">
          <thead id="campanasTableHead">
          </thead>
          <tbody id="adminListadoCampanas">
          </tbody>
        </table>

			</section>
		</section>
	</section>

</div>

<script>
  window.baseUrl = "<?php echo Yii::app()->baseUrl; ?>";
  <?php include 'campanas.js' ?>
</script>




