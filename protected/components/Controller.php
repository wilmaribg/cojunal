<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();
    
    public $themeFront = "front";
    
    /**
     * @param array $emails
     * @param string $subject
     * @param string $mensaje
     * @param string $nombrecorreo
     * @param array $emailsCC
     * @param array $attachment
     * @return boolean
     */
    public function sendMail($emails, $subject, $mensaje, $nombrecorreo = "", $emailsCC = array(), $attachment = array(), $template = true) {
        Yii::log("Entre a sendmail", "error");
        $this->newSendGirdMail($emails,$subject,$mensaje);
    }

    public function getFilterMenu(){
        if (Yii::app()->user->getState('rol') > 1){
            return " AND idcmsmenu IN (SELECT m.idcmsmenu FROM cms_menu m JOIN cms_permission_rol r ON SUBSTRING_INDEX(m.url, '/', 1) = r.controller AND SUBSTRING_INDEX(SUBSTRING_INDEX(m.url, '/', 2), '/', -1) = r.action)";
        }else{
            return "";
        }
    }
    
    public function routeRemoveSub($url, $isRoute = true, $urlDefault = "site/index"){
        $base = Yii::app()->request->baseUrl;
        $url = str_replace(($isRoute ? $base : $base .'/'), '', $url);
        if($url == ""){
            return $urlDefault; 
        }else{
           return $url; 
        }
    }
    /**
     * 
     * @param array $actionsDeny
     * @param string $actionValidate
     * @return boolean
     */    
    public static function validateAccess($actionsDeny = array(), $actionValidate = "", $redirect = false) {
        $controllerId = Yii::app()->controller->id;
        $actionId = Yii::app()->controller->action->id;
        if (Yii::app()->user->isGuest) {
            if($redirect){
                Yii::app()->controller->redirect(Yii::app()->user->loginUrl);
                return false;
            }else{
                return false;
            }
        }else
        //deny actions
        if ($actionValidate == "" && $actionsDeny != array() && in_array($actionId, $actionsDeny)) {
            return false;
        }else
        //super usuario
        if (Yii::app()->user->getState('rol') == 1) {
            return true;
        }
        //valida la acción si es pemitida o no estatica, falta validar con base de datos
        elseif ($actionValidate != "" && in_array($actionValidate, $actionsDeny)) {
            return false;
        }
        //database
        elseif (CmsPermissionRol::model()->count('cms_rol_id=:rol AND controller=:controller AND action=:action', array(':rol' => Yii::app()->user->getState('rol'), ':action' => $actionId, ':controller' => $controllerId)) > 0) {
            return true;
        } else {
            //******Acciones y Controladores estaticas para los administradores y editor*******
            //controladores no permitidos para el usuario administrador(2)
            $denyAdmin = array('cmsMenu', 'cmsUsuario', 'cmsConfiguracion', 'cmsRol');
            //controladores y acciones permitidas para el rol 3
            $allowRol = 3;
            //controladores
            $allowController = array('test');
            //acciones permitidas para todos los controladores con rol 3
            $allowActions = array('view', 'create', 'update', 'delete', 'admin');
            if (Yii::app()->user->getState('rol') == 2 && in_array($controllerId, $denyAdmin)) {
                return false;
            } elseif (Yii::app()->user->getState('rol') == 2) {
                return true;
            }else
            //si es el usuario administrador(2) y tiene denegada estas operaciones
            if (Yii::app()->user->getState('rol') == $allowRol && in_array($controllerId, $allowController) && in_array($actionId, $allowActions)) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * 
     * @return boolean
     * @throws CHttpException
     */
    protected function validateCsrfTokenPost() {
        if (!isset($_POST['YII_CSRF_TOKEN'])) {
            throw new CHttpException(400, Yii::t('err', 'Token no válido.'));
        } elseif ($_POST['YII_CSRF_TOKEN'] != Yii::app()->request->csrfToken) {
            throw new CHttpException(400, Yii::t('err', 'Su solicitud no es válida.'));
        } else {
            return true;
        }
    }

    /**
     * 
     * @return string
     */
    public function creaPassword($caracteres = 7) {
        $chars = "abcdefghijkmnopqrstuvwxyz023456789@#$?";
        srand((double) microtime() * 1000000);
        $i = 0;
        $pass = '';
        while ($i <= $caracteres) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }
        return $pass;
    }

    /**
     * 
     * @return type
     */
    public function getLocationInfoByIp() {
        $client = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote = @$_SERVER['REMOTE_ADDR'];
        $result = "";
        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }
        $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if ($ip_data && $ip_data->geoplugin_countryName != null) {
            $result = $ip_data->geoplugin_countryCode;
            //$result['city'] = $ip_data->geoplugin_city;
        }
        return $result;
    }

    /**
     * 
     * @param type $id
     * @return string
     */
    public function submenus($id) {
        $menus = "";
        $modelmenu = CmsMenu::model()->findAll(array('order' => 'orden', 'condition' => "visible = 1 and cms_menu_id=$id".$this->getFilterMenu()));
        foreach ($modelmenu as $value):
            $submenu2 = CmsMenu::model()->find('visible = 1 and cms_menu_id=' . $value->idcmsmenu.$this->getFilterMenu());
            if ($submenu2 == null):
                $menus .= '<li><a menu="' . substr($value->url, 0, strlen($value->url) - strlen(strstr($value->url, "/"))) . '" href="' . $this->createUrl($value->url) . '"> <i class="' . $value->icono . '"></i> ' . $value->titulo . '</a></li>
                              <li class="nav-divider"></li>';
            else:
                $menus .= '<li class="dropdown-submenu">
                                <a menu="' . substr($value->url, 0, strlen($value->url) - strlen(strstr($value->url, "/"))) . '" href="' . $this->createUrl($value->url) . '"> <i class="' . $value->icono . '"></i> ' . $value->titulo . '</a>
                                <ul class="dropdown-menu"> 
                                ' . $this->submenus($value->idcmsmenu) . '
                                </ul>
                              </li><li class="nav-divider"></li>';
            endif;
        endforeach;
        return $menus;
    }

    public function calculaFecha($minutos) {
        $message = "";
        switch ($minutos) {
            case ($minutos == 1):
                $message = Yii::t('front', '1 Minuto');
                break;
            case ($minutos < 60):
                $message = $minutos . " " . Yii::t('front', 'Minutos');
                break;
            case ($minutos <= 120):
                $message = "1 " . Yii::t('front', 'Hora');
                break;
            case ($minutos > 120 && $minutos <= 1440 ):
                $message = round($minutos / 60) . " " . Yii::t('front', 'Horas');
                break;
            case ($minutos > 1440 && $minutos <= 2880 ):
                $message = '1 ' . Yii::t('front', 'Día');
                break;
            case ($minutos > 2880 && $minutos <= 43200 ):
                $message = round(($minutos / 60) / 24) . " " . Yii::t('front', 'Días');
                break;
            case ($minutos > 43200 && $minutos <= 86400 ):
                $message = "1 " . Yii::t('front', 'Mes');
            case ($minutos > 43200 && $minutos <= 518400 ):
                $message = round((($minutos / 60) / 24) / 30) . " " . Yii::t('front', 'Meses');
                break;
            case ($minutos > 518400 && $minutos <= 1036800 ):
                $message = '1 ' . Yii::t('front', 'Año');
                break;
            case ($minutos > 1036800 ):
                $message = round(((($minutos / 60) / 24) / 30) / 12) . " " . Yii::t('front', 'Años');
                break;
        }
        return Yii::t('front', 'Hace ') . $message . Yii::t('code', '[_AGO_]');
    }

    public function siteEncodeURL($variable) {
        return base64_encode(str_rot13($variable));
    }

    public function siteDecodeURL($variable) {
        return str_rot13(base64_decode($variable));
    }

    public function setLanguageApp() {
        $session = Yii::app()->session;
        if ((!isset($session['idioma']) && $session['idioma'] == "") || (isset($session['idioma']) && !is_numeric($session['idioma'])) || !isset($session['idioma']) || $session['idioma'] == "") {
            $session['idioma'] = 1;
        }
        if ($session['idioma'] == "1") {
            Yii::app()->language = "es";
        } else {
            Yii::app()->language = "en";
        }
    }

    public function slugUrl($string, $separator = "-") {
        $string = trim($string);
        $string =  mb_strtolower($string, 'UTF-8');
        $string = str_replace("ñ", "n", $string);
        $search = explode(",", "ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u");
        $replace = explode(",", "c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u");
        $string = str_replace($search, $replace, $string);
        $string = preg_replace("/[^a-zA-Z0-9 -]/", "", $string);
        $string = preg_replace('!\s+!', ' ', $string);
        $string = str_replace(" ", $separator, $string);
        return $string;
    }

    public function getFileProtected($file, $downloadfile = false) {
        ob_clean();
        $file = $this->routeRemoveSub(Yii::getPathOfAlias('webroot')) . $file;
        //$file = Yii::getPathOfAlias('webroot') . $file;
        if (!file_exists($file)) {
            return "";
        }
        header("Pragma: public"); // required
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false); // required for certain browsers 
        header("Content-Type: " . mime_content_type($file));
        if ($downloadfile) {
            header("Content-Disposition: attachment; filename=\"" . urldecode(substr(strrchr($file, '/'), 1)) . "\";");
        }
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . filesize($file));
        readfile($file);
        Yii::app()->end();
    }

    public function parseProtectedImageUrl($urlFile, $controller = "") {
        if ($controller == "") {
            $controller = Yii::app()->controller->id;
        }
        $urlFile = trim(CHtml::encode($urlFile));
        if ($urlFile == "") {
            return Yii::app()->request->baseUrl . "/img/no_image.gif";
        }
        if (strpos($urlFile, 'http://') !== false || strpos($urlFile, 'https://') !== false) {
            return $urlFile;
        } else {
            return $this->createUrl("$controller/getImage", array('id' => $this->siteEncodeURL($urlFile)));
        }
    }

    public function parseProtectedFileUrl($urlFile, $controller = "") {
        if ($controller == "") {
            $controller = Yii::app()->controller->id;
        }
        $urlFile = trim(CHtml::encode($urlFile));
        if ($urlFile == "") {
            return "";
        }
        if (strpos($urlFile, 'http://') !== false || strpos($urlFile, 'https://') !== false) {
            return $urlFile;
        } else {
            return $this->createUrl("$controller/getFile", array('id' => $this->siteEncodeURL($urlFile)));
        }
    }
    
    public function sendMailSendGrid($emails, $subject, $mensaje, $nombrecorreo = "", $emailsCC = array(), $attachment = array()) {
        // Enviamos el mensaje
        $this->newSendGirdMail($emails,$subject,$mensaje);    
        
    }

    public function sendMailMandrill($emails, $subject, $mensaje, $nombrecorreo = "", $emailsCC = array(), $attachment = array()) {
        // Enviamos el mensaje
        $this->newSendGirdMail($emails,$subject,$mensaje);  
    }
        
    public function validateUserFront($user, $pass, $remember = false, $social = "correo") {
        $model = new LoginForm;
        $model->username = $user;
        $model->password = $pass;
        $model->site = true;
        $model->social = $social;
        $model->rememberMe = $remember;
        $resp = "";
        // validate user input and redirect to the previous page if valid
        if ($model->validate() && $model->login()) {
            $resp = "ok";
        } else {
            foreach ($model->getErrors() as $error) {
                $resp .= $error[0] . "<br/>";
            }
        }
        return $resp;
    }
    
    /**
     * HybridAuth
     * http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
     * (c) 2009-2012, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
     * HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
     * 
     * @return array()
     */
    public function configSocial($url){
        return array(
		"base_url" => $url, 
		"providers" => array ( 
			// openid providers
			"OpenID" => array (
				"enabled" => false
			),

			"AOL"  => array ( 
				"enabled" => false 
			),

			"Yahoo" => array ( 
				"enabled" => false,
				"keys"    => array ( "key" => "", "secret" => "" )
			),

			"Google" => array ( 
				"enabled" => true,
				"keys"    => array ( "id" => "", "secret" => "" )
			),

			"Facebook" => array ( 
				"enabled" => true,
				"keys"    => array ( "id" => "", "secret" => "" ),
                                "scope"   => "email, user_about_me, user_birthday, user_hometown", // optional
                                "display" => "popup"
			),

			"Twitter" => array ( 
				"enabled" => true,
				"keys"    => array ( "key" => "", "secret" => "" ) 
			),

			// windows live
			"Live" => array ( 
				"enabled" => false,
				"keys"    => array ( "id" => "", "secret" => "" ) 
			),

			"MySpace" => array ( 
				"enabled" => false,
				"keys"    => array ( "key" => "", "secret" => "" ) 
			),

			"LinkedIn" => array ( 
				"enabled" => true,
				"keys"    => array ( "key" => "", "secret" => "" ) 
			),

			"Foursquare" => array (
				"enabled" => false,
				"keys"    => array ( "id" => "", "secret" => "" ) 
			),
		),

		// if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
		"debug_mode" => false,

		"debug_file" => ""
	);
    }
    
    public function createUrlFront($url){
        return Yii::app()->request->baseUrl . (substr($url,0,1) == "/" ? "" :"/") . $url;
    }
    
    public function responseJson($data){
        header('Content-type: application/json');
        echo CJSON::encode($data);
    }
    
    public function validAccessAuthRest(){
        $user = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : "";
        $password = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : "";
        $access = CmsConfiguracion::model()->find(array('select'=>'user_restful, password_restful'));
        if($access->user_restful == $user && $access->password_restful == $password){
            return true;
        }else{
            return false;
        }
    }

    public function actionLogout() {
        Yii::app()->homeUrl = Yii::app()->homeUrl . "iniciar-sesion";
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function newSendGirdMail($emails,$subject,$mensaje, $mailFrom="", $emailsCC = array(), $attachment = array()){
        try { 
            $model = CmsConfiguracion::model()->findByPk(1);
            
            if($mailFrom==""){
                $mailFrom = $model->username;
                $fromName = $model->nombre_correo;
                Yii::log($mailFrom,"warning","mailFrom");

            }else {
                $mailFrom = $mailFrom;
                $fromName = "Generic Mail";
                Yii::log($mailFrom,"warning","mailFrom");
            }

            $message = Yii::app()->sendgrid->createEmail();            

            if (is_array($emails)) {
                foreach ($emails as $key => $email) {
                    Yii::log($email,"warning","email");
                    $message->addTo($email);
                }
            }else {
                Yii::log($email,"warning","email");
                $message->addTo($emails);
            }
            
            if ($emailsCC != array() && is_array($emailsCC)) {
                foreach ($emailsCC as $email => $name) {
                    $message->addCc($email);
                }
            }            
            
            if ($attachment != array() && is_array($attachment)) {
                foreach ($attachment as $value) {
                    $message->addAttachment($value);
                }
            }
            
            $message->setHtml(str_replace("__content__", $mensaje, $model->plantilla))
                //->addTo('bar@foo.com') //One of the most notable changes is how `addTo()` behaves. We are now using our Web API parameters instead of the X-SMTPAPI header. What this means is that if you call `addTo()` multiple times for an email, **ONE** email will be sent with each email address visible to everyone.
                //->addTo("manuelramirezr@gmail.com")
                ->setFrom($mailFrom) 
                ->setFromName($fromName)
                ->setSubject($subject);

            Yii::app()->sendgrid->send($message);

            return true;
            
        } catch (Exception $e) {
            Yii::log("Mail Exception : " . print_r($e->getMessage(),true), "error", "newSendGirdMail");
            return false;
        }     

    }

}
