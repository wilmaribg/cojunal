<?php


class WalletsByCampaign extends GxActiveRecord
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public static function save_data($data)
	{
		$sql = "INSERT INTO wallets_by_campaign (idCampaign, campaignName, serviceType, notificationType, createAt) 
		VALUES (:idCampaign, :campaignName, :serviceType, :notificationType, CURRENT_TIMESTAMP)";
		$parameters = [
			':idCampaign' => $data['idCampaign'], 
			':campaignName' => $data['campaignName'], 
			':serviceType' => $data['serviceType'], 
			':notificationType' => $data ['notificationType']
		];
		return Yii::app()->db->createCommand($sql)->execute($parameters);
	}

	public static function getLastID()
	{
		return Yii::app()->db->getLastInsertId();
	}

	/*===========================================================================================================
    	11/Sept/2017 Unisoft - Wilmar Ibarguen M.
    ===========================================================================================================*/ 

	// Esta funcion devuelve el listado de campañas con:
	// Campaña	Cliente	Fecha Creación	Tipo de servicio	
	// Saldo total asignado	Saldo total recuperado	Honorarios	
	// Intereses	% Comisión	Coordinador Asignado	Asignar estados
	public static function obtenerListadoCampanasParaAdmin()
	{
		$sql = "SELECT a.*, b.name AS nameCliente, a.comisions AS comision, 
			a.interests AS intereses, a.fee AS honorarios,
			(SELECT idCoordinator FROM campaigns_coordinator WHERE idCampaign = a.idWalletByCampaign) AS idCoordinador,
			(SELECT SUM(capitalValue) FROM wallets_tempo WHERE 	idCampaign = a.IdCampaign) AS saldoAsignado,
			(SELECT COUNT(id) FROM campaigns_status WHERE idCampaign =  a.idWalletByCampaign) AS cantEstados
			FROM wallets_by_campaign a 
			INNER JOIN campaigns b ON b.idCampaign = a.IdCampaign";

		if(isset($_POST['field']) && isset($_POST['orderBy'])) {
			$sql .= sprintf(" ORDER BY %s %s", $_POST['field'], $_POST['orderBy']);
		}

		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	// Esta funcion me edita un valor financiero de la campaña
	public static function updateDatoFinaciero($campo, $valor, $idCampaign) 
	{
		$sql = sprintf("UPDATE wallets_by_campaign SET `%s` = '%s' WHERE idWalletByCampaign = '%s'",
			$campo, $valor, $idCampaign);
		return Yii::app()->db->createCommand($sql)->execute();
	}

	// Esta funcion agrega los honorario por defecto del cliente como base para la campaña
	public static function setDatosFinacieros($datos) 
	{
		$sql = "UPDATE wallets_by_campaign 
		SET fee = :fee, interests = :interests, comisions = :comisions 
		WHERE idWalletByCampaign = :idWalletByCampaign";
		
		$parameters = [
			':fee' => $datos['fee'], 
			':interests' => $datos['interests'], 
			':comisions' => $datos['comisions'], 
			':idWalletByCampaign' => $datos['idWalletByCampaign']
		];
		return Yii::app()->db->createCommand($sql)->execute($parameters);
	}
}