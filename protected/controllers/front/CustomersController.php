<?php 

class CustomersController extends GxController {
	

	public function init() {
        //Yii::app()->getComponent("bootstrap");
        //Yii::app()->theme = $this->themeFront; //set theme default front
		$this->layout = 'layout_secure';
		parent::init();
		Yii::app()->errorHandler->errorAction = 'site/error';
	}

	public function actionIndex(){
		$this->actionCampanas();
	}

	public function actionDashboard()
	{
		$this->actionCampanas();
	}

	public function actionCampanas()
	{
		$this->layout = 'layout_dashboad_profile_customers';
		$this->render('campaigns');
	}

}

?>