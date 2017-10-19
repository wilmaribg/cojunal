<?php
/* @var $this SiteController */
/* @var $error array */
$this->pageTitle=Yii::app()->name . ' - Error';
?>
<section>
    <div class="content-block">
        <div class="content">
            <div class="box">
                <div class="box-header">
                    <h1>Error <?php echo $code; ?></h1>
                </div>
                <div class="box-body">
                    <div class="error">
                    <?php echo CHtml::encode($message); ?>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
</section>