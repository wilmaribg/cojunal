<?php

require_once realpath('./') . '/protected/controllers/front/AdminBaseController.php';

class AdminController extends AdminBaseController {

    public function init() 
    {
    }

    /*==================================================================================================
      HISTORIA DE USUARIO (DASHBOARD)
    ==================================================================================================*/

    /**
     * [actionIndex description]
     * @return [type] [description]
     */
    public function actionIndex()
    {
      $this->actionDashboard();
    }
    
    /**
     * [actionLogin description]
     * @return [type] [description]
     */
    public function actionLogin()
    {
        $this->layout = 'main_secure_admin';
        $this->render('login');
    }

    /**
     * [actionDoLogin description]
     * @return [type] [description]
     */
    public function actionDoLogin()
    {
        Yii::import('application.recaptcha.ReCaptcha.*');
        require_once("ReCaptcha.php");
        // Register API keys at https://www.google.com/recaptcha/admin
        if (isset($_POST['g-recaptcha-response'])){ 
            $recaptcha = new ReCaptcha;
            $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
            if ($resp->isSuccess()){
                Yii::log("Entre en resp", "error", "Login" );
                $model = new LoginForm;
                $model->username = $_POST['username'];
                $model->password = $_POST['password'];
                Yii::log("Entre a validar en Assigment", "error", "login");
                if($model->login(true) != false) { 
                    // $session = Yii::app()->session;
                    Yii::app()->session['cojunal'] = $model->login(true);
                    Yii::app()->session['profile'] = 'administrador';
                    $this->redirect(Yii::app()->homeUrl . "admin/dashboard");
                }
            }
        }
    }

