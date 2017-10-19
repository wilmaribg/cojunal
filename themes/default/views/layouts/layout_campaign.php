<?php
$this->Widget('ext.yii-toast.ToastrWidget');
$base = Yii::app()->request->baseUrl;
$session = Yii::app()->session;
$idioma = $session['idioma'];
$campaign = $session['campaign'];
Yii::log("Campaign=>" . print_r($campaign,true), "error", "Login" );
Yii::app()->sourceLanguage = 'xx';
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--<![endif]-->
<!-- html5.js for IE less than 9 -->
<!--[if lt IE 9]>  <script src="assets/js/lib/html5.js"></script>  <![endif]-->
<html>
<head>
  <meta charset="UTF-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta http-equiv="content-language" content="es" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <title>COJUNAL</title>
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="copyright" content="imaginamos.com" />
  <meta name="date" content="2016" />
  <meta name="author" content="diseño web: imaginamos.com" />
  <meta name="robots" content="All" />
  <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.ico" />
  <link rel="author" type="text/plain" href="humans.txt" />
  <!--Style's-->
  <link href="<?php echo Yii::app()->baseUrl; ?>/assets/css/cojunal.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo Yii::app()->baseUrl; ?>/assets/css/alts.css" rel="stylesheet" type="text/css" />

  <script type="text/javascript">
    var idioma = "<?php echo $idioma ?>"
  </script>

  <style type="text/css">
    .iniciales{
          color: #fff;
          position: absolute;
          margin-top: 20%;
          font-size: 27px;
          font-weight: bolder;
          margin-left: 15%;
    }
    .user_log{
        background-color: #f5a623 !important;
    }
  </style>

  <style type="text/css">
    .iniciales2{
          color: #f5a623;
          position: absolute;
          margin-top: 20%;
          font-size: 17px;
          font-weight: bolder;
          margin-left: 15%;
    }

  </style>
  <?php require 'javascriptPrototipesUtilities.php' ?>
</head>

<body>

  <section class="content_all">
    <section class="preload">
      <div class="progress"> <div class="indeterminate"></div></div>
      <div class="loading waves-button waves-effect waves-light">
        <div class="logo_load"><img src="<?php echo Yii::app()->baseUrl; ?>/assets/img/logo.png"></div>
      </div>
    </section>

    <header>
      <div class="row">
        <a href="#" data-activates="nav-mobile" class="nav_movile top-nav hide-on-large-only">    
          <div class="burger"> <ul> <li></li> <li></li> <li></li> </ul></div>
        </a>
        <a href="carter.php" class="logo animated fadeInLeft">
          <img src="<?php echo Yii::app()->baseUrl; ?>/assets/img/logo.png" alt="">
        </a>       
      </div>  
    </header>
    <nav id="nav-mobile" class="side-nav fixed">
      <div class="bg_profile">              
        <a href="<?php echo Yii::app()->baseUrl; ?>/campaign/profile">
          <div class="user_log responsive-img">
            <span class="iniciales"> <?= strtoupper($iniciales); ?> </span>
          </div>
          <h1><?=$campaign->contactName?></h1>
          <p><?=$campaign->contactEmail?></p>
        </a>
      </div>
      <ul>
        <li><a href="<?php echo Yii::app()->baseUrl;?>/dashboard" class="waves-effect waves-light" id="wallets"><i class="fa fa-users" aria-hidden="true"></i> <?=Yii::t("menu","cartera")?></a></li>
        <li><a href="<?php echo Yii::app()->baseUrl;?>/campaign" class="waves-effect waves-light" id="reports"><i class="fa fa-calendar-o" aria-hidden="true"></i> <?=Yii::t("menu","reportes")?></a></li>
        <li><a href="<?php echo Yii::app()->baseUrl;?>/database" class="waves-effect waves-light" id="fileUpload"><i class="fa fa-file-text-o" aria-hidden="true"></i> <span class="inline"><?=Yii::t("menu","cargarData")?></span></a></li>
        <li><a href="<?php echo Yii::app()->baseUrl;?>/logout" class="waves-effect waves-light"><i class="fa fa-lock" aria-hidden="true"></i> <?=Yii::t("menu","cerrarSesion")?></a></li>
      </ul>
      <?php 
            if($session['idioma']==2){
            ?>
                <a href="<?php echo $base; ?>/changeIdioma"><img src="<?php echo $base; ?>/assets/site/img/spain.png"></a>
            <?php 
            }else { 
            ?>
                <a href="<?php echo $base; ?>/changeIdioma"><img src="<?php echo $base; ?>/assets/site/img/usa.png"></a>
          <?php } ?>
    </nav>

    <!--Calendar-->
    <div id="root-picker-outlet"></div>
    <!--Calendar-->
        <!--Contenidos Sitio-->
        <main>
        	<?php
              echo $content;
              
          ?>
          <footer>
            <div class="large-6 medium-6 small-12 columns">
              <p>© 2016 <span>COJUNAL</span> Todos los derechos reservados.</p>

            </div>
            <div class="large-6 medium-6 small-12 columns">
            <div class="footer-autor">
              <a href="http://www.imaginamos.com" target="_blank">Diseño web: <span id="ahorranito2"></span> Imagin<span>a</span>mos.com</a>
            </div>
            </div>
            <div class="clear"></div>  
          </footer>
        </main>
  </section>
<?php 
  require("modal_wallet.php");
?>

		<!--Jquery-->
		<!-- <script src="assets/js/lib/jquery.min.js"></script>    -->
		<!--Plungis-->
		<!-- <script src="assets/js/lib/materialize.js"></script>
		<script src="assets/js/lib/plugins.js"></script>
		<script src="assets/js/app.js"></script> -->
		<script src="<?php echo Yii::app()->baseUrl;?>/assets/js/app.min.js"></script>
		<script src='https://www.google.com/recaptcha/api.js'></script>
   	</main>    
    <!--Fin Contenidos Sitio-->

</section><!--Content_all-->
