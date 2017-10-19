<section id="new_pass" class="modal modal-s">
  <div class="modal-header">
    <h1><?= Yii::t("profile","changePassword")?></h1>
    <div class="rc-anchor-content">
      <div class="rc-inline-block">
        <div class="rc-anchor-center-container">
          <div class="rc-anchor-center-item rc-anchor-error-message" id="errorModalChangePasswd" style="color:red; font-weight: bolder;">
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row padd_v">
    <form id="frmUpdatePasswd" class="formweb">
      <fieldset class="large-12 medium-12 small-12 columns padding">
          <label><?=Yii::t("profile", "lastPassword")?></label>                       
          <input type="password" name="lastPass" id="lastPass">
      </fieldset>
      <fieldset class="large-12 medium-12 small-12 columns padding">
          <label><?=Yii::t("profile", "newPassword")?></label>                       
          <input type="password" name="newPass" id="newPass">
      </fieldset>
      <fieldset class="large-12 medium-12 small-12 columns padding">
          <label><?=Yii::t("profile", "repeatPassword")?></label>                       
          <input type="password" name="repeatPass" id="repeatPass">
          <input type="hidden" name="YII_CSRF_TOKEN" id="YII_CSRF_TOKEN" value="<?php echo Yii::app()->request->csrfToken ?>">
      </fieldset>
        <div class="clear"></div>
    </form>
  </div>
  <div class="modal-footer">    
    <button type="submit" class="btnb waves-effect waves-light right" id="savePasswd"><?=Yii::t("profile", "save")?></button>
    <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right"><?=Yii::t("profile", "cancel")?></a>
  </div>
</section>

<!-- Modal New Phone -->
<section id="new_phone_modal" class="modal modal-m">
  <div class="modal-header">
    <h1>NUEVO TELÉFONO</h1>
  </div>
  <div class="row padd_v">
    <form id="" class="formweb " action="" method="">
      <fieldset class="large-6 medium-6 small-12 columns padding">
          <label>Tipo</label>                       
          <input id="phoneType" type="text">
          <label>Número</label>                       
          <input id="phoneNumber" type="number">
      </fieldset>
      <fieldset class="large-6 medium-6 small-12 columns padding">
          <?php 
            $departments=Departaments::model()->findAll();                            
          ?>
          <label>País</label>                       
          <select name="" id="modalPhoneDepartments">
            <option value="">Seleccionar opción</option>
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
          <label>Departamento</label>                       
          <select name="" id="modalPhoneCities">
            <option value="">Seleccionar opción</option>            
          </select>
          <input id="idDemographic" type="hidden" value="" />
      </fieldset>
        <div class="clear"></div>
    </form>
  </div>
  <div class="modal-footer">    
    <a id="saveDemographicPhoneModel" href="" class="btnb waves-effect waves-light right">GUARDAR</a>
    <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right">CANCELAR</a>
  </div>
</section>
<!-- Fin Modal New Phone -->

<!-- Modal New Referencia -->
<section id="new_referencia_modal" class="modal modal-m">
  <div class="modal-header">
    <h1>NUEVA REFERENCIA</h1>
  </div>
  <div class="row padd_v">
    <form id="" class="formweb " action="" method="">
      <fieldset class="large-6 medium-6 small-12 columns padding">
          <label>Nombre</label>                       
          <input id="modalReferenceName" type="text">
          <label>Parentesco</label>                       
          <input id="modalReferenceRelationship" type="text">
      </fieldset>
      <fieldset class="large-6 medium-6 small-12 columns padding">
          <?php 
            $departments=Departaments::model()->findAll();                            
          ?>
          <label>País</label>                       
          <select name="" id="modalReferenceDepartments">
            <option value="">Seleccionar opción</option>
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
          <label>Departamento</label>                       
          <select name="" id="modalReferenceCities">
            <option value="">Seleccionar opción</option>            
          </select>
      </fieldset>
        <div class="clear"></div>
      <fieldset class="large-12 medium-12 small-12 columns padding">
        <label>Comentarios</label>                       
        <textarea name="" id="modalReferenceComments" cols="30" rows="10"></textarea>
      </fieldset>
      <input id="idDemographicReference" type="hidden" value="" />
        <div class="clear"></div>
    </form>
  </div>
  <div class="modal-footer">    
    <a id="saveDemographicReference" href="" class="btnb waves-effect waves-light right">GUARDAR</a>
    <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right">CANCELAR</a>
  </div>
</section>
<!-- Fin Modal New Referencia -->

