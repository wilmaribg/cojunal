<?php
echo "<?php\n";
?>
$this->pageTitle = Yii::t('app', 'Administrar') . ' ' . GxHtml::encode($model->label(2)) ;
$this->menu = array(
        array('label'=>'<i class="fa fa-plus"></i> ' . Yii::t('app', 'Crear') . ' ' . $model->label(), 'url'=>array('create')),
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('<?php echo $this->class2id($this->modelClass); ?>-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="row">
    <div class="col-lg-3 col-md-3">
        <?php echo "<?php echo GxHtml::link(Yii::t('app', '<i class=\"fa fa-plus\"></i> Crear') . ' ' . \$model->label(), \$this->createUrl('create'), array('class' => 'btn btn-success btn-block')); ?>\n"; ?>
    </div>
    <div class="col-lg-6 col-md-6">
        
    </div>
    <div class="col-lg-3 col-md-3">
        <?php echo "<?php echo GxHtml::link(Yii::t('app', '<i class=\"fa fa-search\"></i> Búsqueda Avanzada'), '#', array('class' => 'search-button btn btn-info btn-block')); ?>\n"; ?>
    </div>
</div>
<hr/>
<div class="search-form" style="display: none">
<p>
<?php echo "<?php echo Yii::t('app', 'Si lo desea, puede entrar en un operador de comparación'); ?>" ?> (&lt;, &lt;=, &gt;, &gt;=, &lt;&gt; o =) <?php echo "<?php echo Yii::t('app', 'al principio de cada uno de los valores de la búsqueda para especificar la forma en la comparación se debe hacer.'); ?>\n" ?>
</p>
<hr/>
<?php echo "<?php \$this->renderPartial('_search', array(
	'model' => \$model,
)); ?>\n"; ?>
</div><!-- search-form -->

<?php echo '<?php'; ?> $this->widget('booster.widgets.TbGridView', array(
        'id' => '<?php echo $this->class2id($this->modelClass); ?>-grid',
        'type'=>'striped bordered condensed hover',
        'responsiveTable'=>true,
        //descomentar para ordenar contenido, especifique el campo del orden data-field
        //'htmlOptions'=>array('class'=>'grid-view sort-table-update', 'data-field'=> 'orden', 'data-table'=> get_class($model)),
        //'rowCssClassExpression'=>'"items[]_{$data-><?php echo $this->tableSchema->primaryKey; ?>}"',
        //'afterAjaxUpdate' => 'function(id, data){sortTable();reloadGrid(id);}',
        'filter' => $model,
        'dataProvider' => $model->search(),
        'columns' => array(
<?php
$count = 0;
foreach ($this->tableSchema->columns as $column) {
	if (++$count == 7)
		echo "\t\t\t/*\n";
        if (!$column->autoIncrement)
            echo "\t\t\t" . $this->generateGridViewColumn($this->modelClass, $column).",\n";
}
if ($count >= 7)
	echo "\t\t\t*/\n";
?>
		array(
			'class' => 'booster.widgets.TbButtonColumn',
                        'template' => '{update} {delete}'
		),
	),
)); ?>