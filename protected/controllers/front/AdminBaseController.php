<?php

class AdminBaseController extends GxController {

	
	/*public function actionCampana(){
		$session = Yii::app()->session;
		$this->layout = 'layout_dashboad_profile_admin';
		$campanitas = array('1','2','3');
		$this->render('campana');
	}*/

	/**
     * [apiResponse description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    function apiResponse($data) 
    {
    	header('Content-Type: application/json');
    	echo json_encode($data);
    }

	public function actionCampana() {
		$sesion = Yii::app()->session;
        $user = $sesion['cojunal'];
		$data = [];
		$data['coordinadores'] = $this->getAdvisers(6, -1);
		$data['listado'] = Advisers::listCampanas('45');
		$data['deudores_juridicos'] = Advisers::lista_deudores();
		$data['coordinadores_juridicos'] = Advisers::lista_user_juridicos();
		$data['payments'] = Payments::model()->findAllByAttributes(array('idWallet'=>'45'));

		$this->layout = 'layout_dashboad_profile_admin';
		$this->render('campana',$data);
	}

	public function actionSetDeudorToCoordinatorJuridico()
	{
		if((isset($_POST['idWallet']) && $_POST['idWallet'] > 0) 
		&& (isset($_POST['idAdviser']) && $_POST['idAdviser'] > 0)) {
			$this->apiResponse(Advisers::update_wallets((int) $_POST['idWallet'],  (int) $_POST['idAdviser']));	
		}else {
			$this->apiResponse(false);
		}
	}

	public function actionAddState()
	{
		if(isset($_POST['idCampaing']) && $_POST['idCampaing'] != '' 
		&& isset($_POST['description']) && $_POST['description'] != '') {
			$this->apiResponse(Advisers::add_estados());
		}else {
			$this->apiResponse(-1);
		}
	}

	public function actionGetStates()
	{
		if(isset($_POST['idCampaing']) && $_POST['idCampaing'] != '') {
			$this->apiResponse(Advisers::get_status());
		}else {
			$this->apiResponse([]);
		}
	}

	public function actionUpdateDescriptionStatus()
	{
		if(isset($_POST['descripcion']) && $_POST['idStatus'] != '') {
			$this->apiResponse(Advisers::update_status());
		}else {
			$this->apiResponse(-1);
		}
	}

	// Esta funcion devuelve el listado de usuarios con perfil coordinadores
	public function actionGetCoordinadores() {
		$this->apiResponse(Advisers::getCoordinators());
	}

	// Esta funcion devuelve el listado de usuarios con perfil asesores
	public function actionGetAsesores()
	{
		$this->apiResponse(Advisers::getAssesores());
	}
	
	public function actionAsignarprajuridico() 
    {
      $this->apiResponse(AdvisersBase::asigna_campana());
	}
	
	public function actionGetCampanasForRemisiones()
    {
      $model = new AdvisersBase;
      if(isset($_POST['idCliente'])){
        $this->apiResponse([$model::lista_remisiones($_POST['idCliente'])]);
      }else {
        $this->apiResponse(false);
      }
	}
	

	public function actionGetSearchOrdenes()
    {
      $model = new AdvisersBase;
      if(isset($_POST['busqueda'])){
        $this->apiResponse([$model::search_ordenes_servicio($_POST['busqueda'])]);
      }else {
        $this->apiResponse(false);
      }
	}
	

}