<!-- Modal New Correo -->
<section id="new_correo_modal" class="modal modal-m">
  <div class="modal-header">
    <h1>NUEVO CORREO</h1>
  </div>
  <div class="row padd_v">
    <form id="" class="formweb " action="" method="">
      <fieldset class="large-6 medium-6 small-12 columns padding">
          <label>Nombre</label>                       
          <input id="modalEmailName" type="text">
      </fieldset>
      <fieldset class="large-6 medium-6 small-12 columns padding">
          <label>Correo</label>                       
          <input id="modalEmailEmail" type="email">
      </fieldset>
      <input id="idDemographicEmail" type="hidden" value"" />
        <div class="clear"></div>
    </form>
  </div>
  <div class="modal-footer">    
    <a id = "saveDemographicEmail" href="" class="btnb waves-effect waves-light right">GUARDAR</a>
    <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right">CANCELAR</a>
  </div>
</section>
<!-- Fin Modal New Correo -->


<!-- Modal New Phone -->
<section id="new_address_modal" class="modal modal-m">
  <div class="modal-header">
    <h1>NUEVA DIRECCIÓN</h1>
  </div>
  <div class="row padd_v">
    <form id="" class="formweb " action="" method="">
      <fieldset class="large-6 medium-6 small-12 columns padding">          
          <label>Tipo</label>                       
          <input id="modalAddressType" type="text">
          <label>Dirección</label>                       
          <input id="modalAddressAddress" type="text">
      </fieldset>
      <fieldset class="large-6 medium-6 small-12 columns padding">
          <?php 
            $departments=Departaments::model()->findAll();                            
          ?>
          <label>País</label>                       
          <select name="" id="modalAddressDepartments">
            <option value="">Seleccionar opción</option>
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
          <label>Departamento</label>                       
          <select name="" id="modalAddressCities">
            <option value="">Seleccionar opción</option>            
          </select>
      </fieldset>
      <input id="idDemographicAddress" type="hidden" value="" />
        <div class="clear"></div>
    </form>
  </div>
  <div class="modal-footer">    
    <a id="saveDemographicAddress" href="" class="btnb waves-effect waves-light right">GUARDAR</a>
    <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right">CANCELAR</a>
  </div>
</section>
<!-- Fin Modal New Phone -->


<!-- Modal New Bien-->
<section id="new_bien_modal" class="modal modal-m">
  <div class="modal-header">
    <h1>NUEVO BIEN</h1>
  </div>
  <div class="row padd_v">
    <form id="" class="formweb " action="" method="">
      <fieldset class="large-6 medium-6 small-12 columns padding">
          <?php 
            $assetTypes = Assettypes::model()->findAll();
          ?>
          <label>Tipo de Bien</label>
          <select id="assetType">            
            <option value="">Seleccione un Bien</option>
            <?php 
              if(count($assetTypes)>0){
                foreach ($assetTypes as $assetType) {
              ?>
              <option value="<?= $assetType->idAssetType; ?>"><?= $assetType->assetTypeName; ?></option> 
            <?php
                }            
              }
            ?>            
          </select>
          <label>Nombre</label>                       
          <input id="assetName" type="text">
          <label>Fecha</label>    
          <div class="fecha">
            <input type="date" class="calendar" id="assetDate">
          </div>                   
      </fieldset>
      <fieldset class="large-6 medium-6 small-12 columns padding">
        <label>Comentarios</label>                       
        <textarea name="" id="assetDescription" cols="30" rows="10" ></textarea>
        <input id="idAsset" name="idAsset" type="hidden" value="" />
      </fieldset>      
        <div class="clear"></div>
    </form>
  </div>
  <div class="modal-footer">    
    <a id="saveAssetModel" href="" class="btnb waves-effect waves-light right">GUARDAR</a>
    <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right">CANCELAR</a>
  </div>
</section>
<!-- Fin Modal New Bien-->


