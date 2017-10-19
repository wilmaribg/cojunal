<?php 

class CoordinatorjController extends GxController {
	

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
		$data = [];
		$data['clientesAsignados'] = Advisers::listado_campanas_coordinador();
		$this->layout = 'layout_dashboad_profile_coordinatorj';
		$this->render('campaigns', $data);
	}

	public function actionCartera()
	{
		$this->layout = 'layout_dashboad_profile_coordinatorj';
		$this->render('campaigns');
	}

	public function actionAsesores()
	{
		$data['asesores'] = Advisers::lista_asesores();
		$this->layout = 'layout_dashboad_profile_coordinatorj';
		$this->render('advisers', $data);
	}


}

?>