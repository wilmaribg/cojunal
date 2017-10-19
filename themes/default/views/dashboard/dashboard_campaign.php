<?php 
  $session = Yii::app()->session;
  //Para probar idioma
  // Yii::app()->language = "en";
  if($session['idioma']==2){
      Yii::app()->language = "en";
  }else {
    Yii::app()->language = "es";
  }
?>
<section class="cont_home">       
  <section class="conten_inicial">
    <section class="wrapper_l dashContent p_t_25">
      
      <section class="padding">

        <!--Datos iniciales-->
        <section class="row m_b_20">
          <div class="dates_pend wow fadeInDown">
            <div class="large-8 medium-8 small-12 columns boxs">
              <div class="panel">
                <h1><?=Yii::t("dashboard", "deudores")?></h1>
                <h2><?=Yii::t("dashboard", "valorUnidad")?>: <?php echo $valueUnity; ?></h2>
                <h2><?=Yii::t("dashboard", "numeroDeudores")?>: <?php echo $debtorsCount; ?></h2>
              </div>
            </div>
            <div class="large-4 medium-4 small-12 columns boxs">
              <div class="panel">
                <p><b><?=Yii::t("dashboard", "porcentajeRecuperacion")?>:</b> <?php echo round( $recover, 2, PHP_ROUND_HALF_UP)?> %</p>
                <a href="<?php echo Yii::app()->baseUrl;?>/list-campaign"><?= Yii::t("dashboard","verLista") ?><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
              </div>
            </div>
          </div>
        </section>
        <!--Fin Datos iniciales-->

        <!--Global Dashboard-->              
        <section class="list_dash">
          <ul>
            <li class="large-6 medium-6 small-12 columns wow flipInX">
              <a href="<?php echo Yii::app()->baseUrl;?>/list-campaign/1">
              <div class="card_dash sin_margin waves-effect waves-light">
                <div class="icon_num">1</div>
                <div class="lineap"></div>
                <div class="row">
                  <p class="large-5 medium-5 small-12 columns"><b><?=Yii::t("dashboard", "valor")?>:</b></p>
                  <p class="large-7 medium-7 small-12 columns"><?php echo $quadrants['q1']['value']; ?></p>
                </div>
                <div class="row">
                  <p class="large-5 medium-5 small-12 columns"><b><?=Yii::t("dashboard", "tiempoMora")?>:</b></p>
                  <p class="large-7 medium-7 small-12 columns"><?php echo $quadrants['q1']['days']; ?> <span><?=Yii::t("dashboard", "dias")?></span></p>
                </div>
                <div class="clear"></div>
              </div>
              </a>
            </li>
            <li class="large-6 medium-6 small-12 columns wow flipInX">
              <a href="<?php echo Yii::app()->baseUrl;?>/list-campaign/2">
              <div class="card_dash sin_margin waves-effect waves-light">
                <div class="icon_num">2</div>
                <div class="lineap"></div>
                <div class="row">
                  <p class="large-5 medium-5 small-12 columns"><b><?=Yii::t("dashboard", "valor")?>:</b></p>
                  <p class="large-7 medium-7 small-12 columns"><?php echo $quadrants['q2']['value']; ?></p>
                </div>
                <div class="row">
                  <p class="large-5 medium-5 small-12 columns"><b><?=Yii::t("dashboard", "tiempoMora")?>:</b></p>
                  <p class="large-7 medium-7 small-12 columns"><?php echo $quadrants['q2']['days']; ?> <span><?=Yii::t("dashboard", "dias")?></span></p>
                </div>
                <div class="clear"></div>
              </div>
              </a>
            </li>
            <li class="large-6 medium-6 small-12 columns wow flipInX">
              <a href="<?php echo Yii::app()->baseUrl;?>/list-campaign/3">
              <div class="card_dash sin_margin waves-effect waves-light">
                <div class="icon_num">3</div>
                <div class="lineap"></div>
                <div class="row">
                  <p class="large-5 medium-5 small-12 columns"><b><?=Yii::t("dashboard", "valor")?>:</b></p>
                  <p class="large-7 medium-7 small-12 columns"><?php echo $quadrants['q3']['value']; ?></p>
                </div>
                <div class="row">
                  <p class="large-5 medium-5 small-12 columns"><b><?=Yii::t("dashboard", "tiempoMora")?>:</b></p>
                  <p class="large-7 medium-7 small-12 columns"><?php echo $quadrants['q3']['days']; ?> <span><?=Yii::t("dashboard", "dias")?></span></p>
                </div>
                <div class="clear"></div>
              </div>
              </a>
            </li>
            <li class="large-6 medium-6 small-12 columns wow flipInX">
              <a href="<?php echo Yii::app()->baseUrl;?>/list-campaign/4">
              <div class="card_dash sin_margin waves-effect waves-light">
                <div class="icon_num">4</div>
                <div class="lineap"></div>
                <div class="row">
                  <p class="large-5 medium-5 small-12 columns"><b><?=Yii::t("dashboard", "valor")?>:</b></p>
                  <p class="large-7 medium-7 small-12 columns"><?php echo $quadrants['q4']['value']; ?></p>
                </div>
                <div class="row">
                  <p class="large-5 medium-5 small-12 columns"><b><?=Yii::t("dashboard", "tiempoMora")?>:</b></p>
                  <p class="large-7 medium-7 small-12 columns"><?php echo $quadrants['q4']['days']; ?> <span><?=Yii::t("dashboard", "dias")?></span></p>
                </div>
                <div class="clear"></div>
              </div>
              </a>
            </li>
          </ul>
        </section>
        <!--Fin Global Dashboard-->              

      </section>

      <div class="clear"></div>
    </section>
  </section>
    <div class="clear"></div>
</section>
<script type="text/javascript">
  $( document ).ready(function() {
    $("#wallets").addClass("activo");
  });
</script>