<link href="/plataforma/beta/assets/css/cojunal.css" rel="stylesheet" type="text/css">

<div class="cont_home" id="usuarios">
  <section class="conten_inicial">
    <section class="wrapper_l dashContent p_t_25">
      <section class="padding">
        <div class="block">
          <ul class="tabs tab_usuarios" data-tabs id="example-tabs">
            <li class="tab"><a href="#campanas" class="active">Campañas</a></li>
            <li class="tab"><a href="#juridicos">Procesos jurídicos</a></li>
            <li class="tab"><a href="#reportes">Generar reporte</a></li>
          </ul>
        </div>

        <section class="panelBG wow fadeInUp m_b_20 animated">
          <section class="padd_v">
            <div class="row">
              <article id="campanas" class="block">
                <?php require_once realpath('./') . '/themes/default/views/admin/campana/campanas.php'; ?>
              </article>

              <article id="juridicos" class="block">
                <?php require_once realpath('./') . '/themes/default/views/admin/campana/para_juridico.php'; ?>
              </article>

              <article id="reportes" class="block">
                <?php require_once realpath('./') . '/themes/default/views/admin/campana/reportes.php'; ?>
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

