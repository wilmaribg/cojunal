<?php 
  $session = Yii::app()->session;
  $campaign = $session['campaign'];
  $treeDistric = Treedistricts::model()->findByAttributes(array('idDistrict'=>$model->idDistrict));
  $treeDistric = explode("-", $treeDistric->fullDistrict);
  $pais = $treeDistric[0];
  $depto = $treeDistric[1];
  $ciudad = $treeDistric[2];
  $current_user=Yii::app()->user->id;
  Yii::app()->session['userView'.$current_user.'returnURL']=Yii::app()->request->Url;
  Yii::app()->session['userView'.$current_user.'idWallet']=$model->idWallet;
  if($session['idioma']==2){
    Yii::app()->language = "en";
  }else {
    Yii::app()->language = "es";
  }

$name = $campaign->contactName;
$nameSeparete = explode(" ", $name);
switch (count($nameSeparete)) {
  case 1:
    $iniciales = substr($name, 0,1) . substr($name, 1,2);
  break;
  case 3 :
    $iniciales = substr($nameSeparete[0], 0,1) . substr($nameSeparete[2], 0,1);
  break;
  default:
    $iniciales = substr($nameSeparete[0], 0,1). substr($nameSeparete[1], 0,1);
  break;
}
?>
<section class="cont_home">       
        <section class="conten_inicial">
          <section class="wrapper_l dashContent p_t_25">
            
            <section class="padding">
              <!--Datos iniciales-->
              <section class="panelBG wow date_cont_inicial fadeInUp m_b_20">
                <div class="tittle_head">
                  <h2><?= $campaign->contactName ?></h2>
                </div>
                <div class="row block padd_v">
                  <form id="" class="form_register formweb wow fadeIn" action="" method="">
                     <fieldset class="large-8 medium-8 small-12 columns padding">
                       <div class="porcent_user">
                        <label><?=Yii::t("campaign","porcentajeRecuperacion")?></label>                       
                        <div class="barra">
                         <?php
                            $paymentAmount = 0;                            
                            if (count($payments) > 0){ 
                              foreach ($payments as $payment) {
                                $paymentAmount += $payment->value;                              
                              }
                            }
                            $recoveryPorc = ($paymentAmount * 100) / $model->capitalValue;                            
                          ?>
                          <div class="porcent" style="width:<?= $recoveryPorc ?>%"></div><span><?= $recoveryPorc ?>%</span>                                                  
                        </div> 
                        <label><?=Yii::t("campaign","comentario")?></label>
                        <textarea name="comment" id="comment" cols="30" rows="10"></textarea>                       
                       </div>
                     </fieldset>
                     <fieldset class="large-4 medium-4 small-12 columns padding">
                        <label><?=Yii::t("campaign","estado")?></label>
                        <input type="text" disabled="true" name="" value="<?= Status::model()->findByPk($model->idStatus)->description ?>" disabled="disabled"> 
                        <button type="submit" id="btnSaveComment" class="btnb block waves-effect waves-light btn_margin"><?=Yii::t("campaign","guardar")?></button>
                     </fieldset>

                     </fieldset>
                      <div class="clear"></div>
                  </form>
                </div>
              </section>
              <!--Fin Datos iniciales-->

              <!--Tabs-->
              <div class="block">
                <ul class="tabs tab_cartera">
                  <li class="tab"><a href="#datos_personales"><i class="fa fa-user" aria-hidden="true"></i> <?=Yii::t("campaign","datosPersonales")?></a></li>
                  <li class="tab"><a href="#datos_financieros"><i class="fa fa-usd" aria-hidden="true"></i> <?=Yii::t("campaign","datosFinancieros")?></a></li>
                  <li class="tab"><a href="#historia_gestion"><i class="fa fa-cog" aria-hidden="true"></i> <?=Yii::t("campaign","historiaGestion")?></a></li>
                </ul>
              </div>                          
              <section class="panelBG wow fadeInUp m_b_20">
                <section class="padd_v">
                  <div class="row">  
                    <!--Tab 1-->
                    <article id="datos_personales" class="block">
                      <form action="" class="formweb">
                        <fieldset class="large-6 medium-6 small-12 columns padding">
                          <label><?=Yii::t("campaign","razonSocial")?></label>
                          <input type="text" name="" placeholder="<?= $model->legalName ?>" disabled="disabled">
                          <label><?=Yii::t("campaign","identificacion")?></label>
                          <input type="text" name="" placeholder="<?= $model->idNumber ?>" disabled="disabled">
                          <label><?=Yii::t("campaign","pais")?></label>
                          <input type="text" name="" placeholder="<?= $pais ?>" disabled="disabled">
                          <label><?=Yii::t("campaign","depto")?></label>
                          <input type="text" name="" placeholder="<?= $depto ?>" disabled="disabled">
                        </fieldset>
                        <fieldset class="large-6 medium-6 small-12 columns padding" disabled="disabled">
                          <label><?=Yii::t("campaign","direccion")?></label>
                          <input type="text" name="" placeholder="<?= $model->address ?>" disabled="disabled">
                          <label><?=Yii::t("campaign","ciudad")?></label>
                          <input type="text" name="" placeholder="<?= $ciudad ?>" disabled="disabled">
                          <label><?=Yii::t("campaign","telefono")?></label>
                          <input type="text" name="" placeholder="<?= $model->phone?> " disabled="disabled">
                          <label><?=Yii::t("campaign","email")?></label>
                          <input type="text" name="" placeholder="<?= $model->email ?>" disabled="disabled">
                        </fieldset>
                        <div class="clear"></div>
                      </form>
                      <!--Datos acordeon-->
                      <section class="padd_all">
                        <ul class="bg_acordeon">
                          <li class="content_acord">
                            <div class="acordeon">                          
                              <div class="triangulo"><i class="fa fa-chevron-down" aria-hidden="true"></i></div>
                              <?=Yii::t("campaign","telefonos")?>
                              
                            </div>
                            <div class="clearfix respuesta">
                              <table class="bordered responsive-table">
                                <tbody>
                                  <?php
                                    $demographicPhones = Demographics::model()->findAllByAttributes(array('idWallet'=>$model->idWallet,'idType'=>'1'));                              
                                    if(count($demographicPhones) > 0){
                                      foreach ($demographicPhones as $demographicPhone) {
                                        $city=Cities::model()->with('departments')->findByPk($demographicPhone->idCity);
                                  ?>
                                    <tr>
                                      <td class="txt_center"><?= $demographicPhone->phoneType; ?></td>
                                      <td class="txt_center"><?= $city->departments->name; ?></td>
                                      <td class="txt_center"><?= $city->name; ?></td>
                                      <td class="txt_center"><?= $demographicPhone->value; ?></td>
                                      <td class="txt_center icon_table">                                  
                                        <!--<a href="" class="inline padding tooltipped" data-position="top" data-delay="50" data-tooltip="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <a href="" class="inline padding tooltipped delete" data-position="top" data-delay="50" data-tooltip="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></a>-->
                                      </td>
                                    </tr>
                                  <?php
                                    } 
                                  }                                    
                                  ?>   
                                </tbody>
                              </table>
                            </div>
                          </li>
                          <li class="content_acord">
                            <div class="acordeon">                          
                              <div class="triangulo"><i class="fa fa-chevron-down" aria-hidden="true"></i></div>
                              <?=Yii::t("campaign","referencias")?>
                              
                            </div>
                            <div class="clearfix respuesta">
                              <table class="bordered responsive-table">
                                <tbody>
                                  <?php
                                  $demographicReferences = Demographics::model()->findAllByAttributes(array('idWallet'=>$model->idWallet,'idType'=>'2')); 
                                  if(count($demographicReferences) > 0){ 
                                    foreach ($demographicReferences as $demographicReference) {
                                      $city=Cities::model()->with('departments')->findByPk($demographicReference->idCity);                                      
                                ?>  
                                  <tr>
                                    <td class="txt_center"><?= $demographicReference->value; ?></td>
                                    <td class="txt_center"><?= $demographicReference->relationshipType; ?></td>
                                    <td class="txt_center"><?= $city->departments->name; ?></td>
                                    <td class="txt_center"><?= $city->name; ?></td>
                                    <td class="txt_center descrip"><p><?= $demographicReference->comment; ?></p></td>
                                    <td class="txt_center icon_table">                                  
                                      <!--<a href="" class="inline padding tooltipped" data-position="top" data-delay="50" data-tooltip="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                      <a href="" class="inline padding tooltipped delete" data-position="top" data-delay="50" data-tooltip="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></a>-->
                                    </td>
                                  </tr>
                                <?php
                                  }
                                }
                                ?>    
                                </tbody>
                              </table>
                            </div>
                          </li>
                          <li class="content_acord">
                            <div class="acordeon">                          
                              <div class="triangulo"><i class="fa fa-chevron-down" aria-hidden="true"></i></div>
                              <?=Yii::t("campaign","correo")?>
                            </div>
                            <div class="clearfix respuesta">
                              <table class="bordered responsive-table">
                                <tbody>
                                  <?php
                                  $demographicEmail = Demographics::model()->findAllByAttributes(array('idWallet'=>$model->idWallet,'idType'=>'3')); 
                                  if(count($demographicEmail) > 0){ 
                                    foreach ($demographicEmail as $demographEmail) {                                                                          
                                ?>
                                  <tr>
                                    <td class="txt_center"><?= $demographEmail->contactName; ?></td>
                                    <td class="txt_center"><?= $demographEmail->value; ?></td>
                                    <td class="txt_center icon_table">                                  
                                      <!--<a href="" class="inline padding tooltipped" data-position="top" data-delay="50" data-tooltip="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                      <a href="" class="inline padding tooltipped delete" data-position="top" data-delay="50" data-tooltip="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></a>-->
                                    </td>
                                  </tr>
                                <?php
                                  }
                                }
                                ?>   
                                </tbody>
                              </table>
                            </div>
                          </li>
                          <li class="content_acord">
                            <div class="acordeon">                          
                              <div class="triangulo"><i class="fa fa-chevron-down" aria-hidden="true"></i></div>
                              <?=Yii::t("campaign","direcciones")?>
                            </div>
                            <div class="clearfix respuesta">
                              <table class="bordered responsive-table">
                                <tbody>
                                  <?php
                                  $demographicAddresses = Demographics::model()->findAllByAttributes(array('idWallet'=>$model->idWallet,'idType'=>'4')); 
                                  if(count($demographicAddresses) > 0){ 
                                    foreach ($demographicAddresses as $demographicAddress) {
                                      $city=Cities::model()->with('departments')->findByPk($demographicAddress->idCity);                                      
                                ?>
                                  <tr>
                                    <td class="txt_center"><?= $demographicAddress->addressType; ?></td>
                                    <td class="txt_center"><?= $city->departments->name; ?></td>
                                    <td class="txt_center"><?= $city->name; ?></td>
                                    <td class="txt_center"><?= $demographicAddress->value; ?></td>
                                    <td class="txt_center icon_table">                                  
                                      <!--<a href="" class="inline padding tooltipped" data-position="top" data-delay="50" data-tooltip="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                      <a href="" class="inline padding tooltipped delete" data-position="top" data-delay="50" data-tooltip="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></a>-->
                                    </td>
                                  </tr>
                                <?php
                                  }
                                }
                                ?>     
                                </tbody>
                              </table>
                            </div>
                          </li>
                        </ul>
                      </section>
                      <!--Fin Datos acordeon-->

                        <div class="clear"></div>

                      <!--Bienes-->
                      <section class="panelBG wow fadeInUp m_b_20">
                        <div class="tittle_head new">
                          <h2><i class="fa fa-home" aria-hidden="true"></i> <?=Yii::t("campaign","bienes")?></h2>
                        </div>
                        <div class="row block padd_v">
                          <?php 
                            $assets = Assets::model()->findAllByAttributes(array('idWallet'=>$model->idWallet));
                          ?>
                          <ul class="listBien">
                            <?php
                              if(count($assets) > 0){ 
                                foreach ($assets as $asset) {
                            ?>
                            <li class="large-4 medium-4 small-12 columns padding">
                              <div class="panelB">
                                <h3><?= $asset->assetName; ?> <a href="" class="tooltipped" data-position="top" data-delay="50" data-tooltip="<?=Yii::t("campaign","editar")?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></h3>
                                <div class="padd_all">
                                  <p><span><?=Yii::t("campaign","fechaIngreso")?> <?= date("d/m/Y",strtotime($asset->dCreation)); ?></span></p>
                                  <p><?= $asset->description; ?></p>
                                </div>
                              </div>                      
                            </li>
                            <?php
                              }
                            }
                            ?>   
                          </ul>
                        </div>
                      </section>
                      <!--Fin Bienes-->

                      <!--Soportes-->
                      <section class="panelBG wow fadeInUp m_b_20">
                        <div class="tittle_head new">
                          <h2><i class="fa fa-file-text-o" aria-hidden="true"></i> <?=Yii::t("campaign","soportes")?> <a href="#new_sporte_modal" class="modal_clic"><i class="fa fa-plus" aria-hidden="true"></i> <?=Yii::t("campaign","nuevoSoporte")?></a></h2>
                        </div>
                        <div class="row block">
                          <table class="bordered responsive-table">
                            <?php 
                              $supports = Supports::model()->findAllByAttributes(array('idWallet'=>$model->idWallet));
                            ?>
                            <tbody>
                            <?php
                              if(count($supports) > 0){ 
                                foreach ($supports as $support) {
                            ?>
                              <tr>
                                <td class="txt_center"><?= $support->fileName; ?></td>
                                <td class="txt_center"><?= $support->fileType; ?></td>
                                <td class="txt_center"><?= date("d/m/Y",strtotime($support->dFile)); ?></td>
                                <td class="txt_center icon_table">
                                  <a href="<?= $support->file; ?>" class="inline padding tooltipped" data-position="top" data-delay="50" data-tooltip="Descargar"><i class="fa fa-download" aria-hidden="true"></i></a>

                                  <a href="javascript:preguntar(<?=$support->idsupports?>)"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                  <!--
                                  <a href="" class="inline padding tooltipped" data-position="top" data-delay="50" data-tooltip="Editar"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                  -->
                                </td>
                              </tr>
                            <?php 
                                }
                              }
                            ?>                              
                            </tbody>
                          </table>
                        </div>
                      </section>
                      <!--Fin Soportes-->

                      <!--Comentarios-->
                      <section class="panelBG wow fadeInUp m_b_20">
                        <div class="tittle_head new">
                          <h2><i class="fa fa-comment-o" aria-hidden="true"></i> <?=Yii::t("campaign","comment")?></h2>
                        </div>
                        <?php 
                          $comments = Comments::model()->with('advisers')->findAllByAttributes(array('idWallet'=>$model->idWallet));                          
                        ?>
                        <div class="row block">
                          <?php
                            if(count($comments) > 0){
                              foreach ($comments as $comment) {
                          ?>
                            <article class="checkSite">
                            <input type="checkbox" class="commentsCheck" <?= $comment->status==true?"checked" : "" ?> data-comment="<?= $comment->idComment ?>"  name="comentAproved<?= $comment->idComment?>" id="check<?= $comment->idComment?>" class="checkComment" onclick="updateComment(<?= $comment->idComment ?>)">
                            <label for="check<?= $comment->idComment ?>" class="block">
                              <div class="img_perfil">

                                <div class="bg_profile">
                                  <div class="user_log responsive-img">
                                    <span class="iniciales2"> <?= strtoupper($iniciales); ?> </span>
                                  </div>
                                </div>
                                <!--
                                <img src="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/img/user/<?= $comment->idAdviser ?>.png" alt="">
                                -->
                              </div>     
                              <span class="inline txt">
                                <h3><?= WalletsHasCampaigns::model()->with("idCampaign0")->findByAttributes(array("idWallet"=>$comment->idWallet))->idCampaign0->contactName; ?></h3>
                                <p><?= $comment->comment; ?></p>
                              </span>
                              <div class="inline date">
                                <?php 
                                  $secs = time()-(60*60*24);
                                  $diffTime = $secs - strtotime($comment->dCreation);
                                  if(($diffTime/60/60/24) < 1){
                                    $text=Yii::t("campaign","menosUnDia");
                                  }else{                                  
                                    $dias = floor($diffTime/60/60/24);
                                    $text = Yii::t("campaign","less").$dias. " " .Yii::t("campaign","days");
                                  }                                  
                                ?>
                                <p><span><?= $text?></span></p>
                              </div>
                               <div class="clear"></div>
                            </label>
                          </article>
                          <?php
                            }
                          }
                          ?>                                                                     
                        </div>
                      </section>
                      <!--Fin Comentarios-->
                    </article>
                    <!--Tab 2-->
                    <article id="datos_financieros" class="block">
                      <form action="" class="formweb">
                        <fieldset class="large-4 medium-12 small-12 columns padding">
                          <label><?=Yii::t("campaign","saldoInicial")?></label>
                          <input type="text" name="" disabled="true" placeholder="$ 100.000" value="$ <?= Yii::app()->format->formatNumber($model->capitalValue); ?>">
                          <label><?=Yii::t("campaign","tituloValor")?></label>
                          <input type="text" name="" disabled="true" placeholder="$ 299.999" value="$ <?= Yii::app()->format->formatNumber($model->titleValue); ?>">
                          <?php 
                            $interests = $model->interestsValue;
                          ?>
                          <?php 
                            $fee = $model->feeValue;
                          ?>
                          <?php 
                            $saldoTotal = $model->capitalValue + $interests + $fee;
                          ?>
                          <label><?=Yii::t("campaign","saldoTotal")?></label>                          
                          <input type="text" name="" disabled="true" placeholder="$ 80.000" value="$ <?= Yii::app()->format->formatNumber($saldoTotal); ?>">
                          <!-- <?php 
                            $saldoTotal = $model->capitalValue - $paymentAmount;
                          ?>
                          <label>Saldo en mora</label>
                          <input type="text" name="" disabled="true" placeholder="$ 50.000" value="$ <?= Yii::app()->format->formatNumber($saldoTotal); ?>"> -->
                        </fieldset>
                        <fieldset class="large-4 medium-12 small-12 columns padding">
                          <label><?=Yii::t("campaign","fechaVencimiento")?></label>
                          <input type="text" name="" disabled="true" placeholder="01/06/2016" value="<?= date("d/m/Y",strtotime($model->validThrough)); ?>">
                          <?php
                           $dStart = new DateTime('now');
                           $dEnd  = new DateTime($model->validThrough);
                           $dDiff = $dStart->diff($dEnd);
                           $diff = (int)$dDiff->format("%r%a");
                           if(($diff) < 1){
                              $text= $dDiff->days. " " . Yii::t("campaign","days");
                            }else{                                  
                              $text = "0 días";
                            }
                          ?>
                          <label><?=Yii::t("campaign","diasMora")?></label>
                          <input type="text" name="" disabled="true" placeholder="3 dias" value="<?= $text; ?>">
                          <label><?=Yii::t("campaign","valorRealizados")?></label>
                          <input type="text" name="" disabled="true" placeholder="$ 20.000" value="$ <?= Yii::app()->format->formatNumber($paymentAmount); ?>">
                          <!-- <?php 
                            $lastPayment = Lastpayments::model()->findByAttributes(array('idWallet'=>$model->idWallet));
                          ?>
                          <label>Fecha de pago realizado</label>
                          <?php 
                            if(count($lastPayment) >0){
                          ?>
                            <input type="text" name="" disabled="true" placeholder=" 04/05/2016" value="<?= date("d/m/Y",strtotime($lastPayment->dPayment)); ?>">
                          <?php }else{ ?>
                            <input type="text" name="" disabled="true" placeholder=" 04/05/2016">
                          <?php } ?> -->
                        </fieldset>
                        <fieldset class="large-4 medium-12 small-12 columns padding">
                          <label><?=Yii::t("campaign","producto")?></label>
                          <input type="text" name="" disabled="true" placeholder="" value="<?= $model->product; ?>">
                          <label><?=Yii::t("campaign","numeroCuenta")?></label>
                          <input type="text" name="" disabled="true" placeholder="2009409029" value="<?= $model->accountNumber ; ?>">
                          <label><?=Yii::t("campaign","fechaAsignacion")?></label>
                          <input type="text" name="" disabled="true" placeholder="30/04/2016" value="<?= date("d/m/Y",strtotime($model->dAssigment)); ?>">                          
                          <label><?=Yii::t("campaign","prescripcion")?></label>
                          <input type="text" name="" disabled="true" placeholder="30/04/2016" value="<?= date("d/m/Y",strtotime($model->prescription)); ?>">                          
                        </fieldset>
                          <div class="clear"></div>
                        <div class="clear"></div>
                      </form>
                    </article>
                    <!--Tab 3-->
                    <article id="historia_gestion" class="block">
                      <!--Datos acordeon-->
                      <article id="historia_gestion" class="block">
                      <!--Datos acordeon-->
                      <?php 
                        $managements = Management::model()->findAllByAttributes(array('idWallet'=>$model->idWallet));
                      ?>
                      <section class="padding">                                                
                        <ul class="collapsible acordeon_history" data-collapsible="accordion">
                          <div class="head">
                            <table class="bordered"> 
                              <thead>
                                <tr>
                                    <th class="txt_center"><?=Yii::t("campaign","asesor")?></th>
                                    <th class="txt_center"><?=Yii::t("campaign","fecha")?></th>
                                    <th class="txt_center"><?=Yii::t("campaign","gestion")?></th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                          <?php
                            if(count($managements) > 0){ 
                              foreach ($managements as $management) {
                                if($management->action == 'Promesa'){
                              ?>
                              <li>
                              <div class="collapsible-header">
                                <table class="bordered">
                                  <tbody>
                                    <tr>
                                      <td width="30%"><?= $management->asesor; ?></td>
                                      <td width="30%"><?= $management->fecha; ?></td>
                                      <td width="40%"><?= $management->action; ?> <a href="javascript:void(0)" class="clic_mas"><i class="fa fa-plus" aria-hidden="true"></i> <span class="inline">VER MÁS</span></a></td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                              <div class="collapsible-body padd_v">
                                <div class="large-4 medium-4 small-12 columns padding formweb">
                                  <label><?=$management->action=="Pago"?"Valor":"Comentarios"?></label>
                                  <p><?= ($management->action=="Pago"||$management->action=="Promesa") ? money_format('%n',$management->comment) : $management->comment; ?></p>
                                </div>
                                <div class="large-4 medium-4 small-12 columns padding formweb">
                                  <label>Gestión</label>
                                  <?php 
                                    $gestion = $management->action;
                                    if($management->effect != ''){
                                      $gestion .= " / ".$management->effect;
                                    }
                                  ?>
                                  <p><?= $gestion; ?></p>
                                </div>
                                <div class="large-4 medium-4 small-12 columns padding formweb">
                                  <label>Tiempo</label>
                                  <p><?= $management->timer; ?></p>
                                </div>
                                 <div class="clear"></div>
                              </div>
                            </li>

                              <?php

                                }
                              if($management->effect != null){                              
                          ?>
                            <li>
                              <div class="collapsible-header">
                                <table class="bordered">
                                  <tbody>
                                    <tr>
                                      <td width="30%"><?= $management->asesor; ?></td>
                                      <td width="30%"><?= $management->fecha; ?></td>
                                      <td width="40%"><?= $management->action; ?> <a href="javascript:void(0)" class="clic_mas"><i class="fa fa-plus" aria-hidden="true"></i> <span class="inline">VER MÁS</span></a></td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                              <div class="collapsible-body padd_v">
                                <div class="large-4 medium-4 small-12 columns padding formweb">
                                  <label><?=$management->action=="Pago"?"Valor":"Comentarios"?></label>
                                  <p><?= ($management->action=="Pago"||$management->action=="Promesa") ? money_format('%n',$management->comment) : $management->comment; ?></p>
                                </div>
                                <div class="large-4 medium-4 small-12 columns padding formweb">
                                  <label>Gestión</label>
                                  <?php 
                                    $gestion = $management->action;
                                    if($management->effect != ''){
                                      $gestion .= " / ".$management->effect;
                                    }
                                  ?>
                                  <p><?= $gestion; ?></p>
                                </div>
                                <div class="large-4 medium-4 small-12 columns padding formweb">
                                  <label>Tiempo</label>
                                  <p><?= $management->timer; ?></p>
                                </div>
                                 <div class="clear"></div>
                              </div>
                            </li>
                          <?php
                            }
                          }
                          }
                          ?>
                        </ul>
                      </section>
                      <div class="txt_right block padding">
                        <button id="downloadManagementPdf" target="_blank" class="btnb waves-effect waves-light">DESCARGAR</button>
                      </div>
                      <!--
                      <div class="clear"></div>
                      Fin Datos acordeon-->
                    </article>
                  </div>                  
                    <div class="clear"></div>
                </section>                
              </section>
              <!--Fin Tabs-->   
            </section>

            <div class="clear"></div>
          </section>
        </section>
          <div class="clear"></div>
      </section>

