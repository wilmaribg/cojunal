<!-- <link href="<?php echo Yii::app()->baseUrl; ?>/assets/site/css/profile_admin/usuarios.css" rel="stylesheet" type="text/css" />

<style>
  .item.input {display: none; }
  .item.item-text-0 {display: block; }
  a {cursor: pointer; }
</style>

<div class="cont_home">
  <section class="conten_inicial">
    <section class="p_t_25">
      <section class="padding" style="background: white;">       
        
        <div class="block">
          <table class="bordered highlight responsive-table">
            <thead id="campanasTableHead">
            </thead>
            <tbody id="campanasTableBody">
            </tbody>
          </table>
        </div>

      </section>
    </section>
  </section>
</div>

 -->




<link href="/plataforma/beta/assets/css/cojunal.css" rel="stylesheet" type="text/css">

<div class="cont_home" id="usuarios">
  <section class="conten_inicial">
    <section class="wrapper_l dashContent p_t_25">
      <section class="padding">
        
        <div id="usuarios">
          <section class="conten_inicial">
            <section class="wrapper_l dashContent p_t_25">
              <section class="padding panelBG">       

                <table class="bordered highlight responsive-table">
                  <thead id="campanasTableHead">
                  </thead>
                  <tbody id="campanasTableBody">
                  </tbody>
                </table>

              </section>
            </section>
          </section>
        </div>

      </section>
    </section>
  </section>

</div>

<script>
  window.baseUrl = "<?php echo Yii::app()->baseUrl; ?>";
  <?php include 'campanas.js' ?>
  <?php include realpath('./').'/themes/default/views/admin/main.js' ?>
</script>
