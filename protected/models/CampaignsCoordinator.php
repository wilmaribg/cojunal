<?php


/*===========================================================================================================
	11/Sept/2017 Unisoft - Wilmar Ibarguen M.
===========================================================================================================*/ 

class CampaignsCoordinator extends GxActiveRecord
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	// Esta funcion registra un coordinador para una campaña
	public static function asignarCoordinador($data)
	{
		self::elimiarAsignacionCoordinador($data);
		$sql = "INSERT INTO campaigns_coordinator (id, idCampaign, idCoordinator) VALUES (NULL, :idCampaign, :idCoordinator)";
		$parameters = [
			':idCampaign' => $data['idCampaign'], 
			':idCoordinator' => $data['idCoordinator']
		];
		return Yii::app()->db->createCommand($sql)->execute($parameters);
		
	}

	private function elimiarAsignacionCoordinador($data)
	{
		$sql = "DELETE FROM campaigns_coordinator WHERE idCampaign = :idCampaign";
		$parameters = [':idCampaign' => $data['idCampaign'] ];
		return Yii::app()->db->createCommand($sql)->execute($parameters);
	}

	// Esta funcion devuelve el ultimo id registrado
	public static function getLastID()
	{
		return Yii::app()->db->getLastInsertId();
	}
}