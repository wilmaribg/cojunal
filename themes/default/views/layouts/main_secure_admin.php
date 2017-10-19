<?php
$this->Widget('ext.yii-toast.ToastrWidget');
$base = Yii::app()->request->baseUrl;
$session = Yii::app()->session;
$session->destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if lt IE 7 ]><html class="ie ie6 no-js" lang="en"><![endif]-->
<!--[if IE 7 ]><html class="ie ie7 no-js" lang="en"><![endif]-->
<!--[if IE 8 ]><html class="ie ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9 ]><html class="ie ie9 no-js" lang="en"><![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" lang="es">
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
  <link href="<?php echo Yii::app()->baseUrl;?>/assets/css/conjunal.css" rel="stylesheet" type="text/css" />
</head>

<body class="bg_login">

<section class="preload">
  <div class="progress"> <div class="indeterminate"></div></div>
  <div class="loading waves-button waves-effect waves-light">
    <div class="logo_load"><img src="<?php echo Yii::app()->baseUrl;?>/assets/img/logo.png"></div>
  </div>
</section>

<section class="content_all">
  
  <!--Contenidos Sitio-->
  <section class="cont_home">  
    <div class="logo_login wow flipInDown" data-wow-delay="0.2s">
      <img src="<?php echo Yii::app()->baseUrl;?>/assets/img/logo.png" alt="">
    </div>
    <section class="cont_login">
      <form id="" class="form_login wow zoomIn" action="<?php echo Yii::app()->baseUrl;?>/admin/dologin" method="POST">
      <?php 
        if (!strrpos(Yii::app()->request->requestUri,"errorLogin")===false){ ?>
          <div class="rc-anchor-content"><div class="rc-inline-block"><div class="rc-anchor-center-container"><div class="rc-anchor-center-item rc-anchor-error-message" style="color:red; font-weight: bolder;">Error al iniciar sesión:<br>Usuario o contraseña invalido.</div></div></div></div>
      <?php   
        }
      ?>  
      
        <h2>Inicio de Sesión</h2>
        <p>a su cuenta en Cojunal</p>
        <fieldset class="input-field">
          <input type="hidden" name="YII_CSRF_TOKEN" value="<?php echo Yii::app()->request->csrfToken ?>" />
          <input type="hidden" name="redirect_admin" value="sjdolikhowi" />
          <input type="text" name="username" class="validate">
          <label for="icon_prefix">Usuario</label>
        </fieldset>        
        <fieldset class="input-field">
          <input type="password" name="password" class="validate">
          <label for="icon_prefix">Contraseña</label>
        </fieldset>
        <section class="p_t_20 p_b_10">
          <div class="large-6 medium-6 small-6 columns">
            <input type="checkbox" class="filled-in" id="recordarme" name="recordar" checked="checked" />
            <label for="recordarme">Recordarme</label>
          </div>  
          <div class="large-6 medium-6 small-6 columns"><a class="link2 link_recup_pass modal_clic" href="#modal1">Olvidé mi contraseña</a></div>  
          <div class="clear"></div>
        </section>        
        <div class="g-recaptcha" data-sitekey="<?php echo PUBLIC_KEY_GOOGLE ?>"></div>
         <div class="clear"></div>
        <button type="submit" class="btnb waves-effect waves-light" name="btnLogin">INICIAR SESIÓN</button>        
      </form>             
    </section>

      <div class="clear"></div>
  </section>
  <!--Fin Contenidos Sitio-->

    <div class="clear"></div>

  <section class="fotterlogin wow fadeInDown">
   <div class="large-6 medium-6 small-12 columns">
     <p>© 2016 <span>COJUNAL</span> All rights reserved - No partial or complete reproduction</p>
   </div>
   <div class="large-6 medium-6 small-12 columns">
      <div class="footer-autor">
        <a href="http://www.imaginamos.com" target="_blank">Web design: <span id="ahorranito2"></span> Imagin<span>a</span>mos.com</a>
      </div>
    </div>
    <div class="clear"></div>  
  </section>


    <footer>
         <div class="large-6 medium-6 small-12 columns">
           <p>© 2016 <span>COJUNAL</span> Todos los derechos reservados.</p>

         </div>
         <div class="large-6 medium-6 small-12 columns">
           <!-- <div class="footer-autor">
              <a href="http://www.imaginamos.com" target="_blank">Diseño web: <span id="ahorranito2"></span> Imagin<span>a</span>mos.com</a>
            </div>-->
          </div>
          <div class="clear"></div>  
    </footer>

    <!--Jquery-->
    <!-- <script src="assets/js/lib/jquery.min.js"></script>    -->
    <!--Plungis-->
    <!-- <script src="assets/js/lib/materialize.js"></script>
    <script src="assets/js/lib/plugins.js"></script>
    <script src="assets/js/app.js"></script> -->
    <script src="<?php echo Yii::app()->baseUrl;?>/assets/js/app.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>

</section><!--Content_all-->

  
<!-- Modal Contraseña -->
<section id="modal1" class="modal modal-s">
  <div class="modal-content">
    <div class="form_recuperar wow zoomIn">   
      <p class="txt_center">Para recuperar su contraseña por favor ingresa el correo con el que fuiste registrado y te enviaremos una nueva contraseña.</p>
      <fieldset class="input-field">
        <input type="text" name="email" class="validate" id ="email">
        <label for="icon_prefix">Ingrese su email</label>
      </fieldset>         
      <section class="txt_center">
        <button type="submit" class="btnb waves-effect waves-light" id="recoverPasswd" name="btnLogin">Restaurar contraseña</button>
        <a href="#!" class="link2 link_ingreso modal-action modal-close"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Regresar al inicio de sesión</a>
      </section>
    </div>
  </div>
</section>
<!-- Fin Modal Contraseña -->
<script type="text/javascript">
  $(function(){
    $("#recoverPasswd").bind('click', function(){
      var email = $("#email").val();
      $.ajax({
        url: '<?php echo Yii::app()->getBaseUrl(true); ?>'+'/secure/recoverPassword',
        type: 'POST',
        data:"email="+email,
        success: function (data) {
           location.reload(true); 
        },
        error: function(data){
          console.info(data);
        }
      });

    });
  });

</script>


</body>
</html>
