

<div>
  <section class="conten_inicial">
    <section class="wrapper_l dashContent padding">
        
        <section class="panelBG wow fadeInUp m_b_20 animated animated">
          <?php $action = Yii::app()->baseUrl . '/dashboard/CrearCamapanaTemporal'; ?>
          <?php $actionSaveSerialize = Yii::app()->baseUrl . '/dashboard/GuardarCamapanaTemporal'; ?>
          <div id="serialize" endpoint="<?php echo $actionSaveSerialize ?>"></div>
          <form class="padding formweb wrapper_s" action="<?php echo $action ?>" name="frmSubirCampana" enctype="multipart/form-data" method="POST">
            
            <!-- SECCION DESCARGA FORMATO -->
            <section class="row padd_v">
                <fieldset class="large-9 medium-9 small-12 columns padding">
                  <?php echo Yii::t("database","textoDescargaFromato") ?>
                </fieldset>
                <fieldset class="large-3 medium-3 small-12 columns padding">
                  <a href="<?php echo Yii::app()->baseUrl; ?>/assets/PlantillaDeudores.csv" class="btnb" download>
                    <?php echo Yii::t("database","botonDescarga") ?>
                  </a>                
                </fieldset>
            </section>
            
            <!-- SEPARADOR -->
            <hr>

            <!-- SECCION INPUT CAMPO NOMBRE CAMPAÑA -->
            <section class="row padd_v">
                <input type="hidden" value="<?php echo $session['campaign']['idCampaign'] ?>" name="Campaing[idCampaign]">
                <div class="clear"></div>
                <fieldset class="large-4 medium-4 small-12 columns padding">
                  <?php echo Yii::t("database","textoLabelNombreCampana") ?>
                </fieldset>
                <fieldset class="large-8 medium-8 small-12 columns padding">
                  <input type="text" name="Campaing[campaignName]" id="campaignName">               
                </fieldset>
            </section>

            <!-- SECCION TITULO TIPO DE SERVICIO -->
            <section class="row">
                <fieldset class="large-4 medium-4 small-12 columns padding">
                  <?php echo Yii::t("database","textoTipoServicio") ?>
                </fieldset>
            </section>
            <br>

            <!-- SECCION INPUT TIPO DE SERVICIO 1 -->
            <section class="row">
                <fieldset class="large-12 medium-12 small-12 columns padding">
                  <p>
                    <input checked="checked" type="radio" value="<?php echo $campaign->valueService1 ?>" name="Campaing[serviceType]" id="servicio1">
                    <label for="servicio1">SERVICIO 1</label>
                  </p>
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt molestias eos repudiandae vel amet numquam deleniti repellendus pariatur quibusdam reiciendis, magnam, aut possimus corporis nisi illum, commodi beatae voluptatem saepe?
                  </p>
                  <p>
                    COSTO SERVICIO 1;
                    <b> <?php echo '$'.number_format($campaign->valueService1, 2) ?> </b>
                  </p>
                </fieldset>
            </section>
            <br>

            <!-- SECCION INPUT TIPO DE SERVICIO 2 -->
            <section class="row">
                <fieldset class="large-12 medium-12 small-12 columns padding">
                  <p>
                    <input type="radio" value="<?php echo $campaign->valueService2 ?>" name="Campaing[serviceType]" id="servicio2">
                    <label for="servicio2">SERVICIO 2</label>
                  </p>
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt molestias eos repudiandae vel amet numquam deleniti repellendus pariatur quibusdam reiciendis, magnam, aut possimus corporis nisi illum, commodi beatae voluptatem saepe?
                  </p>
                  <p>
                    COSTO SERVICIO 2;
                    <b> <?php echo '$'.number_format($campaign->valueService2, 2) ?> </b>
                  </p>
                </fieldset>
            </section>
            <br>
            <br>

            <!-- SECCION TITULO TIPO DE NOTIFICACION -->
            <section class="row">
                <fieldset class="large-4 medium-4 small-12 columns padding">
                  <?php echo Yii::t("database","textoTituloNotificaciones") ?>
                </fieldset>
            </section>
            <br>

            <!-- NOTIFICACION TIPO 1 -->
            <?php $i = 0; ?>
            <?php foreach ($notifications as $notification): ?>
              
              <section class="row">
                  <fieldset class="large-12 medium-12 small-12 columns padding">
                    <p>
                      <?php $_id = $notification['idNotificationType'] ?>
                      <?php $ref = 'notification'.$_id ?>
                      <?php $checked = ($i == 0) ? 'checked="checked"' : '' ?>
                      <input <?php echo $checked ?>  type="radio" value="<?php echo $_id ?>" name="Campaing[notificationType]" id="<?php echo $ref ?>">
                      <label for="<?php echo $ref ?>" style="text-transform: uppercase;">
                        NOTIFICACIÓN <?php echo $notification['name'] ?>
                      </label>
                    </p>
                    <p><?php echo $notification['description'] ?></p>
                  </fieldset>
              </section>
              <br>
              <?php $i++ ?>
            <?php endforeach ?>
            
            <!-- INPUT SUBIDA DE ARCHIVO -->
            <div class="file-field input-field">
              <div class="btn">
                <span><?=Yii::t("database","examinar")?></span>
                <?= CHtml::fileField('file') ?>
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
              </div>
            </div>
            
            <!-- BOTTON DE SUBMIT -->
            <div class="centerbtn">
              <?= CHtml::submitButton(Yii::t("database","cargar"),array("id"=>"cargarData")) ?>
            </div>
            
            <br>
            <br>
            
            <!-- MODAL DE PRUEBA -->
            <a href="#detalle_carga_campana" class="modal_clic" style="display: none;">mostrar final</a>

            <!-- CAMPO TERMINOS Y CONDICIONES -->
            <p>
              <input type="checkbox" class="filled-in" id="terms" name="terms" checked="checked" />
              <label for="terms" style="padding: 6px 0 0 34px;"><?=str_replace("::url","</a>",str_replace("url::","<a href='#terms-modal' class=\"modal_clic\">",Yii::t("database","terminosCondiciones")))?></label>
            </p>
            <br>
            <br>
            
            <!-- TEXTO INFORMATIVO -->
            <p><?='* '.Yii::t("database","recuerda")?></p>
            <br>
            <br>
              
          </form>

        </section>

    </section>
  </section>
</section>

<script>
  <?php require('formulario_campana.js'); ?>
</script>