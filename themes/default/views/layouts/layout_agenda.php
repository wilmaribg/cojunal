<?php
$this->Widget('ext.yii-toast.ToastrWidget');
$base = Yii::app()->request->baseUrl;
$session = Yii::app()->session;
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
        <a href="#">
          <div class="user_log responsive-img" style="background-image: url('<?php echo Yii::app()->baseUrl; ?>/assets/img/user/1.jpg');">
          </div>
          <h1>Juan Martínez</h1>
          <p>juan@empresa.com</p>
        </a>
      </div>
      <ul>
        <li><a href="" class="waves-effect waves-light"><i class="fa fa-home" aria-hidden="true"></i> Perfil </a></li>
        <li><a href="<?php echo Yii::app()->baseUrl;?>/dashboard" class="waves-effect waves-light"><i class="fa fa-users" aria-hidden="true"></i> Deudores</a></li>
        <li><a href="" class="waves-effect waves-light"><i class="fa fa-calendar-o" aria-hidden="true"></i> Reportes</a></li>
        <li><a href="<?php echo Yii::app()->baseUrl;?>/database" class="waves-effect waves-light"><i class="fa fa-file-text-o" aria-hidden="true"></i> <span class="inline">Cargar base de datos</span></a></li>
        <li><a href="<?php echo Yii::app()->baseUrl;?>/logout" class="waves-effect waves-light"><i class="fa fa-lock" aria-hidden="true"></i> Cerrar sesión</a></li>
      </ul>
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
