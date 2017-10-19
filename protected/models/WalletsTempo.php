<?php

Yii::import('application.models._base.BaseWalletsTempo');

class WalletsTempo extends BaseWalletsTempo
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	// Guardamos los datos de los deudores
	public static function save_campaign_deudores($deudores)
	{
		$builder = Yii::app()->db->schema->commandBuilder; 
		$command=$builder->createMultipleInsertCommand('wallets_tempo', $deudores);
		return $command->execute();
	}

	// Esta funcion devuelve los deudoires juridicos
	public static function getDeuduresJuridicos() 
	{
		$sql = "SELECT id, idNumber, legalName, capitalValue, email, idCampaign,
				(SELECT campaignName FROM wallets_by_campaign WHERE idWalletByCampaign = a.idCampaign) AS campanaName
				FROM wallets_tempo a 
				WHERE id NOT IN 
				(SELECT idWalletTempo FROM wallets_of_coordinators_juridic)";
		if(isset($_POST['field']) && isset($_POST['orderBy'])) {
			$sql .= sprintf(" ORDER BY %s %s", $_POST['field'], $_POST['orderBy']);
		}	
		return Yii::app()->db->createCommand($sql)->queryAll();
	}

}