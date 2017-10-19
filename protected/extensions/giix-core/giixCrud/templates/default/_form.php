<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
$band = false;
?>
<div class="form">

<?php $ajax = ($this->enable_ajax_validation) ? 'true' : 'false'; ?>

<?php echo '<?php '; ?>
$form = $this->beginWidget('GxActiveForm', array(
	'id' => '<?php echo $this->class2id($this->modelClass); ?>-form',
	'enableAjaxValidation' => <?php echo $ajax; ?>,
        'htmlOptions' => array('class'=>'well well-sm', 'onsubmit'=>'$(".upprogress").show();$(".submit-form").button("loading");'),
));
<?php echo '?>'; ?>


	<p class="note">
		<?php echo "<?php echo Yii::t('app', 'Campos con'); ?> <span class=\"required\">*</span> <?php echo Yii::t('app', 'son requeridos'); ?>"; ?>.
	</p>

	<?php echo "<?php echo \$form->errorSummary(\$model, '<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>', null, array('class'=>'alert alert-danger')); ?>\n"; ?>
<?php foreach ($this->tableSchema->columns as $column): ?>
<?php if (!$column->autoIncrement): ?>
<?php if(!$band): ?>
        <div class="row">
<?php endif; ?>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <?php echo "<?php echo " . $this->generateActiveLabel($this->modelClass, $column) . "; ?>\n"; ?>
            <?php echo "<?php " . $this->generateActiveField($this->modelClass, $column) . "; ?>\n"; ?>
            <?php echo "<?php echo \$form->error(\$model,'{$column->name}'); ?>\n"; ?>
            </div>
<?php 
    if($band):
        $band = false;
?>
        </div>
        <hr/>
<?php
    else:
        $band =true;
    endif; 
?>
<?php endif; ?>
<?php endforeach; ?>
<?php if($band): ?>
        </div>
<?php endif; ?>
<?php foreach ($this->getRelations($this->modelClass) as $relation): ?>
<?php if ($relation[1] == GxActiveRecord::HAS_MANY || $relation[1] == GxActiveRecord::MANY_MANY): ?>
		<label><?php echo '<?php'; ?> echo GxHtml::encode($model->getRelationLabel('<?php echo $relation[0]; ?>')); ?></label>
		<?php echo '<?php ' . $this->generateActiveRelationField($this->modelClass, $relation) . "; ?>\n"; ?>
<?php endif; ?>
<?php endforeach; ?>
        <div class="row buttons text-center">
        <?php echo "<?php
            echo GxHtml::submitButton(\$model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Guardar') , array('class'=>'btn btn-success btn-lg submit-form', 'data-loading-text'=>Yii::t('app', 'Guardando...')));
        ?>\n"; ?>
        </div>
        <?php echo "<?php
            \$this->endWidget();
        ?>\n"; ?>
</div><!-- form -->