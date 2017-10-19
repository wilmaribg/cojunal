<?php

class SiteController extends Controller {

    public function init() {
        //Yii::app()->getComponent("bootstrap");
        //Yii::app()->theme = $this->themeFront; //set theme default front
        $this->layout = 'main';
        $session = Yii::app()->session;
        if(!isset($session['idioma']))
            $session['idioma'] = 1;
        parent::init();
        Yii::app()->errorHandler->errorAction = 'site/error';
    }

    public function filters() {
        $this->setLanguageApp();
        return array(
            array(
                'application.filters.html.ECompressHtmlFilter',
                'gzip' => true,
                'doStripNewlines' => false,
                'actions' => '*'
            ),
        );
    }

    public function actionChangeIdioma() {
        // if (isset($_POST['idioma'])) {
        //     if ($_POST['idioma'] == '1' || $_POST['idioma'] == '2') {
        //         $session = Yii::app()->session;
        //         $session['idioma'] = $_POST['idioma'];
        //         echo "ok";
        //     }
        // }
        $session = Yii::app()->session;
        if(isset($session['idioma'])){
            if($session['idioma']==1){
                $session['idioma']=2;
            }else{
                $session['idioma']=1;
            }
        }else{
            $session['idioma']=1;
        }
        if(isset($session['cojunal'])){
            $base = Yii::app()->request->baseUrl;
            header("Refresh:0, url=".$base."/dashboard");
        }else {
            $modelGenericText=CojGenerictext::model()->findAll();
            $modelHome=CojHome::model()->findAll();
            $modelTestimony=CojTestimony::model()->findAll();
            $this->render('index',array('genericText'=>$modelGenericText,'home'=>$modelHome,'testimony'=>$modelTestimony));
        }
        

    }

    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
        );
    }

    // para cargar la maqueta
    /* public function missingAction($actionID)
      {
      $this->render(strtr($actionID,array('.php'=>'')));
      } */

    public function actionIndex() {
        $modelGenericText=CojGenerictext::model()->findAll();
        $modelHome=CojHome::model()->findAll();
        $modelTestimony=CojTestimony::model()->findAll();
        $this->render('index',array('genericText'=>$modelGenericText,'home'=>$modelHome,'testimony'=>$modelTestimony));
//        $mensaje = "Hola"; $subject = "Hola Test";
//        @Controller::sendMailSendGrid(array('dayron.garzon@imaginamos.com.co'=>'Fredy Alarcón'), $subject, $mensaje); 
        
//                @Controller::sendMail(array('freddy.alarcon@imaginamos.com.co'=>'Fredy Alarcón'), $subject, $mensaje, 'TEMPLATE TEST', array('path/file'));
    }
    public function actionNosotros(){
        $modelGenericText = CojGenerictext::model()->findAll();
        //$modelGenericText = CojGenerictext::model()->findAllByAttributes(array("id"=>1));
        //$modelGenericText = CojGenerictext::model()->findByAttributes(array("id"=>1));
        //$modelGenericText = CojGenerictext::model()->findByPk(1);
        $modelNosotros= CojAboutus::model()->findAll();
        //$modelCompany= CojCompany::model()->findByPk(1);
        $modelCompany= CojCompany::model()->findAll();
        $this->render('nosotros',array('genericText'=>$modelGenericText, 'nosotros'=>$modelNosotros, 'company'=>$modelCompany));
    }
    public function actionContacto(){
        $modelGenericText= CojGenerictext::model()->findAll();
        $modelContact= CojContact::model()->findAll();
        $this->render('contactenos',array('genericText'=>$modelGenericText, 'contact'=>$modelContact));
    }
    public function actionServicios(){
        $modelServicio= CojServices::model()->findAll();
        $modelGenericText = CojGenerictext::model()->findAll();
        $this->render('servicios',array('servicio'=>$modelServicio,'genericText'=>$modelGenericText));

    }

    //ejemplo login *****
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    //login con user and password
    public function actionLogin() {
        $message = array();
        if (isset($_POST['email'], $_POST['contrasena']) && $this->validateCsrfTokenPost()) {
            $message['url'] = $this->createUrl('zonaSegura');
            $message['status'] = $this->validateUserFront($_POST['email'], $_POST['contrasena'], ( isset($_POST['recordar']) && $_POST['recordar'] == "on" ? true : false));
            if ($message['status'] == "ok") {
                $message['msg'] = "Ingreso Correcto";
            } else {
                $message['msg'] = $message['status'];
            }
        } else {
            $message['status'] = "error";
            $message['msg'] = "error";
        }
        header('Content-type: application/json');
        echo CJSON::encode($message);
    }

    //ejemplo connect social
    public function actionConnectSocial() {
        $session = Yii::app()->session;
        Yii::import('ext.hybridauth.Hybrid.Auth', true);
        // include hybridauth lib
        $url = $this->createAbsoluteUrl('site/connectSocial');
        $config = $this->configSocial($url);
        $hybridauth = new Hybrid_Auth($config);
        //posibles errores
        if (isset($_REQUEST['hauth_done']) && (($_REQUEST['hauth_done'] == 'Twitter' && isset($_REQUEST['denied'])) || ($_REQUEST['hauth_done'] == 'LinkedIn' && isset($_REQUEST['oauth_problem'])))
        ) {
            if (isset($session['social'])) {
                unset($session['social']);
            }
            $hybridauth->logoutAllProviders();
            $this->redirect(array('zonaSegura'));
            Yii::app()->end();
        }
        //validar auto sesiones
        if (isset($_REQUEST['hauth_start']) || isset($_REQUEST['hauth_done'])) {
            Yii::import('ext.hybridauth.Hybrid.Endpoint', true);
            Hybrid_Endpoint::process();
        }
        // start login with facebook?
        if (isset($_GET["login"]) && ($_GET["login"] == "Facebook" || $_GET["login"] == "Google" || $_GET["login"] == "Twitter" || $_GET["login"] == "LinkedIn")) {
            try {
                $adapter = $hybridauth->authenticate($_GET["login"]);
                $user_profile = $adapter->getUserProfile();
                if (isset($user_profile)) {
                    if ((isset($user_profile->emailVerified) && $user_profile->emailVerified != "") || ($hybridauth->isConnectedWith('twitter') && isset($_GET["login"]) && $_GET["login"] == "Twitter")) {
                        $session['social'] = get_object_vars($user_profile);
                        $session['typeSocial'] = $_GET["login"];
                    } elseif (isset($session['social'])) {
                        unset($session['social']);
                        $hybridauth->logoutAllProviders();
                    }
                }
            } catch (Exception $e) {
                die("<b>got an error!</b> " . $e->getMessage());
            }
        }
        if (isset($session['social'])) {
            //campo en la base de datos
            $idred = "idfacebook";
            $identifier = $session['social']['identifier'];
            switch ($session['typeSocial']) {
                case "Facebook":
                    $idred = "idfacebook";
                    break;
                case "Google":
                    $idred = "idgoogle";
                    break;
                case "Twitter":
                    $idred = "idtwitter";
                    break;
                case "LinkedIn":
                    $idred = "idlinkedin";
                    break;
            }
            $resp = $this->validateUserFront($identifier, $identifier, false, $idred);
            //si el acceso es correcto
            if ($resp == "ok") {
                Yii::app()->user->setFlash('success', Yii::t('front', 'Bienvenido ' . Yii::app()->user->getState('title')));
                $this->redirect(array('zonaSegura'));
                //si el usuario no existe y debe registrarse
            } elseif (Usuario::model()->count("idfacebook='$identifier'") == 0) {
                $this->redirect(array('index', 't' => 'register'));
            } else {
                Yii::app()->user->setFlash('error', Yii::t('front', $resp));
                $this->redirect(array('index'));
            }
        }
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    public function actionGetPointMap(){
        $model = CojMap::model()->findAll();
        header('Content-type: application/json');
        echo CJSON::encode($model);
    }

    public function actionSendContact(){
        $model = new CojMessage;
        $model->name = $_POST['name'];
        $model->email = $_POST['email'];
        $model->affair = $_POST['subject'];
        $model->mess = $_POST['message'];
        $modelContact = CojContact::model()->findByAttributes(array("id"=>1));
        $bodyEmail = "Se ha enviado un correo desde el formulario de contactos por favor revise en el CMS. los datos de correo son los siguientes".
            "<hr>".
            "<table>".
            "<tr><td><br>Nombre: </br>" . $model->name . "</td></tr>".
            "<tr><td><br>Correo: </br>" . $model->email . "</td></tr>".
            "<tr><td><br>Asunto: </br>" . $model->affair . "</td></tr>".
            "<tr><td><br>Mensaje: </br>" . $model->mess . "</td></tr>".
            "</table>".
            "<hr>";


        if($model->save()){
            //sendMailSendGrid($emails, $subject, $mensaje, $nombrecorreo = "", $emailsCC = array(), $attachment = array())
            if($this->newSendGirdMail(array("manuelramirezr@gmail.com"), "[CONTACTO] Formulario de Contacto - " . $model->affair, $bodyEmail)){
                Yii::app()->user->setFlash('success', Yii::t('front', "Correo enviado"));
                $this->actionIndex();
            }else{
                Yii::app()->user->setFlash('error', Yii::t('front', "Correo no enviado"));
                Yii::log("Correo no enviado", "error", "actionSendContact");
                $this->actionIndex();
            }
        }else{
            Yii::app()->user->setFlash('error', Yii::t('front', "Datos no Guardado"));
            Yii::log(print_r($model->getErrors(),true), "error", "actionSendContact");
            $this->actionIndex();
        }
    }

}
