<?php 
  $whc = WalletsHasCampaigns::model()->findByAttributes(array("idWallet"=>$model->idWallet));
  $campaign = Campaigns::model()->findByPk($whc->idCampaign);
  $current_user=Yii::app()->user->id;
  Yii::app()->session['userView'.$current_user.'returnURL']=Yii::app()->request->Url;
  Yii::app()->session['userView'.$current_user.'idWallet']=$model->idWallet;
  setlocale(LC_MONETARY, "en_US");
  // echo "<pre>";
  // print_r($campaign);
  $name =  WalletsHasCampaigns::model()->with("idCampaign0")->findByAttributes(array("idWallet"=>$model->idWallet))->idCampaign0->contactName;
  $nameSeparete = explode(" ", $name);
 
  switch (count($nameSeparete)) {
  case 1:
    $iniciales = substr($name, 0,1) . substr($name, 1,1);
  break;
  case 3 :
    $iniciales = substr($nameSeparete[0], 0,1) . substr($nameSeparete[2], 0,1);
  break;
  default:
    $iniciales = substr($nameSeparete[0], 0,1). substr($nameSeparete[1], 0,1);
  break;
}
?>
<section class="cont_home" wim="90">       
        <section class="conten_inicial">
          <section class="wrapper_l dashContent p_t_25">
            
            <section class="padding">
              <!--Datos iniciales-->
              <section class="panelBG wow fadeInUp m_b_20">
                <div class="tittle_head">
                  <h2><table><tr><td><?= $model->legalName; ?><?= $current_user; ?></td><td><span style="text-align: right; float: right;"><b>Tiempo:</b> <span id ="timer"></span></span></td></tr></table> </h2>
                </div>
                <div class="row block padd_v">
                  <div id="frmManagement" class="form_register formweb wow fadeIn" action="" method="">
                     <fieldset class="large-8 medium-8 small-12 columns padding">
                       <div class="porcent_user">
                        <label>Porcentaje de recuperacion</label>                       
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
                       </div>
                     </fieldset>
                     <fieldset class="large-4 medium-4 small-12 columns padding">
                        <label>Estado por área de gestión</label>
                        <select id="status" onchange="tipoEstatusChange(this);">
                          <option value="">Seleccionar opción</option>
                          <?php  
                            foreach ($status as $stat) {
                              if($model->idStatus == $stat->idStatus){
                          ?>
                            <option value="<?= $stat->idStatus; ?>" selected="selected" ><?= $stat->description; ?></option>
                          <?php
                              }else{
                          ?>
                            <option value="<?= $stat->idStatus; ?>" ><?= $stat->description; ?></option>
                          <?php
                              }
                            }
                          ?>                          
                        </select> 
                     </fieldset>

                     <div class="clear"></div>
                       <div class="padding">
                         <div class="lineap"></div>
                       </div> 
                      <div class="clear"></div>

                     <fieldset class="large-4 medium-4 small-12 columns padding">
                        <fieldset class="row block">
                         <label>Pagos</label>
                          <select id="paymentType">
                            <option value="">Seleccionar opción</option>
                            <?php  
                            foreach ($paymentTypes as $paymentType) {
                            ?>
                              <option value="<?= $paymentType->idPaymentType; ?>" ><?= $paymentType->paymentTypeName; ?></option>
                            <?php
                                }
                            ?>
                          </select> 
                        </fieldset>
                        <fieldset class="row block">
                          <label>Valor</label>
                          <input type="text" name="" id="paymentValue">
                        </fieldset>
                        <fieldset class="row block">
                          <label>Fecha</label>
                          <div class="fecha">
                            <input type="date" class="calendar" id="paymentDate">
                          </div>
                        </fieldset>
                        <fieldset>
                          <h2><a href="#new_sporte_modal" class="modal_clic"><i class="fa fa-plus" aria-hidden="true"></i> NUEVO SOPORTE</a></h2>
                        </fieldset>
                        
                     </fieldset>
                     <fieldset class="large-8 medium-8 small-12 columns padding">
                      <div class="border_form padd_v m_b_10">
                        <fieldset class="large-6 medium-12 small-12 columns padding">
                          <label>Acción*</label>
                          <select id="actionSelect">
                            <option value="">Seleccionar opción</option>
                            <?php  
                            foreach ($actions as $action) {
                            ?>
                              <option value="<?= $action->idAction; ?>" ><?= $action->actionName; ?></option>
                            <?php
                                }
                            ?>
                          </select> 
                          <label>Efectos</label>                          
                          <select id="effectSelect">
                            <option value="">Seleccionar opción</option>
                            <option>Tipo de efecto</option>
                            <option>Tipo de efecto</option>
                            <option>Tipo de efecto</option>
                            <option>Tipo de efecto</option>
                            <option>Tipo de efecto</option>
                          </select> 
                          <label>Comentario</label>
                          <textarea name="" cols="30" rows="10" id="agendaComment"></textarea>
                        </fieldset>
                        <fieldset class="large-6 medium-12 small-12 columns padding">
                          <div class="tab_base m_t_20">
                            <a href="javascript:void(0)" class="large-6 medium-6 small-6 columns padding">
                              <input name="group1" type="radio" id="test1"  checked="checked" />
                              <label for="test1">Tarea</label>
                            </a>
                            <a href="javascript:void(0)" class="large-6 medium-6 small-6 columns padding">
                              <input name="group1" type="radio" id="test2" />
                              <label for="test2">Promesa</label>
                            </a>
                          </div>
                          <div class="tab_cont">
                            <fieldset class="row block">
                              <label>Acción*</label>
                              <select id="taskSelect">
                                <option value="">Seleccionar opción</option>
                                  <?php  
                                  foreach ($actions as $action) {
                                  ?>
                                    <option value="<?= $action->idAction; ?>" ><?= $action->actionName; ?></option>
                                  <?php
                                      }
                                  ?>
                              </select> 
                            </fieldset>                            
                            <fieldset class="row block">
                              <label>Fecha</label>
                              <div class="fecha">
                                <input id="agendaDate" type="date" class="calendar">
                              </div>
                            </fieldset>
                          </div>
                          <div class="tab_cont">
                            <fieldset class="row block">
                              <label>Valor</label>
                              <input type="text" name="" id="promiseValue">
                            </fieldset>                            
                            <fieldset class="row block">
                              <label>Fecha</label>
                              <div class="fecha">
                                <input type="date" class="calendar" id="promiseDate">
                              </div>
                            </fieldset>
                          </div>
                        </fieldset>
                      </div>
                      <button id="btnSaveManagement" class="btnb block waves-effect waves-light">GUARDAR</button>
                     </fieldset>
                      <div class="clear"></div>
                  </div> <!-- eRA fORM -->
                </div>
              </section>
              <!--Fin Datos iniciales-->

              <!--Tabs-->
              <div class="block">
                <ul class="tabs tab_cartera">
                  <li class="tab"><a href="#datos_personales"><i class="fa fa-user" aria-hidden="true"></i> DATOS PERSONALES</a></li>
                  <li class="tab"><a href="#datos_financieros"><i class="fa fa-usd" aria-hidden="true"></i> DATOS FINANCIEROS</a></li>
                  <li class="tab"><a href="#historia_gestion"><i class="fa fa-cog" aria-hidden="true"></i> HISTORIAL DE GESTIÓN</a></li>
                </ul>
              </div>                          
              <section class="panelBG wow fadeInUp m_b_20">
                <section class="padd_v">
                  <div class="row">  
                    <!--Tab 1-->
                    <?php                      
                      $geoInfo = Treedistricts::model()->findByAttributes(array('idDistrict'=>$model->idDistrict));
                      $geo = explode('-',$geoInfo);
                      $district = $geo[2];
                      $city = $geo[1];
                      $department = $geo[0];
                    ?>
                    <article id="datos_personales" class="block">
                      <form id="frmPersonalInfo" action="" class="formweb">
                        <fieldset class="large-6 medium-6 small-12 columns padding">
                          <label>Nombre / Razón Social</label>
                          <input type="text" id="infoName" name="" placeholder="Juan Camilo Hernandez" value="<?= $model->legalName; ?>" disabled>
                          <label>Cédula / NIT</label>
                          <input type="text" id="infoId" name="" placeholder="1099239292" value="<?= $model->idNumber; ?>" disabled>
                          <!-- <input type="text" name="" placeholder="Cundinamarca" value="<?= $department; ?>"> -->
                          <?php 
                            $cities=Cities::model()->findAll();                            
                          ?>
                          <label>Departamento</label>
                          <!-- <input type="text" name="" placeholder="Bogotá" value="<?= $city; ?>"> -->
                          <select id="infoCity" disabled>
                            <?php 
                              if(count($cities)>0){
                                foreach ($cities as $city) {
                            ?>
                              <option value="<?= $city->idCity; ?>"><?= $city->name;?></option>
                            <?php
                                }
                              }
                            ?>
                          </select>   
                          <?php 
                            $departments=Departaments::model()->findAll();                            
                          ?>
                          <label>País</label>
                          <select id="infoDepartment" disabled>
                            <?php 
                              if(count($departments)>0){
                                foreach ($departments as $department) {
                            ?>
                              <option value="<?= $department->idDepartament; ?>"><?= $department->name;?></option>
                            <?php
                                }
                              }
                            ?>
                          </select>                       
                          <label>Campaña</label>
                          <input type="text" disabled="true" name="" placeholder="<?= $campaign->name ?>" disabled>
                        </fieldset>
                        <fieldset class="large-6 medium-6 small-12 columns padding">
                          <label>Dirección</label>
                          <input type="text" name="" id="infoAddress" placeholder="Carrera 20 # 23 -90" value="<?= $model->address; ?>" disabled>
                          <?php 
                            $districts=Districts::model()->findAll();                            
                          ?>
                          <label>Ciudad</label>
                          <!-- <input type="text" name="" placeholder="Chapinero" value="<?= $district; ?>"> -->
                          <select id="infoDistricts" disabled>
                            <?php 
                              if(count($districts)>0){
                                foreach ($districts as $district) {
                            ?>
                              <option value="<?= $district->idDistrict; ?>"><?= $district->name;?></option>
                            <?php
                                }
                              }
                            ?>
                          </select>
                          <label>Teléfono</label>
                          <input type="text" name="" id="infoPhone" placeholder="301 030 20 30" value="<?= $model->phone; ?>" disabled>
                          <label>Correo Electrónico</label>
                          <input type="text" name="" id="infoEmail" placeholder="hernande@claro.com" value="<?= $model->email; ?>" disabled>
                          <label>Código</label>
                          
                          <input type="text" disabled="true" name="" placeholder="CJ-<?= $campaign->idCampaign ?>" disabled>
                        </fieldset>
                        <div class="txt_right block padding">
                          <button id="btnSaveInfo" class="btnb waves-effect waves-light">GUARDAR</button>
                        </div>
                      </form>
                      <!--Datos acordeon-->
                      <section class="padd_all">
                        <ul class="bg_acordeon">
                          <li class="content_acord">
                            <div class="acordeon">                          
                              <div class="triangulo"><i class="fa fa-chevron-down" aria-hidden="true"></i></div>
                              Teléfonos
                              <a id="btnNewPhone" class="modal_clic" href="#new_phone_modal"><i class="fa fa-plus" aria-hidden="true"></i> NUEVO TELÉFONO</a>
                            </div>
                            <?php 
                              $demographicPhones = Demographics::model()->findAllByAttributes(array('idWallet'=>$model->idWallet,'idType'=>'1'));                              
                            ?>
                            <div class="clearfix respuesta">
                              <table class="bordered responsive-table">
                                <tbody>
                                  <?php
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
                                        <a href="#new_phone_modal" 
                                           class="inline padding tooltipped editPhone modal_clic" 
                                           data-position="top" 
                                           data-delay="50" 
                                           data-tooltip="Editar" 
                                           data-id="<?= $demographicPhone->idDemographic;?>" 
                                           data-phonetype="<?= $demographicPhone->phoneType;?>"
                                           data-department="<?= $city->departments->idDepartament;?>"
                                           data-city="<?= $city->idCity;?>"
                                           data-phone="<?= $demographicPhone->value;?>"
                                          ><i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                        <a href="<?= Yii::app()->baseUrl; ?>/wallet/deleteDemographic/<?= $demographicPhone->idDemographic; ?>" class="inline padding tooltipped delete" data-position="top" data-delay="50" data-tooltip="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></a>
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
                              Referencias
                              <a id="btnNewReference" class="modal_clic" href="#new_referencia_modal"><i class="fa fa-plus" aria-hidden="true"></i> NUEVA REFERENCIA</a>
                            </div>
                            <?php 
                              $demographicReferences = Demographics::model()->findAllByAttributes(array('idWallet'=>$model->idWallet,'idType'=>'2'));                              
                            ?>
                            <div class="clearfix respuesta">
                              <table class="bordered responsive-table">
                                <tbody>
                                <?php
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
                                      <a href="#new_referencia_modal" 
                                         class="inline padding tooltipped editReference modal_clic" 
                                         data-position="top" 
                                         data-delay="50" 
                                         data-tooltip="Editar"
                                         data-id="<?= $demographicReference->idDemographic;?>"
                                         data-name="<?= $demographicReference->value; ?>"
                                         data-relationship="<?= $demographicReference->relationshipType; ?>"
                                         data-comments="<?= $demographicReference->comment; ?>"
                                         data-department="<?= $city->departments->idDepartament;?>"
                                         data-city="<?= $city->idCity;?>"
                                        ><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                      <a href="<?= Yii::app()->baseUrl; ?>/wallet/deleteDemographic/<?= $demographicReference->idDemographic; ?>" class="inline padding tooltipped delete" data-position="top" data-delay="50" data-tooltip="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></a>
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
                              Correo
                              <a id="btnNewEmail" class="modal_clic" href="#new_correo_modal"><i class="fa fa-plus" aria-hidden="true"></i> NUEVO CORREO</a>
                            </div>
                            <?php 
                              $demographicEmail = Demographics::model()->findAllByAttributes(array('idWallet'=>$model->idWallet,'idType'=>'3'));                              
                            ?>
                            <div class="clearfix respuesta">
                              <table class="bordered responsive-table">
                                <tbody>
                                <?php
                                  if(count($demographicEmail) > 0){ 
                                    foreach ($demographicEmail as $demographEmail) {                                                                          
                                ?>
                                  <tr>
                                    <td class="txt_center"><?= $demographEmail->contactName; ?></td>
                                    <td class="txt_center"><?= $demographEmail->value; ?></td>
                                    <td class="txt_center icon_table">                                  
                                      <a href="#new_correo_modal" 
                                         class="inline padding tooltipped editEmail modal_clic" 
                                         data-position="top" 
                                         data-delay="50" 
                                         data-tooltip="Editar"
                                         data-id="<?= $demographEmail->idDemographic;?>"
                                         data-contact="<?= $demographEmail->contactName; ?>"
                                         data-email="<?= $demographEmail->value; ?>"
                                        ><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                      <a href="<?= Yii::app()->baseUrl; ?>/wallet/deleteDemographic/<?= $demographEmail->idDemographic; ?>" class="inline padding tooltipped delete" data-position="top" data-delay="50" data-tooltip="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></a>
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
                              Direcciones
                              <a id="btnNewAddress" class="modal_clic" href="#new_address_modal"><i class="fa fa-plus" aria-hidden="true"></i> NUEVA DIRECCIÓN</a>
                            </div>
                            <?php 
                              $demographicAddresses = Demographics::model()->findAllByAttributes(array('idWallet'=>$model->idWallet,'idType'=>'4'));                              
                            ?>
                            <div class="clearfix respuesta">
                              <table class="bordered responsive-table">
                                <tbody>
                                <?php
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
                                      <a href="#new_address_modal" 
                                         class="inline padding tooltipped editAddress modal_clic" 
                                         data-position="top" 
                                         data-delay="50" 
                                         data-tooltip="Editar"
                                         data-id="<?= $demographicAddress->idDemographic;?>" 
                                         data-addresstype="<?= $demographicAddress->addressType;?>"
                                         data-department="<?= $city->departments->idDepartament;?>"
                                         data-city="<?= $city->idCity;?>"
                                         data-address="<?= $demographicAddress->value;?>"
                                        ><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                      <a href="<?= Yii::app()->baseUrl; ?>/wallet/deleteDemographic/<?= $demographicAddress->idDemographic; ?>" class="inline padding tooltipped delete" data-position="top" data-delay="50" data-tooltip="Eliminar"><i class="fa fa-times" aria-hidden="true"></i></a>
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
                          <h2><i class="fa fa-home" aria-hidden="true"></i> BIENES <a href="#new_bien_modal" class="modal_clic"><i class="fa fa-plus" aria-hidden="true"></i> NUEVO BIEN</a></h2>
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
                                <h3><?= $asset->assetName; ?>
                                  <a href="#new_bien_modal" 
                                     class="tooltipped editAsset modal_clic" 
                                     data-position="top" 
                                     data-delay="50" 
                                     data-tooltip="Editar"
                                     data-id="<?= $asset->idAsset; ?>"
                                     data-assetName="<?= $asset->assetName; ?>"
                                     data-assetType="<?= $asset->idType; ?>"
                                     data-assetComment="<?= $asset->description; ?>"
                                     data-dCreation="<?= explode(' ',$asset->dCreation)[0]; ?>"                                     
                                  ><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                </h3>
                                <div class="padd_all">
                                  <p><span>Fecha de ingreso: <?= date("d/m/Y",strtotime($asset->dCreation)); ?></span></p>
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
                          <h2><i class="fa fa-file-text-o" aria-hidden="true"></i> SOPORTES <a href="#new_sporte_modal" class="modal_clic"><i class="fa fa-plus" aria-hidden="true"></i> NUEVO SOPORTE</a></h2>
                        </div>
                        <?php 
                              $supports = Supports::model()->findAllByAttributes(array('idWallet'=>$model->idWallet));
                        ?>
                        <div class="row block">
                          <table class="bordered responsive-table">
                            <thead>
                              <td>
                                  <label>Nombre de archivo</label>
                              </td>
                              <td class="formweb">
                                  <select id="supportsSelect">
                                    <option value="0">Seleccionar opción</option>
                                    <?php foreach ($supports as $support) {
                                    ?>
                                    <option value="<?=$support->idsupports?>"><?=$support->fileName?></option>
                                    <?php } ?>
                                  </select>  
                              </td>
                            </thead id="tableSupports">
                            <tbody id="tableSupports">
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
                                  <!--
                                  <a href="#new_sporte_modal" 
                                     class="inline padding tooltipped editSoporte modal_clic" 
                                     data-position="top" 
                                     data-delay="50" 
                                     data-tooltip="Eliminar"
                                     data-id="<?= $support->idsupports; ?>"
                                     data-fileName="<?= $support->fileName; ?>"
                                     data-fileType="<?= $support->fileType; ?>"
                                     data-dFile="<?= $support->dFile; ?>">
                                     <i class="fa fa-trash" aria-hidden="true"></i></a>
                                  -->
                                  <a href="javascript:preguntar(<?=$support->idsupports?>)"><i class="fa fa-trash" aria-hidden="true"></i></a>

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
                          <h2><i class="fa fa-comment-o" aria-hidden="true"></i> COMENTARIOS</h2>
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
                            <input type="checkbox" <?= $comment->status==true?"checked" : "" ?> data-comment="<?= $comment->idComment ?>"  name="comentAproved<?= $comment->idComment?>" id="check<?= $comment->idComment?>" class="checkComment" onclick="updateComment(<?= $comment->idComment ?>)">
                            <label for="check<?= $comment->idComment ?>" class="block">
                              <div class="img_perfil">
                                <!--<img src="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/img/user/<?= $comment->idAdviser ?>.png" alt="">
                                -->
                                <!--
                                <img src="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/img/user/27.png" alt="">
                                -->
                                <div class="bg_profile">
                                  <div class="user_log responsive-img">
                                    <span class="iniciales2"> <?= strtoupper($iniciales); ?> </span>
                                  </div>
                                </div>

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
                                    $text="Hace menos de 1 día";
                                  }else{                                  
                                    $dias = floor($diffTime/60/60/24);
                                    $text = "Hace ".$dias." día(s)";
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
                      <form id="frmFinantial" action="" class="formweb">
                        <fieldset class="large-4 medium-12 small-12 columns padding">
                          <label>Saldo inicial</label>
                          <input type="text" name="" placeholder="$ 100.000" value="$ <?= Yii::app()->format->formatNumber($model->capitalValue); ?>"  disabled>
                          <?php 
                            $interests = $model->interestsValue;
                          ?>
                          <label>Intereses</label>
                          <input type="text" name="" placeholder="" value="$ <?= Yii::app()->format->formatNumber($interests); ?>" disabled>
                          <?php 
                            $fee = $model->feeValue;
                          ?>
                          <label>Honorarios</label>
                          <input type="text" name="" placeholder="$ 3.000.000" value="$ <?= Yii::app()->format->formatNumber($fee); ?>" disabled>
                          <?php 
                            $saldoTotal = $model->capitalValue + $interests + $fee;
                          ?>
                          <label>Saldo total</label>                          
                          <input type="text" name="" placeholder="$ 80.000" value="$ <?= Yii::app()->format->formatNumber($saldoTotal); ?>" disabled>
                          <?php 
                            $saldoTotal = $model->capitalValue - $paymentAmount;
                          ?>
                          <label>Saldo en mora</label>
                          <input type="text" name="" placeholder="$ 50.000" value="$ <?= Yii::app()->format->formatNumber($saldoTotal); ?>" disabled>
                        </fieldset>
                        <fieldset class="large-4 medium-12 small-12 columns padding">
                          <label>Titulo valor</label>
                          <input type="text" name="" placeholder="$ 299.999" value="$ <?= Yii::app()->format->formatNumber($model->titleValue); ?>" disabled>
                          <label>Fecha de vencimiento</label>
                          <input type="text" name="" placeholder="01/06/2016" value="<?= date("d/m/Y",strtotime($model->validThrough)); ?>" disabled>
                          <?php
                           $dStart = new DateTime('now');
                           $dEnd  = new DateTime($model->validThrough);
                           $dDiff = $dStart->diff($dEnd);
                           $diff = (int)$dDiff->format("%r%a");
                           if(($diff) < 1){
                              $text= $dDiff->days." día(s)";
                            }else{                                  
                              $text = "0 días";
                            }
                          ?>
                          <label>Dias de mora a la fecha</label>
                          <input type="text" name="" placeholder="3 dias" value="<?= $text; ?>" disabled>
                          <label>Valor pagos realizados</label>
                          <input type="text" name="" placeholder="$ 20.000" value="$ <?= Yii::app()->format->formatNumber($paymentAmount); ?>" disabled>
                          <?php 
                            $lastPayment = Lastpayments::model()->findByAttributes(array('idWallet'=>$model->idWallet));
                          ?>
                          <label>Fecha de pago realizado</label>
                          <?php 
                            if(count($lastPayment) >0){
                          ?>
                            <input type="text" name="" placeholder=" 04/05/2016" value="<?= date("d/m/Y",strtotime($lastPayment->dPayment)); ?>" disabled>
                          <?php }else{ ?>
                            <input type="text" name="" placeholder=" 04/05/2016" disabled>
                          <?php } ?>
                        </fieldset>
                        <fieldset class="large-4 medium-12 small-12 columns padding">
                          <label>Producto</label>
                          <input type="text" name="" placeholder="" value="<?= $model->product; ?>" disabled>
                          <label>Número de cuenta</label>
                          <input type="text" name="" placeholder="2009409029" value="<?= $model->accountNumber ; ?>" disabled>
                          <label>Fecha asignación</label>
                          <input type="text" name="" placeholder="30/04/2016" value="<?= date("d/m/Y",strtotime($model->dAssigment)); ?>" disabled>                          
                          <label><?=Yii::t("campaign","prescripcion")?></label>
                          <input type="text" name="" disabled="true" placeholder="30/04/2016" value="<?= date("d/m/Y",strtotime($model->prescription)); ?>">                          
                        </fieldset>
                          <div class="clear"></div>
                        <div class="lineap"></div>
                        <div class="padding">
                          <legend class="block">Datos Juzgado</legend>
                        </div>
                        <fieldset class="large-4 medium-12 small-12 columns padding">
                          <label class="active">Juzgado</label>
                          <input id="negotiation" type="text" name="" placeholder="" value="<?= $model->negotiation; ?>">
                          <label class="active">Estado</label>
                          <input id="vendorEmail" type="text" name="" placeholder="" value="<?= $model->vendorEmail; ?>">
                        </fieldset>
                        <fieldset class="large-4 medium-12 small-12 columns padding">
                          <label class="active">Nombre del Abogado</label>
                          <input id="vendorName" type="text" name="" placeholder="" value="<?= $model->vendorName; ?>">
                        </fieldset>
                        <fieldset class="large-4 medium-12 small-12 columns padding">
                          <label class="active">Referencia - Radicado</label>
                          <input id="vendorPhone" type="text" name="" placeholder="" value="<?= $model->vendorPhone; ?>">                          
                        </fieldset>
                        <div class="clear"></div>
                        <div class="txt_right block padding">
                          <button id="saveFinantial" type="submit" class="btnb waves-effect waves-light">ACTUALIZAR</button>
                        </div>
                      </form>
                    </article>
                    <!--Tab 3-->
                    <article id="historia_gestion" class="block">
                      <!--Datos acordeon-->
                      <?php 
                        $managements = Management::model()->findAllByAttributes(array('idWallet'=>$model->idWallet), array('order'=>'fecha DESC'));
                      ?>
                      <section class="padding">                                                
                        <ul class="collapsible acordeon_history" data-collapsible="accordion">
                          <div class="head">
                            <table class="bordered"> 
                              <thead>
                                <tr>
                                    <th class="txt_center">ASESOR</th>
                                    <th class="txt_center">FECHA</th>
                                    <th class="txt_center">GESTION</th>
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
                      <!--Fin Datos acordeon-->
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
      <input type="hidden" id="idWallet" value="<?= $model->idWallet?>">
      <?php
        $idAdviser = Yii::app()->session['cojunal']->idAdviser;
      ?>
      <input type="hidden" id="idAdviser" value="<?= $idAdviser?>">

      <script type="text/javascript">
        var seconds = 0;
        $(function(){

          $("#supportsSelect").change(function(){
            $.ajax({
                url: '<?php echo Yii::app()->getBaseUrl(true); ?>'+'/supports/filter',
                type: 'GET',
                data : {
                  "idSupport" : $(this).val(),
                  "wallet" : <?= $model->idWallet?>
                },
                dataType : "html",
                success: function (data) {
                  $("#tableSupports").html("");
                  $("#tableSupports").html(data);
                },
                error: function(data){
                  console.log(data); 
                }
            });
          });

          setInterval(function(){  
            convertTime(seconds++);
          }, 1000);

          $("#btnNewPhone").bind('click', function(){
            $("#new_phone_modal #idDemographic").val("");
            $("#new_phone_modal #phoneType").val("");
            $("#new_phone_modal #phoneNumber").val("");
            $("#new_phone_modal #modalPhoneDepartments").val("");
            $("#new_phone_modal #modalPhoneCities").val("");          
          });

          $(".editPhone").bind('click', function(){
            var id         = $(this).attr('data-id');
            var phonetype  = $(this).attr('data-phonetype');
            var department = $(this).attr('data-department');
            var city       = $(this).attr('data-city');
            var phone      = $(this).attr('data-phone');
            
            $("#new_phone_modal #idDemographic").val(id);
            $("#new_phone_modal #phoneType").val(phonetype);
            $("#new_phone_modal #phoneNumber").val(phone);
            $("#new_phone_modal #modalPhoneDepartments").val(department).trigger('change');
            setTimeout(function(){
              $("#new_phone_modal #modalPhoneCities").val(city);
            },500);
            

          });

          $("#btnNewReference").bind('click', function(){
            $("#new_referencia_modal #idDemographicReference").val("");
            $("#new_referencia_modal #modalReferenceName").val("");
            $("#new_referencia_modal #modalReferenceRelationship").val("");
            $("#new_referencia_modal #modalReferenceDepartments").val("");
            $("#new_referencia_modal #modalReferenceCities").val("");
            $("#new_referencia_modal #modalReferenceComments").val("");          
          });

          $(".editReference").bind('click', function(){
            var id           = $(this).attr('data-id');
            var name         = $(this).attr('data-name');
            var relationship = $(this).attr('data-relationship');
            var comments     = $(this).attr('data-comments');
            var department   = $(this).attr('data-department');
            var city         = $(this).attr('data-city');
            
            $("#new_referencia_modal #idDemographicReference").val(id);
            $("#new_referencia_modal #modalReferenceName").val(name);
            $("#new_referencia_modal #modalReferenceRelationship").val(relationship);
            $("#new_referencia_modal #modalReferenceComments").val(comments);
            $("#new_referencia_modal #modalReferenceDepartments").val(department).trigger('change');
            setTimeout(function(){
              $("#new_referencia_modal #modalReferenceCities").val(city);
            },500);
            

          });

          $("#btnNewEmail").bind('click', function(){
            $("#new_correo_modal #idDemographicEmail").val("");
            $("#new_correo_modal #modalEmailName").val("");
            $("#new_correo_modal #modalEmailEmail").val("");                      
          });

          $(".editEmail").bind('click', function(){
            var id      = $(this).attr('data-id');
            var contact = $(this).attr('data-contact');
            var email   = $(this).attr('data-email');
           
            
            $("#new_correo_modal #idDemographicEmail").val(id);
            $("#new_correo_modal #modalEmailName").val(contact);
            $("#new_correo_modal #modalEmailEmail").val(email);            
          });

          $("#btnNewAddress").bind('click', function(){
            $("#new_address_modal #idDemographicAddress").val("");
            $("#new_address_modal #modalAddressType").val("");
            $("#new_address_modal #modalAddressAddress").val("");
            $("#new_address_modal #modalAddressDepartments").val("");
            $("#new_address_modal #modalAddressCities").val("");          
          });

          $(".editAddress").bind('click', function(){
            var id          = $(this).attr('data-id');
            var addresstype = $(this).attr('data-addresstype');
            var department  = $(this).attr('data-department');
            var city        = $(this).attr('data-city');
            var address     = $(this).attr('data-address');
            
            $("#new_address_modal #idDemographicAddress").val(id);
            $("#new_address_modal #modalAddressType").val(addresstype);
            $("#new_address_modal #modalAddressAddress").val(address);
            $("#new_address_modal #modalAddressDepartments").val(department).trigger('change');
            setTimeout(function(){
              $("#new_address_modal #modalAddressCities").val(city);
            },500);
          });

          $(".editSoporte").bind('click', function(){

            var idSupport = $(this).attr('data-id');
            var fileName = $(this).attr('data-fileName');
            var fileType = $(this).attr('data-fileType');
            var dFile    = $(this).attr('data-dFile');

            $("#Supports_fileName").val(fileName);
            $("#Supports_dFile").val(revertDate(dFile));
            $("#idSupport").val(idSupport);
            $("#idOldFname").val(fileName);
            $("#idOldFtype").val(fileType);
            
          });

          $(".editAsset").bind('click',function(){
            var id = $(this).attr('data-id');
            var assetName = $(this).attr('data-assetName');
            var assetType = $(this).attr('data-assetType');
            var assetComment = $(this).attr('data-assetComment');
            var dCreation =$(this).attr('data-dCreation');

            $("#assetType").val(assetType);
            $("#assetName").val(assetName);
            $("#assetDate").val(revertDate(dCreation));
            $("#assetDescription").val(assetComment);
            $("#idAsset").val(id);

          });

          $("#downloadManagementPdf").bind('click', function(){
            var idWallet = $("#idWallet").val();
            window.open('<?php echo Yii::app()->getBaseUrl(true); ?>'+'/wallet/getManagementPdf/'+idWallet)
            
          });

          $("#frmManagement").submit(function(e){
            e.preventDefault();
          });

          $("#frmPersonalInfo").submit(function(e){
            e.preventDefault();
          });
          
          $("#frmFinantial").submit(function(e){
            e.preventDefault();
          });

          $("#actionSelect").change(function(){
            $.ajax({
                url: '<?php echo Yii::app()->getBaseUrl(true); ?>'+'/wallet/getEffects/'+$(this).val(),
                type: 'get',
                data: {},
                success: function (data) {
                   $("#effectSelect").html('');
                   $("#effectSelect").html(data); 
                }
              });
          });

          $("#btnSaveManagement").bind('click', function(){
            var idWallet      = $("#idWallet").val();
            var idAdviser     = $("#idAdviser").val();
            var status        = $("#status").val();
            var paymentType   = $("#paymentType").val();
            var paymentValue  = $("#paymentValue").val();
            var paymentDate   = $("#paymentDate").val();
            var agendaAction  = $("#actionSelect").val();
            var agendaEffect  = $("#effectSelect").val();
            var agendaComment = $("#agendaComment").val();
            var agendaDate    = $("#agendaDate").val();
            var promiseValue  = $("#promiseValue").val();
            var promiseDate   = $("#promiseDate").val();
            var idAction      = $("#taskSelect").val();
            var taskDate      = $("#agendaDate").val();
            var timer         = $("#timer").html();


            //alert($("#idWallet").val()+'---'+$("#idAdviser").val()+'---'+$("#promiseValue").val()+'---'+$("#promiseDate").val()+'---'+$("#timer").html());

            //alert(status+'---'+idWallet);

            $.ajax({
                url: '<?php echo Yii::app()->getBaseUrl(true); ?>'+'/wallet/save',
                type: 'POST',
                
                data:"idWallet="+idWallet+"&idAdviser="+idAdviser+"&status="+status+"&paymentType="+paymentType+"&paymentValue="+paymentValue+"&paymentDate="+paymentDate+"&agendaAction="+agendaAction+"&agendaEffect="+agendaEffect+"&agendaComment="+agendaComment+"&agendaDate="+agendaDate+"&promiseValue="+promiseValue+"&promiseDate="+promiseDate+"&idAction="+idAction+"&taskDate="+taskDate+"&timer="+timer,

                success: function (data) {
                   location.reload(true); 
                },
                error: function(data){
                  console.info(data);
                }
              });
          });

          $("#btnSaveInfo").bind('click', function(){
            var idWallet      = $("#idWallet").val();
            var idAdviser     = $("#idAdviser").val();
            var infoName      = $("#infoName").val();
            var infoId        = $("#infoId").val();
            var infoAddress   = $("#infoAddress").val();
            var infoDistricts = $("#infoDistricts").val();
            var infoPhone     = $("#infoPhone").val();
            var infoEmail     = $("#infoEmail").val();

            $.ajax({
                url: '<?php echo Yii::app()->getBaseUrl(true); ?>'+'/wallet/saveInfo',
                type: 'POST',
                data:"idWallet="+idWallet+"&idAdviser="+idAdviser+"&infoName="+infoName+"&infoId="+infoId+"&infoAddress="+infoAddress+"&infoDistricts="+infoDistricts+"&infoPhone="+infoPhone+"&infoEmail="+infoEmail,
                success: function (data) {
                   location.reload(true); 
                },
                error: function(data){
                  console.info(data);
                }
              });
          });

        $("#saveFinantial").bind('click', function(){
          var idWallet    = $("#idWallet").val();
          var idAdviser   = $("#idAdviser").val();
          var negotiation = $("#negotiation").val();
          var vendorEmail = $("#vendorEmail").val();
          var vendorName  = $("#vendorName").val();
          var vendorPhone = $("#vendorPhone").val();

          $.ajax({
            url: '<?php echo Yii::app()->getBaseUrl(true); ?>'+'/wallet/saveFinantial',
            type: 'POST',
            data:"idWallet="+idWallet+"&idAdviser="+idAdviser+"&negotiation="+negotiation+"&vendorEmail="+vendorEmail+"&vendorName="+vendorName+"&vendorPhone="+vendorPhone,
            success: function (data) {
               location.reload(true); 
            },
            error: function(data){
              console.info(data);
            }
          });
        });

        });

      function preguntar(idSupport){
       eliminar=confirm("¿Deseas eliminar este registro?");
       if (eliminar){
          //Redireccionamos si das a aceptar
         //window.location.href = "delete.php?kdigo=valor"; //página web a la que te redirecciona si confirmas la eliminación
         //alert(idSupport);

         $.ajax({
            url: '<?php echo Yii::app()->getBaseUrl(true); ?>'+'/wallet/delete',
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

       function updateComment(idComment){
          $.ajax({
                      url: '<?php echo Yii::app()->getBaseUrl(true); ?>'+'/wallet/updateComment',
                      type: 'POST',
                      data:"idComment="+idComment,
                      success: function (data) {
                         location.reload(true);   
                      },
                      error: function(data){
                        console.info(data);
                      }
                    });
        }

        function revertDate(date){
          arrDate = date.split('-');
          months = {
            '01':'Enero',
            '02':'Febrero',
            '03':'Marzo',
            '04':'Abril',
            '05':'Mayo',
            '06':'Junio',
            '07':'Julio',
            '08':'Agosto',
            '09':'Septiembre',
            '10':'Octubre',
            '11':'Noviembre',
            '12':'Diciembre'
          };
          newDate = arrDate[2]+" "+months[arrDate[1]]+", "+arrDate[0];
          return newDate;
        }

        function convertTime(secconds){
          // multiply by 1000 because Date() requires miliseconds
          var date = new Date(seconds * 1000);
          var hh = date.getUTCHours();
          var mm = date.getUTCMinutes();
          var ss = date.getSeconds();
          // If you were building a timestamp instead of a duration, you would uncomment the following line to get 12-hour (not 24) time
          // if (hh > 12) {hh = hh % 12;}
          // These lines ensure you have two-digits
          if (hh < 10) {hh = "0"+hh;}
          if (mm < 10) {mm = "0"+mm;}
          if (ss < 10) {ss = "0"+ss;}
          // This formats your string to HH:MM:SS
          var t = hh+":"+mm+":"+ss;
          $("#timer").html("");
          $("#timer").html(t);
        }

        function tipoEstatusChange(tipo){
          var idWallet  = $("#idWallet").val();
          var status = $("#status").val();

          //alert(status+'---'+idWallet);

            $.ajax({
                url: '<?php echo Yii::app()->getBaseUrl(true); ?>'+'/wallet/tipoEstatus',
                type: 'POST',
                
                data:"idWallet="+idWallet+"&status="+status,

                success: function (data) {
                   location.reload(true); 
                },
                error: function(data){
                  console.info(data);
                }
              });
        }

      </script>