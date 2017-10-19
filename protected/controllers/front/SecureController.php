<?php

class SecureController extends Controller {

    public function init() {
        //Yii::app()->getComponent("bootstrap");
        //Yii::app()->theme = $this->themeFront; //set theme default front
        $session = Yii::app()->session;
        $this->layout = 'main_secure';
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
        if (isset($_POST['idioma'])) {
            if ($_POST['idioma'] == '1' || $_POST['idioma'] == '2') {
                $session = Yii::app()->session;
                $session['idioma'] = $_POST['idioma'];
                echo "ok";
            }
        }else {
           $session['idioma'] = 1;
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
        $this->render('home');
    }

    public function actionErrorLogin(){
        $this->render('home', array('error'=>'true'));
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
    /**
    *
    * Función que permite el envío de correos electrónicos apra los asesores, para el ingreso al sistema
    * @param $key Key generado por la plataforma para no aceptar peticiones fuera de esta
    * @param $name Nombre del usaurio al que se envía el correo
    * @param $mail Correo electrónico al cual se envía el correo
    * @param $user Usuario con el cual se va registra el asesor
    * @param $password Clave con la cual el asesor va a ingresar al sistema 
    */
    public function sendMailAdvisers($key,$name, $mail,$user,$password){
        Yii::log("Se hace el envío de correo", "error", "sendMailAdvisers");
        $token = Token::model()->findByAttributes(array('permision_key'=>$key));
        if(count($token)>0){
            Yii::log("Se prepara el envío de correo", "error", "sendMailAdvisers");
            $token->delete();
            $subject = 'Credenciales para el ingreso';
            $bodyEmail = '<table width="100%" border="0" align="center">
              <tr>
                <td height="100%">
                    <table width="100%" border="0" align="center">
                        <tr>
                            <td>
                              <p>
                                Hola, ' .$name. ', se ha generado un clave para el ingreso al sistema de Cojunal a continuación se muestran los datos.
                              <p>
                              
                              -<b>Link de ingreso:</b> ' .Yii::app()->getBaseUrl(true). '/iniciar-sesion <br>
                              -<b>Usuario:</b> ' .$user. ' <br>
                              -<b>Clave:</b> '.$password.' <br>
                             
                              <br><br>
                              Cordialmente,<br>Staff <a href="http://cojunal.com" target="_blank">cojunal.com</a>
                              <br><br>
                            </td>
                        </tr>
                    </table>
                </td>
              </tr>
            </table>';
            if(Controller::sendMailMandrill(array($mail), $subject, $bodyEmail)){
                Yii::log("Se envió el correo", "error", "sendMailAdvisers");
                return true;
            }else {
                Yii::log("No se envió el correo", "error", "sendMailAdvisers");
                return "mail-error";
            }    
        }else{
            Yii::log("Hubo un error con el Token" . $key , "error", "sendMailAdvisers");
            return false;
        }
        
    }


    /**
    *
    * Función que permite el envío de correos electrónicos apra los asesores, para el ingreso al sistema
    * @param $key Key generado por la plataforma para no aceptar peticiones fuera de esta
    * @param $name Nombre del usaurio al que se envía el correo
    * @param $mail Correo electrónico al cual se envía el correo
    * @param $user Usuario con el cual se va registra el asesor
    * @param $password Clave con la cual el asesor va a ingresar al sistema 
    */
    public function sendMailCampaigns($key,$name, $mail, $user, $password){
        Yii::log("Se hace el envío de correo" . $name, "error", "sendMailCampaigns");
        $companyData = explode("|" , $name);
        
        $token = Token::model()->findByAttributes(array('permision_key'=>$key));
        if(count($token)>0){
            Yii::log("Se prepara el envío de correo", "error", "sendMailCampaigns");
            $token->delete();
            $subject = 'Nueva Campaña creada';
            $bodyEmail = '<table width="100%" border="0" align="center">
              <tr>
                <td height="100%">
                    <table width="100%" border="0" align="center">
                        <tr>
                            <td>
                              <p>
                                Hola, ' .$companyData[0]. ', se ha creado una nueva campaña para la empresa '.$companyData[1].' a la cual usted representa por favor ingrese al sistema para poder dar gestión de la misma.
                              <p>
                              
                              -<b>Link de ingreso:</b> ' .Yii::app()->getBaseUrl(true). '/iniciar-sesion <br>
                              -<b>Usuario:</b> ' .$mail. ' <br>
                              -<b>Clave:</b> '.$password.' <br>
                              
                              <br><br>
                              Cordialmente,<br>Staff <a href="http://cojunal.com" target="_blank">cojunal.com</a>
                              <br><br>
                            </td>
                        </tr>
                    </table>
                </td>
              </tr>
            </table>';
            if(Controller::sendMailMandrill(array($mail), $subject, $bodyEmail)){
                Yii::log("Se envió el correo", "error", "sendMailAdvisers");
                return true;
            }else {
                Yii::log("No se envió el correo", "error", "sendMailAdvisers");
                return "mail-error";
            }    
        }else{
            Yii::log("Hubo un error con el Token" . $key , "error", "sendMailAdvisers");
            return false;
        }
        
    }

    public function actionRecoverPassword(){
        $modelAdviers = Advisers::model()->findByAttributes(array("email"=>$_POST['email']));
        $modelCampaigns = Campaigns::model()->findByAttributes(array("contactEmail"=>$_POST['email']));
        if($modelAdviers && count($modelAdviers)==1){
            $this->updatePassword($modelAdviers->idAdviser, "Advisers");
        }else {
            if($modelCampaigns && count($modelCampaigns)==1){
                $this->updatePassword($modelCampaigns->idCampaign, "Campaigns");
            }else{
                Yii::app()->user->setFlash('error', "Correo no encontrado");
            }
        }

    }


    public function updatePassword($id, $modelType) {
        $newToken = new Token;
        $now = date("Y-m-d H:m:s");
        $keyPermission = md5($now);
        $newToken->permision_key = $keyPermission;
        $newToken->date = $now;
        $model = $modelType::model()->findByPk($id);
        if($newToken->save()){
            $model->dUpdate = $now ;
            $hash = substr(md5($now), 0, 8);
            $model->passwd = md5($hash);
            // $modelAuthAssigment = AuthAssignment::model()->findByPk($model->idAuthAssignment);
            if($model->save()){
                switch ($modelType) {
                    case 'Campaigns':
                        Yii::log("Enviando correo campaigns..." , "error", "updatePassword");
                        $mailSender = $this->sendMailCampaigns($keyPermission, $model->contactName . "|" . $model->companyName, $model->contactEmail, $model->contactEmail, $hash);           
                    break;
                    case 'Advisers':
                        Yii::log("Enviando correo advisers..." , "error", "updatePassword");
                        $authAssignment = AuthAssignment::model()->findByPk($model->idAuthAssignment);
                        $mailSender = $this->sendMailAdvisers($keyPermission, $model->name, $model->email,$authAssignment->userid,$hash);    
                    break;
                }
                if (!Yii::app()->getRequest()->getIsAjaxRequest()){
                    // Yii::app()->user->setFlash("success", Yii::t('app', "Se ha actualizado la contraseña del asesor y se ha enviado el correo respectivo"));
                    Yii::app()->user->setFlash('success', "Se ha enviado un correo con la nueva contraseña");
                }   
                Yii::app()->user->setFlash('success', "Se ha enviado un correo con la nueva contraseña");     
            } else {
                // Yii::app()->user->setFlash("error", Yii::t('app', "No se pudo actualizar la contraseña del asesor"));
                Yii::app()->user->setFlash('error', "No se pudo actualizar la contraseña");
            }
            
        } else {
            Yii::app()->user->setFlash('error', "No se pudo actualizar la contraseña");
        }
        
        
    }

    public function actionUpdatePassword(){
        $session = Yii::app()->session;
        if(isset($session['cojunal'])){
            $message = array();
            if (isset($_POST['lastPass']) && $this->validateCsrfTokenPost()) {
                if($session['profile'] == 'asesor'){
                    $adviser = $session['cojunal'];
                    $advisersPass = Advisers::model()->findByAttributes(array('email'=>$adviser->email, 'passwd'=>md5($_POST['lastPass'])));
                    if(count($advisersPass)>0){
                        $advisersPass->passwd = md5($_POST['newPass']);
                        $message['status'] = "ok";
                        $message['msg'] = "Contraseña Cambiada";
                        if($advisersPass->save()){
                            Yii::app()->user->setFlash('success', "Contraseña Cambiada");
                        }else {
                            Yii::app()->user->setFlash('error', "Ocurrio un error por favor intente de nuevo");
                        }
                        
                    }else {
                        $message['status'] = "error";
                        $message['msg'] = "Contraseña anterior no coincide";
                    }
                }else if($session['profile'] == 'empresa') {
                    $user = $session['cojunal'];
                    $campaigns = Campaigns::model()->findByAttributes(array('contactEmail'=>$user, 'passwd'=>md5($_POST['lastPass'])));
                    if(count($campaigns)==1){
                        $campaigns->passwd = md5($_POST['newPass']);
                        $message['status'] = "ok";
                        $message['msg'] = "Contraseña Cambiada";
                        if($campaigns->save()){
                            Yii::app()->user->setFlash('success', $session['idioma']==1?"Contraseña cambiada":"Changed Password Successfully" );
                        }else {
                            Yii::app()->user->setFlash('error', $session['idioma']==1?"Ocurrio un error por favor intente de nuevo":"Something was wrong. Please try again");
                        }
                    }else {
                        $message['status'] = "error";
                        $message['msg'] = $session['idioma']==1?"Contraseña anterior no coincide":"Last Password was wrong" ;
                    }
                }else{
                    $message['msg'] = "error";
                }
            } else {
                $message['status'] = "error";
                $message['msg'] = "error";
            }
            header('Content-type: application/json');
            echo CJSON::encode($message);
        }else {
            Yii::app()->user->setFlash('error', "No se pudo actualizar la contraseña");
        }   
    }

}
