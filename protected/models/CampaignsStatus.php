<?php 

class CampaignsStatus extends GxActiveRecord
{

	// Esta funcion agrega estados a las campañas
	public static function add_estados(){
		$connection = Yii::app()->db;
		$idStatus = $_POST['idStatus'];
		$idCampaing = $_POST['idCampaign'];
		$values = ['idStatus' => $idStatus, 'idCampaign' => $idCampaing];
		return Yii::app()->db->createCommand()->insert('campaigns_status',$values);		
	}

	// Esta funcion agrega estados a las campañas
	public static function del_estados(){
		$idStatus = $_POST['idStatus'];
		$idCampaing = $_POST['idCampaign'];
		$sql = "DELETE FROM campaigns_status WHERE idStatus=:idStatus AND idCampaign=:idCampaign";
		$prms = ['idStatus' => $idStatus, 'idCampaign' => $idCampaing];
		return Yii::app()->db->createCommand($sql)->execute($prms);		
	}
	
	//Esta funcion devuelve los estados para una campaña
	public static function get_status(){
		$idCampaing = $_POST['idCampaing'];
		$sql = sprintf('SELECT id, idCampaign, name AS description FROM campaigns_status', $idCampaing);
		$listado = Yii::app()->db->createCommand($sql)->queryAll($sql);
		return $listado;
	}
	
	
	// Esta funcion actualiza los estados
	public static function update_status(){
		$connection = Yii::app()->db;
		$descripcion = $_POST['descripcion'];
		$idStatus = $_POST['idStatus'];
		return Yii::app()->db->createCommand()->update( 'campaigns_status', array('name'=>$descripcion), 
			'id=:idStatus', array(':idStatus'=>$idStatus)
		);
	}	

}