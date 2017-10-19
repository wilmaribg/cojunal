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
                      <h1><?=Yii::t("wallet","deudores")?></h1>
                      <h2><?=Yii::t("wallet", "numeroDeudores")?>: <?php echo $debtorsCount; ?></h2>
                    </div>
                  </div>
                  <div class="large-4 medium-4 small-12 columns boxs">
                    <div class="panel">
                      <p><b><?=Yii::t("wallet", "proncentajeRecuperacion")?>:</b> <?php echo round( $recover, 2, PHP_ROUND_HALF_UP); ?>%</p>
                      <a href="<?php echo Yii::app()->baseUrl; ?>/dashboard"><?=Yii::t("wallet", "verCuadrantes")?> <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                    </div>
                  </div>
                </div>
              </section>
              <!--Fin Datos iniciales-->

              <!--All deudores-->              
              <section class="panelBG m_b_20 lista_all_deudor">
                <table class="bordered highlight responsive-table">
                  <thead>
                    <tr>
                        <th class="txt_center"><?=Yii::t("wallet","identificacion")?></th>
                        <th class="txt_center"><?=Yii::t("wallet","nombre")?></th>
                        <th class="txt_center"><?=Yii::t("wallet","ciudad")?></th>
                        <th class="txt_center"><?=Yii::t("wallet","fechaAsignacion")?></th>
                        <th class="txt_center"><?=Yii::t("wallet","ultimaGestion")?></th>
                        <th class="txt_center"><?=Yii::t("wallet","estado")?></th>
                        <th class="txt_center"><?=Yii::t("wallet","estado")?></th>
                        <th class="txt_center"><?=Yii::t("wallet","saldoTotal")?></th>
                        <th class="txt_center"><?=Yii::t("wallet","saldoPendiente")?></th>
                    </tr>
                    <tr class="filters formweb">
                      <td>
                        <input type="text"  name="identification" id="identification" maxlength="100" value="" onchange='javascript:uploadList("idNumber","identification")'>
                      </td>
                      <td>
                        <input type="text"  name="nameDebtor" id="nameDebtor" maxlength="100" value="" onchange='javascript:uploadList("legalName","nameDebtor")'>
                      </td>
                      <td>
                        <input type="text"  name="ciudad" id="ciudad" maxlength="100" value="" onchange='javascript:uploadList("name","ciudad")'>
                      </td>
                      <td>
                        <?php
                          echo CHtml::dropDownList('dAssigment', 'dAssigment',CHtml::listData($modelFilter,'dAssigment','dAssigment'),array( 'empty' => 'Seleccione Días','onChange' => 'javascript:uploadList("dAssigment","dAssigment")' ));
                        ?>
                      </td>
                      <td>
                        <?php
                          echo CHtml::dropDownList('gestion', 'gestion',CHtml::listData($modelFilter,'gestion','gestion'),array( 'empty' => 'Seleccione Gestión','onChange' => 'javascript:uploadList("gestion","gestion")' ));
                        ?>
                      </td>
                      <td>
                        <?php
                          echo CHtml::dropDownList('status', 'status',CHtml::listData($modelFilter,'idStatus','description'),array( 'empty' => 'Seleccione Estatus','onChange' => 'javascript:uploadList("idStatus","status")' ));
                        ?>
                      </td>
                      <td>
                        <select id="cd-dropdown" name="cd-dropdown" class="cd-select filterType">
                          <option value="-1" selected>Seleccionar</option>
                          <option value="1" class="icon_red"><?= Yii::t("semaforo", "type1")?></option>
                          <option value="2" class="icon_blue"><?= Yii::t("semaforo", "type2")?></option>
                          <option value="3" class="icon_green"><?= Yii::t("semaforo", "type3")?></option>
                          <option value="4" class="icon_yellow"><?= Yii::t("semaforo", "type4")?></option>
                        </select>
                       </td> 
                      
                      <td>
                        <input type="text"  name="valueAssignment" id="valueAssignment" maxlength="100" value="" onchange= 'javascript:uploadList("valueAssigment","valueAssignment")'>
                      </td>
                      <td>
                        <input type="text"  name="debt" id="debt" maxlength="100" value="" onchange='javascript:uploadList("debt","debt")'>
                      </td>
                    </tr>                   
                  </thead>

                  
                  <tbody id="listDebtors">    
                    <?php
                      foreach ($allDebtors as $key => $value) {
                        $wallet = Wallets::model()->findByPk($value->idWallet);
                        $district = Districts::model()->findByPk($wallet->idDistrict);
                        setlocale(LC_MONETARY, "en_US");
                        // echo money_format('%i', $number) . "\n";
                    ?>                
                        <tr onClick="document.location.href='<?php echo Yii::app()->baseUrl; ?>/campaign/search/<?php echo $value->idWallet ?>';">
                          <td class="txt_center"><?php echo $value->idNumber; ?></td>
                          <td class="txt_center"><?php echo $value->legalName; ?></td>
                          <td class="txt_center"><?php echo $district->name; ?></td>
                          <td class="txt_center"><?php echo $value->dAssigment; ?></td>
                          <td class="txt_center"><?php echo $value->gestion; ?> <span> día(s)</span></td>
                          <td class="txt_center"><?php echo $value->description; ?></td>
                          <td class="txt_center">
                            <div class="estado <?=Yii::t("semaforo","color" . $value->type) ?> tooltipped" data-position="top" data-delay="50" data-tooltip="<?=Yii::t("semaforo", "type".$value->type)?>"></div> 
                          </td>
                          <td class="txt_center"><?php echo money_format('%n',$value->valueAssigment); ?></td>
                          <td class="txt_center"><?php echo $value->debt!=NULL?money_format('%n',$value->debt):money_format('%n',$value->valueAssigment); ?></td>
                        </tr>
                    <?php 
                    }
                    ?>
                  </tbody>
                </table>
              </section>
              <!--Fin All deudores-->              

            </section>

            <div class="clear"></div>
          </section>
        </section>
          <div class="clear"></div>
      </section>
<script type="text/javascript">
  $( document ).ready(function() {
    $("#wallets").addClass("activo");
    $( '#cd-dropdown' ).dropdown({
        gutter : 0,
        delay : 0,
        random : false,
        speed : 300,
        easing : 'ease',
        rotated : false,
        slidingIn : false,
        onOptionSelect: function(opt){
            console.log(opt.attr("data-value"));
            uploadListWithSelect(opt.attr("data-value"));

            
        }
    });
  });

  function uploadListWithSelect(value){
    $.ajax({
      url: '<?php echo Yii::app()->getBaseUrl(true); ?>'+'/dashboard/listDebtorByAttributeCampaign/type/'+value+'/'+<?php echo $q; ?>,
      type: 'get',
      data: {},
      success: function (data) {
         $("#listDebtors").html('');
         $("#listDebtors").html(data); 
      }
    });
  }

  function uploadList(attribute,valAttr){
    $valor = $("#"+valAttr).val()?$("#"+valAttr).val():0
    
    
    $.ajax({
      url: '<?php echo Yii::app()->getBaseUrl(true); ?>'+'/dashboard/listDebtorByAttributeCampaign/'+attribute+'/'+$valor+'/'+<?php echo $q; ?>,
      type: 'get',
      data: {},
      success: function (data) {
         $("#listDebtors").html('');
         $("#listDebtors").html(data); 
      }
    });
  }
</script>