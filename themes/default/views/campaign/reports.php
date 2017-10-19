<?php 
  $date = new DateTime($maxDateCreate);
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
<section class="cont_home">       
  <section class="conten_inicial">
    <section class="wrapper_l dashContent p_t_10">
      
      <div class="titulo report_tittle sin_margin">
        <h1><?=Yii::t("reports", "reportes")?> <a href="<?php echo Yii::app()->baseUrl; ?>/campaign/reportPdf" TARGET="_blank" class="btnb"><?=Yii::t("reports", "descargas")?></a></h1>
      </div>
      <div class="dates_all">
        <div class="large-3 medium-3 small-12 columns padd_all">
          <h2><?=Yii::t("reports", "fechaCargue")?></h2>
          <p><?= $date->format("d-m-Y"); ?></p>
        </div>
        <div class="large-3 medium-3 small-12 columns padd_all">
          <h2><?=Yii::t("reports", "totalDinero")?></h2>
          <p><?= $amount ?></p>
        </div>
        <div class="large-3 medium-3 small-12 columns padd_all">
          <h2><?=Yii::t("reports", "totalRecaudado")?></h2>
          <p><?= $countDebts ?></p>
        </div>
        <div class="large-3 medium-3 small-12 columns padd_all">
          <h2><?=Yii::t("reports", "totalCargados")?></h2>
          <p><?= count($listDebtors) ?></p>
        </div>
      </div>
        
      <section class="padding">

        <!--Global Dashboard-->       
        <section class="wrapper_s">
          <section class="list_activiti">
            <ul>
              <li class="large-6 medium-6 small-12 columns padd_all wow pulse">
                <a href="">
                  <div class="panel_dash">
                    <div class="tile-heading">
                      <h3><?=Yii::t("reports", "prejuridico")?></h3>
                    </div>
                    <div class="valor">
                      <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                      <h2><?= $preJuridico ?></h2>
                      <h1><?= $amountPreJuridico ?></h1>
                    </div>
                  </div>
                </a>
              </li>
              <li class="large-6 medium-6 small-12 columns padd_all wow pulse">
                <a href="">
                  <div class="panel_dash">
                    <div class="tile-heading">
                      <h3><?=Yii::t("reports", "juridico")?></h3>
                    </div>
                    <div class="valor">
                      <i class="fa fa-bar-chart" aria-hidden="true"></i>
                      <h2><?= $juridico ?></h2>
                      <h1><?= $amountJuridico ?></h1>
                    </div>
                  </div>
                </a>
              </li>
              <li class="large-6 medium-6 small-12 columns padd_all wow pulse">
                <a href="">
                  <div class="panel_dash">
                    <div class="tile-heading">
                      <h3><?=Yii::t("reports", "contactCenter")?></h3>
                    </div>
                    <div class="valor">
                      <i class="fa fa-line-chart" aria-hidden="true"></i>
                      <h2><?= $contactCenter ?></h2>
                      <h1><?= $amountContactCenter ?></h1>
                    </div>
                  </div>
                </a>
              </li>
              <li class="large-6 medium-6 small-12 columns padd_all wow pulse">
                <a href="">
                  <div class="panel_dash">
                    <div class="tile-heading">
                      <h3><?=Yii::t("reports", "investigacion")?></h3>
                    </div>
                    <div class="valor">
                      <i class="fa fa-area-chart" aria-hidden="true"></i>
                      <h2><?= $investigacion ?></h2>
                      <h1><?= $amountInvestigacion ?></h1>
                    </div>
                  </div>
                </a>
              </li>
              <li class="large-6 medium-6 small-12 columns padd_all wow pulse">
                <a href="">
                  <div class="panel_dash">
                    <div class="tile-heading">
                      <h3><?=Yii::t("reports", "deudoresIlocalizados")?></h3>
                    </div>
                    <div class="valor">
                      <i class="estado red tooltipped alts-circle" aria-hidden="true"></i>
                      <h2><?= $rojo ?></h2>
                      <h1><?= $amountRojo ?></h1>
                    </div>
                  </div>
                </a>
              </li>
              <li class="large-6 medium-6 small-12 columns padd_all wow pulse">
                <a href="">
                  <div class="panel_dash">
                    <div class="tile-heading">
                      <h3><?=Yii::t("reports", "deudoresContactados")?></h3>
                    </div>
                    <div class="valor">
                      <i class="estado blue tooltipped alts-circle" aria-hidden="true"></i>
                      <h2><?= $azul ?></h2>
                      <h1><?= $amountAzul ?></h1>
                    </div>
                  </div>
                </a>
              </li>
              <li class="large-6 medium-6 small-12 columns padd_all wow pulse">
                <a href="">
                  <div class="panel_dash">
                    <div class="tile-heading">
                      <h3><?=Yii::t("reports", "deudoresCompromiso")?></h3>
                    </div>
                    <div class="valor">
                      <i class="estado yellow tooltipped alts-circle" aria-hidden="true"></i>
                      <h2><?= $amarillo ?></h2>
                      <h1><?= $amountAmarillo ?></h1>
                    </div>
                  </div>
                </a>
              </li>
              <li class="large-6 medium-6 small-12 columns padd_all wow pulse">
                <a href="">
                  <div class="panel_dash">
                    <div class="tile-heading">
                      <h3><?=Yii::t("reports", "deudoresNormalizados")?></h3>
                    </div>
                    <div class="valor">
                      <i class="estado green tooltipped alts-circle" aria-hidden="true"></i>
                      <h2><?= $verde ?></h2>
                      <h1><?= $amountVerde ?></h1>
                    </div>
                  </div>
                </a>
              </li>
            </ul>
          </section>
        </section>       
        <!--Fin Global Dashboard-->              

      </section>

      <div class="clear"></div>
    </section>
  </section>
    <div class="clear"></div>
</section>
<?php 
  // print_r($campaign);
  // print_r($wallets);
?>
<script type="text/javascript">
  $( document ).ready(function() {
    $("#reports").addClass("activo");
  });
</script>