<!-- Modal New Soporte-->
<section id="new_sporte_modal" class="modal modal-m">
  <div class="modal-header">
    <h1>NUEVO SOPORTE</h1>
  </div>
  <?php       
      $support = new Supports;
      $current_user=Yii::app()->user->id;      
      //print_r($support->idWallet);
      $form = $this->beginWidget('GxActiveForm', array(
        'id' => 'frmSupports',
        'enableAjaxValidation' => false,
        'action'=>Yii::app()->createUrl('//supports/create'),    
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'class'=>'formweb well well-sm', 'onsubmit'=>''),
      ));
    ?>
  <div class="row padd_v">    
    <fieldset class="large-6 medium-6 small-12 columns padding">
      <?php echo $form->labelEx($support,'fileName'); ?>
      <?php echo $form->textField($support, 'fileName', array('class'=>'form-control input-block-level')); ?>
      <?php echo $form->error($support,'fileName'); ?>
    </fieldset>
    <fieldset class="large-6 medium-6 small-12 columns padding">
      <?php echo $form->labelEx($support,'dFile'); ?>
      <div class="fecha">
      <?php echo $form->dateField($support, 'dFile', array('class'=>'calendar picker__input')); ?>
      </div>
      <?php echo $form->error($support,'dFile'); ?>
    </fieldset>
    <fieldset class="large-12 medium-12 small-12 columns padding">
      <div class="file-field input-field">
        <div class="btn">
          <span>Cargar archivo</span>
          <?php echo $form->labelEx($support,'fileP'); ?>
          <?php echo $form->fileField($support, 'fileP', array('class'=>'')); ?>
          <?php echo $form->error($support,'fileP'); ?>
        </div>
        <div class="file-path-wrapper">
          <input class="file-path validate" type="text">
          <?php echo $form->hiddenField($support, 'idWallet', array('value'=>Yii::app()->session['userView'.$current_user.'idWallet'])); ?>
        </div>
      </div>
      <input id="idSupport" name="idSupport" type="hidden" value="">      
      <input id="idOldFname" name="idOldFname" type="hidden" value="">
      <input id="idOldFtype" name="idOldFtype" type="hidden" value="">
    </fieldset>
  </div>
  <div class="modal-footer">    
    <button id="saveSupport" type="submit" href="" class="btnb waves-effect waves-light right">GUARDAR</button>
    <a href="#!" class="btnb pop modal-action mod4al-close waves-effect waves-light right" id="cancelBtnSupport">CANCELAR</a>
  </div>
  <?php
    $this->endWidget();
  ?>
    <!-- <form id="frmSupport" class="formweb " action="" method="">
      <fieldset class="large-6 medium-6 small-12 columns padding">
          <label>Nombre de archivo</label>                       
          <input type="text">          
      </fieldset>
      <fieldset class="large-6 medium-6 small-12 columns padding">
        <label>Fecha</label>    
        <div class="fecha">
          <input type="date" class="calendar">
        </div>                   
      </fieldset>
      <fieldset class="large-12 medium-12 small-12 columns padding">
        <div class="file-field input-field">
          <div class="btn">
            <span>Cargar archivo</span>
            <input id="fileSupport" type="file">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text">
          </div>
        </div>
      </fieldset>
        <div class="clear"></div>
    </form> -->  
</section>
<!-- Fin Modal New Soporte-->
<!-- Modal Terms -->
<section id="terms-modal" class="modal modal-m">
  <div class="modal-header">
    <h1><?=str_replace("::url","",str_replace("url::","",Yii::t("database","terminosCondiciones")))?></h1>
  </div>
  <div class="row padd_v">
    <?php 
      $genericText = CojGenerictext::model()->findByPk(10);
    ?>
    <fieldset class="large-6 medium-6 small-12 columns padding"><p><?= $session['idioma']==2?$genericText->text_en : $genericText->text_es ?></p></fieldset>
  </div>
  <div class="modal-footer">    
    <a href="#!" class="btnb pop modal-action modal-close waves-effect waves-light right">CANCELAR</a>
  </div>
</section>
<!-- Fin Modal New Phone -->