    /**
     * [actionLogout description]
     * @return [type] [description]
     */
    public function actionLogout() 
    {
        Yii::app()->homeUrl = Yii::app()->homeUrl . "admin/login";
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    /*==================================================================================================
      HISTORIA DE USUARIO (DASHBOARD)
    ==================================================================================================*/

    public function actionAddCoordinatorToCampaign()
    {
      if((isset($_POST['idCampaign']) && $_POST['idCampaign'] > 0) 
        && (isset($_POST['idCoordinator']) && $_POST['idCoordinator'] > 0)) {
        $resp = Advisers::add_coordi_campana($_POST['idCampaign'], $_POST['idCoordinator']);
        if($resp != 1) $this->apiResponse(false); 
        else $this->apiResponse(true);
      }else {
        $this->apiResponse(-1);
      }
    }

    /*==================================================================================================
      HISTORIA DE USUARIO (DASHBOARD)
    ==================================================================================================*/

    /**
     * [actionDashboard description]
     * @return [type] [description]
     */
    public function actionDashboard()
    {
      $data['dashboardTotals'] = Advisers::get_dashboard_admin();
      $data['coordinators'] = Advisers::getCoordinadores();
      $data['campanasNoAsignadas'] = Advisers::campanas_sin_asignar();
      $data['campanasXclientes'] = [];
      $this->layout = 'layout_dashboad_profile_admin';
      $this->render('dashboard', $data);
    }

    /*==================================================================================================
    	HISTORIA DE USUARIO (PERFIL ADMIN) ADMINISTRACION DE COORDINADORES Y ASESORES
    ==================================================================================================*/

    /**
     * [getCoordinadores description]
     * @param  integer $status [description]
     * @param  integer $active [description]
     * @return [type]          [description]
     */
    public function getAdvisers($status = 0, $active = 0) {
    	$model = new Advisers;
    	if($active == -1) {
    		return $model->findAll('status_idStatus='.$status);
    	}elseif ($active < -1) {
    		return $model->findAll('status_idStatus='.$status.' and active='.$active);
    	}
    }

    /**
     * [actionUsuarios description]
     * @return [type] [description]
     */
    public function actionUsuarios()
    {
    	$data = [ 
    		'coordinadores' => Advisers::getCoordinadoresInfo(),
    		'coordinadores_select' => Advisers::getCoordinators(),
    		'asesores' => Advisers::getAsesoresInfo(),
    	];

      $this->layout = 'layout_dashboad_profile_admin';
      $this->render('usuarios', $data);
    }

    /**
     * Función que permite crear el usuario asesor 
     * @return [type] [description]
     */
    public function actionCreateAsesor() {
      $model = new Advisers;
      $newToken = new Token;
      $now = date("Y-m-d H:m:s");
      $keyPermission = md5($now);
      $newToken->permision_key = $keyPermission;
      $newToken->date = $now;
      $modelAuthAssigment = new AuthAssignment;

      $this->performAjaxValidation($model, 'advisers-form');

      $model->setAttributes($_POST['Advisers']);
      $modelAuthAssigment->userid = $model->idAuthAssignment;
      $model->email = $model->idAuthAssignment;
      unset($model->idAuthAssignment);

      if (isset($_POST['Advisers'])) {
        // Validacion del perfil
        if(isset($_POST['Advisers']['perfil'])) {
          switch ($_POST['Advisers']['perfil']) {
            // cordinador
            case 'C':
              $modelAuthAssigment->bizrule = "Coordinador";
              $modelAuthAssigment->data = "Rol Coordinador";
              $modelAuthAssigment->itemname = 'Coordinador';
              break;
            // cordinador juridico
            case 'CJuridico':
              $modelAuthAssigment->bizrule = "Rol de coordinador jurídico";
              $modelAuthAssigment->data = "Rol de coordinador jurídico";
              $modelAuthAssigment->itemname = 'Coordinador jurídico';
              break;
            // cordinador pre juridico
            case 'CPJuridico':
              $modelAuthAssigment->bizrule = "Rol de coordinador pre jurídico";
              $modelAuthAssigment->data = "Rol de coordinador pre jurídico";
              $modelAuthAssigment->itemname = 'Coordinador pre jurídico';
              break;
            // asesor
            case 'A':
              $modelAuthAssigment->bizrule = "Rol asesor";
              $modelAuthAssigment->data = "Rol asesor";
              $modelAuthAssigment->itemname = 'Asesor';
              break;
            // asesor juridico
            case 'AJuridico':
              $modelAuthAssigment->bizrule = "Rol de asesor jurídico";
              $modelAuthAssigment->data = "Rol de asesor jurídico";
              $modelAuthAssigment->itemname = 'Asesor jurídico';
              break;
            // asesor pre juridico
            case 'APJuridico':
              $modelAuthAssigment->bizrule = "Rol de asesor pre jurídico";
              $modelAuthAssigment->data = "Rol de asesor pre jurídico";
              $modelAuthAssigment->itemname = 'Asesor pre jurídico';
              break;
            // asesor
            default:
              $modelAuthAssigment->bizrule = "Rol asesor";
              $modelAuthAssigment->data = "Rol asesor";
              $modelAuthAssigment->itemname = 'Asesor';
              break;
          }
        }

        $model->dCreation = $now ;
        $model->dUpdate = $now ;
        $model->weeklyGoal = 0;
        $model->active = 1;
        $model->monthlyGoal = 0;
        $hash = substr(md5($now), 0, 8);
        $model->passwd = md5($hash);

        if(count(Advisers::model()->findByAttributes(array('email'=>$model->email))) > 0 
          || count(AuthAssignment::model()->findByAttributes(array('userid'=>$modelAuthAssigment->userid))) > 0) {
            Yii::log("No se pudo crear el usuario. Ya existe el correo o el nombre de usuario en la base de datos" . $keyPermission, "error", "actionCreate");
            Yii::app()->user->setFlash("error", Yii::t('app', "No se pudo crear el usuario. Ya existe el correo o el nombre de usuario en la base de datos"));
        }else{
          if($newToken->save()){
            if($modelAuthAssigment->save()){
              $model->idAuthAssignment = $modelAuthAssigment->idAuthAssignment;
              if ($model->save()) {
                echo('model save <br>');
                $mailSender = $this->sendMailAdvisers($keyPermission, $model->name, $model->email,$modelAuthAssigment->userid,$hash);    
                if (Yii::app()->getRequest()->getIsAjaxRequest()){
                  Yii::app()->end();
                }else{
                  Yii::app()->user->setFlash("success", Yii::t('app', "Registro creado con éxito"));
                  $this->redirect(['usuarios', 'tab' => 'formulario']);
                  // $this->redirect(array('usuarios'));
                }
              }
            }else {
              Yii::app()->user->setFlash("error", Yii::t('app', "El nombre del usuario ya se encuentra registrado"));
              $this->redirect(array('usuarios'));
            }
          }else{
            Yii::log("No se ha podido cargar el key para envio de correo " . $keyPermission, "error", "actionCreate");
            Yii::app()->user->setFlash("error", Yii::t('app', "No se ha podido crear el asesor por favor intente de nuevo"));
            $this->redirect(array('usuarios'));
          }    
        } 
      }else {
        $this->actionUsuarios();    
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
    public function sendMailAdvisers($key,$name, $mail,$user,$password) {
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
                      -<b>Usuario:</b> ' .$user. '<br>
                      -<b>Clave:</b> '.$password.'<br>

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
     * [actionEnableDisableAdvisers description]
     * @return [type] [description]
     */
    public function actionEnableDisableAdvisers()
    {
    	if(isset($_POST['idAdviser']) && isset($_POST['active'])) {
	  		$resp = Advisers::enableDisableAdviser($_POST['active'], $_POST['idAdviser']);
	  		$this->apiResponse(['mensaje'=>$resp]);
        // Yii::app()->user->setFlash('success', "Datos actualizados!");
    	}else {
	  		Yii::app()->user->setFlash('error', "Datos incompletos.");
    		$this->apiResponse(['mensaje'=>'Datos incompletos']);
    	}
    }

    /**
     * [actionSetParentAdviser description]
     * @return [type] [description]
     */
    public function actionSetParentAdviser()
    {
    	if(isset($_POST['idAdviser']) && isset($_POST['parentAdviser'])) {
	  		$resp = Advisers::setParentAdviser($_POST['parentAdviser'], $_POST['idAdviser']);
	  		Yii::app()->user->setFlash('success', "Datos actualizados!");
	  		$this->apiResponse(['mensaje'=>$resp]);
    	}else {
	  		Yii::app()->user->setFlash('error', "Datos incompletos.");
    		$this->apiResponse(['mensaje'=>'Datos incompletos']);
    	}
    }

    /*==================================================================================================
    	HISTORIA DE USUARIO (PERFIL ADMIN) ADMINISTRACION DE CLIENTES
    ==================================================================================================*/
    
    public function actionClientCreate() {
      $model = new Campaigns;
      $newToken = new Token;
      $now = date("Y-m-d H:m:s");
      $keyPermission = md5($now);
      $newToken->permision_key = $keyPermission;
      $newToken->date = $now;
      $modelAuthAssigment = new AuthAssignment;
      $this->performAjaxValidation($model, 'campaigns-form');
      if (isset($_POST['Campaigns'])) {
        $model->setAttributes($_POST['Campaigns']);
        $model->fCreacion = $now;
        $model->dUpdate = $now;
        $hash = substr(md5($now), 0, 8);
        $model->passwd = md5($hash);
        $modelAdviser = Advisers::model()->findByPk($model->idAdviser);
        $modelAuthAssigment->userid = $model->contactEmail;
        $modelAuthAssigment->bizrule = "Rol empresa";
        $modelAuthAssigment->data = "Rol empresa";
        $modelAuthAssigment->itemname = "Empresa";
        if(count(Advisers::model()->findByAttributes(array('email'=>$model->contactEmail)))>0 || count(AuthAssignment::model()->findByAttributes(array('userid'=>$modelAuthAssigment->userid)))>0){
          Yii::log("No se pudo crear el usuario. Ya existe el correo o el nombre de usuario en la base de datos" . $keyPermission, "error", "actionCreate");
          Yii::app()->user->setFlash("error", Yii::t('app', "No se pudo crear el usuario. Ya existe el correo o el nombre de usuario en la base de datos"));
          $this->redirect(array('admin/clientes'));
        }else {
          if($newToken->save()){
            if($modelAuthAssigment->save()){
              if ($model->save()) {
                $mailSender = $this->sendMailCampaigns($keyPermission, $model->contactName . "|" . $model->companyName, $model->contactEmail, $model->contactEmail, $hash);    
                if (Yii::app()->getRequest()->getIsAjaxRequest()){
                  Yii::app()->end();
                }else{
                  Yii::app()->user->setFlash("success", Yii::t('app', "Registro creado con éxito"));
                  $this->redirect(array('admin/clientes'));
                }
              }else{
                Yii::log("No se ha podido Guardar la campaña ", "error", "actionCreate");
                Yii::app()->user->setFlash("error", Yii::t('app', "No se ha podido crear la campaña por favor intente de nuevo"));
                $this->redirect(array('admin/clientes'));
              }
            }
          }else{
            Yii::log("No se ha podido cargar el key para envio de correo " . $keyPermission, "error", "actionCreate");
            Yii::app()->user->setFlash("error", Yii::t('app', "No se ha podido crear la campaña por favor intente de nuevo"));
            $this->redirect(array('admin/clientes'));
          }
        }


      }
      $this->actionclientes();
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
          Yii::import('application.models.CojEmailPlaceholder');
          $data = CojEmailPlaceholder::getEmailsPlaceholder();
          $htmlDB = $data[0]['regiaterClientNotification'];
          $htmlDB = str_replace('%nit%', $_POST['Campaigns']['idNumber'], $htmlDB);
          $htmlDB = str_replace('%nombre%', $_POST['Campaigns']['name'], $htmlDB);
          $htmlDB = str_replace('%correo%', $_POST['Campaigns']['contactEmail'], $htmlDB);
          $htmlDB = str_replace('%contrasena%', $password, $htmlDB);
          $htmlDB = str_replace('%honorariosXcampana%', $_POST['Campaigns']['fees'], $htmlDB);
          $htmlDB = str_replace('%interesesXcampana%', $_POST['Campaigns']['interest'], $htmlDB);
          $htmlDB = str_replace('%comisiónXcampana%', $_POST['Campaigns']['percentageCommission'], $htmlDB);
          $htmlDB = str_replace('%valorXservicio1%', $_POST['Campaigns']['valueService1'], $htmlDB);
          $htmlDB = str_replace('%valorXservicio2%', $_POST['Campaigns']['valueService2'], $htmlDB);

          $bodyEmail = '<table width="100%" border="0" align="center">
            <tr>
              <td height="100%">
                  <table width="100%" border="0" align="center">
                      <tr>
                          <td>
                            '.$htmlDB.'
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
     * [actionclientes description]
     * @return [type] [description]
     */
    public function actionclientes()
    {
      $data = [];
      $currentPage = (isset($_GET['page']) ? $_GET['page'] : 1);

      $model = new Campaigns;
      $data['clientesList'] = $model::getClientsConfig(($currentPage - 1));
      $data['clientesNames'] = $model::getClientsNames();
      $data['totalRecords'] = $model::getClientsCount();
      $data['totalRecords'] = $data['totalRecords'][0]['total'];

      $this->layout = 'layout_dashboad_profile_admin';
      $this->render('clientes' ,$data);
    }

    /**
     * [actionGetClientsCampaigns description]
     * @return [type] [description]
     */
    public function actionGetCampaignByClient() 
    {
      $data = [];
      $model = new Campaigns;
      if(isset($_POST['idCampaign']) && $_POST['idCampaign'] > 0){
        $this->apiResponse([$model::getCampaignByClient($_POST['idCampaign'])]);
      }else {
        $this->apiResponse(false);
      }
    }

    /*==================================================================================================
      HISTORIA DE USUARIO (PERFIL ADMIN) CONFIGURACION DE CORREOS ELECTRONICOS
    ==================================================================================================*/
    
    /**
     * [actionConfiguracionmails description]
     * @return [type] [description]
     */
    public function actionConfiguracionmails()
    {
      Yii::import('application.models.CojEmailPlaceholder');
      $data = [];
      $data['emailsConfig'] = CojEmailPlaceholder::getEmailsPlaceholder();
      $this->layout = 'layout_dashboad_profile_admin';
      $this->render('emailsConfig', $data);
    }

    public function actionUpdateRegiaterClientNotification()
    {
      $resp = -1;
      if(isset($_POST['text']) && $_POST['text'] != '') {
        Yii::import('application.models.CojEmailPlaceholder');
        $resp = CojEmailPlaceholder::updateRegiaterClientNotification($_POST['text']);
      }
      $this->apiResponse($resp);
    }

    public function actionUpdateTermsConditions()
    {
      $resp = -1;
      if(isset($_POST['text']) && $_POST['text'] != '') {
        Yii::import('application.models.CojEmailPlaceholder');
        $resp = CojEmailPlaceholder::updateTermsConditions($_POST['text']);
      }
      $this->apiResponse($resp);
    }

     /*================================================================================================
        11 Junio 2017 Wilmar Ibarguen - Unisoft
    ================================================================================================*/

    // Esta funcion devuelve todos los cordinadores juridicos
    public function actionGetCoordinadoresJuridicos() 
    {
      $this->apiResponse(Advisers::getCoordinadoresJuridicos());
    }


    public function actiongetclientes() 
    {
      $this->apiResponse(AdvisersBase::lista_clientes_editar());
    }


}