<script>
$(document).ready(function() {
  $('.commentsCheck').attr('disabled','disabled')
});
  $("#btnSaveComment").bind('click', function(){
            var idWallet = <?= $model->idWallet ?>;
            var idAdviser = <?= $model->idAdviser ?>;
            var comment = $("#comment").val();
            $.ajax({
                url: '<?php echo Yii::app()->getBaseUrl(true); ?>'+'/campaign/saveComment',
                type: 'POST',
                data:"idWallet="+idWallet+"&idAdviser="+idAdviser+"&comment="+comment,
                success: function (data) {
                   location.reload(true);   
                },
                error: function(data){
                  console.info(data);
                }
              });
          });


  $(function(){

    $("#downloadManagementPdf").bind('click', function(){
      var idWallet = <?= $model->idWallet ?>;
      window.open('<?= Yii::app()->getBaseUrl(true) ?>'+'/campaign/getManagementPdf/'+idWallet)
            
    });

  }); 
  // function updateComment(idComment){
  //   $.ajax({
  //               url: '<?php echo Yii::app()->getBaseUrl(true); ?>'+'/campaign/updateComment',
  //               type: 'POST',
  //               data:"idComment="+idComment,
  //               success: function (data) {
  //                  location.reload(true);   
  //               },
  //               error: function(data){
  //                 console.info(data);
  //               }
  //             });
  // }

  function preguntar(idSupport){
       eliminar=confirm("¿Deseas eliminar este registro?");
       if (eliminar){
          //Redireccionamos si das a aceptar
         //window.location.href = "delete.php?kdigo=valor"; //página web a la que te redirecciona si confirmas la eliminación
         //alert(idSupport);

         $.ajax({
            url: '<?php echo Yii::app()->getBaseUrl(true); ?>'+'/campaign/delete',
            type: 'POST',
            data:"idSupport="+idSupport,
            success: function (data) {
               location.reload(true); 
            },
            error: function(data){
              console.info(data);
            }
          });

       }

         //else
      //Y aquí pon cualquier cosa que quieras que salga si le diste al boton de cancelar
        //alert('No se ha podido eliminar el registro...')
      }
  
</script>