<script type="text/javascript">
  $(function(){    

    $("#saveAssetModel").bind('click', function(){
      var idWallet = $("#idWallet").val();
      var idAdviser = $("#idAdviser").val();
      var description = $("#assetDescription").val();
      var assetDate = $("#assetDate").val();
      var idAsset = $("#idAsset").val();
      var assetName = $("#assetName").val();
      var assetType = $("#assetType").val();

      $.ajax({
        url: '<?php echo Yii::app()->getBaseUrl(true); ?>'+'/wallet/saveAsset',
        type: 'POST',
        data:"idWallet="+idWallet+"&idAdviser="+idAdviser+"&description="+description+"&assetDate="+assetDate+"&assetName="+assetName+"&assetType="+assetType+"&idAsset="+idAsset,
        success: function (data) {
           //location.reload(true); 
        },
        error: function(data){
          console.info(data);
        }
      });
    });

    $("#modalPhoneDepartments").change(function(){
      $.ajax({
          url: '<?php echo Yii::app()->getBaseUrl(true); ?>'+'/wallet/getCities/'+$(this).val(),
          type: 'get',
          data: {},
          success: function (data) {
             $("#modalPhoneCities").html('');
             $("#modalPhoneCities").html(data); 
          }
        });
    });

    $("#saveDemographicPhoneModel").bind('click', function(){
      var idWallet      = $("#idWallet").val();
      var idAdviser     = $("#idAdviser").val();
      var phoneType     = $("#phoneType").val();
      var phoneNumber   = $("#phoneNumber").val();
      var idCity        = $("#modalPhoneCities").val();
      var idDemographic = $("#idDemographic").val();
      
      $.ajax({
        url: '<?php echo Yii::app()->getBaseUrl(true); ?>'+'/wallet/saveDemographicPhone',
        type: 'POST',
        data:"idWallet="+idWallet+"&idAdviser="+idAdviser+"&phoneType="+phoneType+"&phoneNumber="+phoneNumber+"&idCity="+idCity+"&idDemographic="+idDemographic,
        success: function (data) {
           //location.reload(true); 
        },
        error: function(data){
          console.info(data);
        }
      });
    });

    $("#modalReferenceDepartments").change(function(){
      $.ajax({
        url: '<?php echo Yii::app()->getBaseUrl(true); ?>'+'/wallet/getCities/'+$(this).val(),
        type: 'get',
        data: {},
        success: function (data) {
           $("#modalReferenceCities").html('');
           $("#modalReferenceCities").html(data); 
        }
      });
    });

    $("#saveDemographicReference").bind('click', function(){
      var idWallet = $("#idWallet").val();
      var idAdviser = $("#idAdviser").val();
      var referenceValue = $("#modalReferenceName").val();
      var referenceRelationship = $("#modalReferenceRelationship").val();
      var idCity = $("#modalReferenceCities").val();
      var referenceComment = $("#modalReferenceComments").val();
      var idDemographic = $("#idDemographicReference").val();

      $.ajax({
        url: '<?php echo Yii::app()->getBaseUrl(true); ?>'+'/wallet/saveDemographicReference',
        type: 'POST',
        data:"idWallet="+idWallet+"&idAdviser="+idAdviser+"&referenceValue="+referenceValue+"&referenceRelationship="+referenceRelationship+"&idCity="+idCity+"&referenceComment="+referenceComment+"&idDemographic="+idDemographic,
        success: function (data) {
           //location.reload(true); 
        },
        error: function(data){
          console.info(data);
        }
      });
    });

    $("#saveDemographicEmail").bind('click',function(){
      var idWallet = $("#idWallet").val();
      var idAdviser = $("#idAdviser").val();
      var emailName = $("#modalEmailName").val();
      var emailEmail = $("#modalEmailEmail").val();
      var idDemographic = $("#idDemographicEmail").val();

      $.ajax({
        url: '<?php echo Yii::app()->getBaseUrl(true); ?>'+'/wallet/saveDemographicEmail',
        type: 'POST',
        data:"idWallet="+idWallet+"&idAdviser="+idAdviser+"&emailName="+emailName+"&emailEmail="+emailEmail+"&idDemographic="+idDemographic,
        success: function (data) {
           //location.reload(true); 
        },
        error: function(data){
          console.info(data);
        }
      });
    });

    $("#modalAddressDepartments").change(function(){
      $.ajax({
        url: '<?php echo Yii::app()->getBaseUrl(true); ?>'+'/wallet/getCities/'+$(this).val(),
        type: 'get',
        data: {},
        success: function (data) {
           $("#modalAddressCities").html('');
           $("#modalAddressCities").html(data); 
        }
      });
    });

    $("#saveDemographicAddress").bind('click', function(){
      var idWallet = $("#idWallet").val();
      var idAdviser = $("#idAdviser").val();
      var addressType = $("#modalAddressType").val();
      var addressAddress = $("#modalAddressAddress").val();
      var idCity = $("#modalAddressCities").val();
      var idDemographic = $("#idDemographicAddress").val();

      $.ajax({
        url: '<?php echo Yii::app()->getBaseUrl(true); ?>'+'/wallet/saveDemographicAddress',
        type: 'POST',
        data:"idWallet="+idWallet+"&idAdviser="+idAdviser+"&addressType="+addressType+"&addressAddress="+addressAddress+"&idCity="+idCity+"&idDemographic="+idDemographic,
        success: function (data) {
           //location.reload(true); 
        },
        error: function(data){
          console.info(data);
        }
      });
    });
  });
  
  $("#savePasswd").bind('click', function(){
    if($("#newPass").val() == $("#repeatPass").val()){
      $.ajax({
          url: '<?php echo Yii::app()->getBaseUrl(true); ?>'+'/secure/updatePassword',
          type: 'POST',
          data: {
            "lastPass" : $("#lastPass").val(),
            "newPass" : $("#newPass").val(),
            "repeatPass" : $("#repeatPass").val(),
            "YII_CSRF_TOKEN" : $("#YII_CSRF_TOKEN").val(),
          },
          success: function (data) {
              if(data.status=="error"){
                $("#errorModalChangePasswd").html("");
                $("#errorModalChangePasswd").html(data.msg);
              }else {
                location.reload(true);
              }
          },
          error: function(data){
            console.info(data);
          }
      });
    }else{
          $("#errorModalChangePasswd").html("");
          $("#errorModalChangePasswd").html("Los campos Nueva contraseña y Repetir nueva contraseña deben ser iguales");
    }
    
  });
  
  $("#cancelBtnSupport").bind('click', function(){ $("#new_sporte_modal").modal('hide'); });

    
  

</script>