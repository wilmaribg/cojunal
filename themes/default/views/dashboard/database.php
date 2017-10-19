<link href="/plataforma/beta/assets/css/cojunal.css" rel="stylesheet" type="text/css">

<?php 
  if(isset($lote)){
    echo "<script>
            var lote = '".$lote."';
            var amount = '".$amount."';
            var usersUpload = '".$usersUpload."';
        </script>";
  }else {
    echo "<script>
            var lote = null;
        </script>";
  }
   // Yii::app()->language = "en";
  $session = Yii::app()->session;
  //Para probar idioma
  // Yii::app()->language = "en";
  if($session['idioma']==2){
      Yii::app()->language = "en";
  }else {
    Yii::app()->language = "es";
  }
?>
<style>
  <?php include 'database.css' ?>
</style>

<div class="cont_home" id="usuarios">
  <section class="conten_inicial">
    <section class="wrapper_l dashContent p_t_25">
      <section class="padding">
        <div class="block">
          <ul class="tabs tab_usuarios" data-tabs id="example-tabs">
            <li class="tab"><a href="#campanas" class="active">Campañas</a></li>
            <li class="tab"><a href="#formulario">Crear campañas</a></li>
          </ul>
        </div>

        <section class="panelBG wow fadeInUp m_b_20 animated">
          <section class="padd_v">
            <div class="row">
              <article id="campanas" class="block">
                <?php require_once __DIR__ . '/clientes/campanas/campanas.php'; ?>
              </article>

              <article id="formulario" class="block">
                <?php require_once __DIR__ . '/clientes/campanas/formulario_campana.php'; ?>
              </article>
            </div>
            <div class="clear"></div>
          </section>
        </section>
      </section>
    </section>
  </section>

</div>

<?php 
  // Carga el modal para mostrar el detalle de la carga de capaña al sistema
  require 'detalle_carga_campana.php';

  if(isset($lote))
    require("modal_load.php");
?>

<script>
  $(document).ready(function(){
    $("#fileUpload").addClass("activo");
    $("#load_db").hide();
    if(lote!=null){
      $("#usersUpload").html(usersUpload);
      $("#amount").html(amount);
      $("#load_db").show();
    }
  });

  $('input:checkbox').change(
  function(){
      if ($(this).is(':checked')) {
          $("#cargarData").prop("disabled",false);
      }else {
        $("#cargarData").prop("disabled",true);
      }
  });
</script>

<script> <?php require realpath('./') . '/themes/default/views/admin/main.js' ?> </script>