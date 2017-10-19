<?php
    $this->Widget('ext.yii-toast.ToastrWidget');
    $base = Yii::app()->request->baseUrl;
    /* @var $this Controller */ 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="es" />
        <link rel="shortcut icon" type="image/ico" href="<?php echo $base; ?>/imaginamos.ico"/>
	<link rel="stylesheet" type="text/css" href="<?php echo $base; ?>/css/print.css" media="print" />
	<link rel="stylesheet" type="text/css" href="<?php echo $base; ?>/css/form.css" />
        <link href="<?php echo $base; ?>/css/cms.css" rel="stylesheet" type="text/css" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <?php require 'javascriptPrototipesUtilities.php' ?>
    </head>
    <body class="login">
        <?php echo $content; ?>
        <div class="clear"></div>
        <div id="versionBar" >
            <div class="copyright" > &copy; Copyright <?php echo date('Y'); ?> | <span class="tip"><a href="http://www.imaginamos.com/" target="_blank">CMS imaginamos</a> </span></div>
        </div>
        <script type="text/javascript">
            var pathurl = '<?php echo $base; ?>/';
            var csrfToken = '<?php echo Yii::app()->request->csrfToken ?>';
        </script>
        <script type="text/javascript" src="<?php echo $base; ?>/js/login.js"></script>
        <div id="overlay"></div><div id="preloader"></div>
    </body>
</html>