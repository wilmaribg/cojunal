<?php 
class CampanasController extends Controller {
	
	public function init() {
        //Yii::app()->getComponent("bootstrap");
        //Yii::app()->theme = $this->themeFront; //set theme default front
        $this->layout = 'layout_dashboard_profile_admin';
        parent::init();
        Yii::app()->errorHandler->errorAction = 'site/error';
	}
	
	public function actionIndex() {
		$session = Yii::app()->session;
		$this->actionCampanas();
	}


	public function actionCampanas() {
		$connection = Yii::app()->db;
		$listado = Yii::app()->db->createCommand('SELECT 
													`campaigns`.`name`,
													`campaigns`.`companyName`,
													`campaigns`.`contactName`,
													`campaigns`.`contactEmail`,
													`advisers`.`name` asesores
													FROM
													`advisers_campaigns`
													RIGHT OUTER JOIN `campaigns` ON (`advisers_campaigns`.`idCampaign` = `campaigns`.`idCampaign`)
													LEFT OUTER JOIN `advisers` ON (`advisers_campaigns`.`idAdvisers` = `advisers`.`idAdviser`)')->queryAll();
		
		$this->render('campana',array(
		  'listado'=>$listado
	   ));
	}
   }

?>