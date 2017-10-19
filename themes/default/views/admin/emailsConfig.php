<?php $ul2 = Yii::app()->baseUrl.'/assets/site/css/profile_admin/usuarios.css'; ?>
<link href="<?php echo $ul2; ?>" rel="stylesheet" type="text/css" />


<div class="cont_home" id="usuarios">
  <section class="conten_inicial">
    <section class="wrapper_l dashContent p_t_25">
      <section class="padding">
        <div class="block">
          <ul class="tabs tab_usuarios" data-tabs id="example-tabs">
            <li class="tab"><a href="#notificacion" class="active">Notificación Ingreso</a></li>
            <li class="tab"><a href="#terminos">Términos del contrato</a></li>
          </ul>
        </div>

        <section class="panelBG wow fadeInUp m_b_20 animated">
          <section class="padd_v">
            <div class="row">
              <article id="notificacion" class="block">
                <?php require_once realpath('./') . '/themes/default/views/admin/emails/notificacion.php'; ?>
              </article>

              <article id="terminos" class="block">
                <?php require_once realpath('./') . '/themes/default/views/admin/emails/termsAndConditions.php'; ?>
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
  <?php include realpath('./').'/themes/default/views/admin/emails/notificacion.js' ?>
  <?php include realpath('./').'/themes/default/views/admin/main.js' ?>
</script>