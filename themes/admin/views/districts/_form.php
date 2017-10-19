<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'districts-form',
	'enableAjaxValidation' => true,
        'htmlOptions' => array('class'=>'well well-sm', 'onsubmit'=>'$(".upprogress").show();$(".submit-form").button("loading");'),
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Campos con'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'son requeridos'); ?>.
	</p>

	<?php echo $form->errorSummary($model, '<button type="button" class="close" data-dismiss="alert">&times;</button>', null, array('class'=>'alert alert-danger')); ?>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'name'); ?>
            <?php echo $form->textField($model, 'name', array('class'=>'form-control input-block-level')); ?>
            <?php echo $form->error($model,'name'); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo $form->labelEx($model,'idCity'); ?>
            <?php echo $form->dropDownList($model, 'idCity', GxHtml::listDataEx(Cities::model()->findAllAttributes(null, true))); ?>
            <?php echo $form->error($model,'idCity'); ?>
            </div>
        </div>
        <hr/>
		<label><?php echo GxHtml::encode($model->getRelationLabel('campaigns')); ?></label>
		<?php echo $form->checkBoxList($model, 'campaigns', GxHtml::encodeEx(GxHtml::listDataEx(Campaigns::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('demographics')); ?></label>
		<?php echo $form->checkBoxList($model, 'demographics', GxHtml::encodeEx(GxHtml::listDataEx(Demographics::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('wallets')); ?></label>
		<?php echo $form->checkBoxList($model, 'wallets', GxHtml::encodeEx(GxHtml::listDataEx(Wallets::model()->findAllAttributes(null, true)), false, true)); ?>
        <div class="row buttons text-center">
        <?php
            echo GxHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Guardar') , array('class'=>'btn btn-success btn-lg submit-form', 'data-loading-text'=>Yii::t('app', 'Guardando...')));
        ?>
        </div>
        <?php
            $this->endWidget();
        ?>
</div><!-- form -->