<?php

Yii::import('application.models._base.BaseStatus');

class Status extends BaseStatus
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public static function addStatus($name)
	{
		$sql = sprintf("INSERT INTO status (idStatus, description, dCreation) VALUES (NULL, '%s', '%s')",
			$name, date('Y-m-d')
		);
		return Yii::app()->db->createCommand($sql)->execute();
	}

	public static function update_status($name, $id)
	{
		$sql = "UPDATE status SET description=:description WHERE  idStatus=:idStatus";
		$prms = [':description' => $name, ':idStatus' => $id ];
		return Yii::app()->db->createCommand($sql)->execute($prms);
	}

	public static function get_status($idCampaign)
	{
		$sql = "SELECT *, (SELECT id FROM campaigns_status WHERE idCampaign = :idCampaign AND campaigns_status.idStatus = status.idStatus) AS asignado FROM status";
		return Yii::app()->db->createCommand($sql)->queryAll(true, [':idCampaign' => $idCampaign]);
	}
}