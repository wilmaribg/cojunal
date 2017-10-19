<?php

class remisiones extends GxActiveRecord
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	// Guardamos los datos de los deudores
	public static function guardar_remision($prm)
	{	

		$sql = "INSERT INTO remisiones (id, fecha, idWalletByCampaign, intereses, honorarios, comision, monto, recaudo, idPayments, idCliente, hora) VALUES (NULL, :fecha, :idWalletByCampaign, :intereses, :honorarios, :comision, :monto, :recaudo, :idPayments, :idCliente, :hora)";
		
		$colums = [
			':fecha' => date('Y-m-d'),
			':hora' => date('H:i:s'),
			':idWalletByCampaign' => $prm['idWalletByCampaign'],
			':intereses' => $prm['intereses'],
			':honorarios' => $prm['honorarios'],
			':comision' => $prm['comision'],
			':monto' => $prm['monto'],
			':recaudo' => $prm['recaudo'],
			':idPayments' => $prm['idPayments'],
			':idCliente' => $prm['idCliente']
		];

		Yii::app()->db->createCommand($sql)->execute($colums);
		return Yii::app()->db->lastInsertID;
	}

	public static function obtener_remision($id)
	{	
		$sql = "SELECT 
				remisiones.idPayments,
				remisiones.intereses,
				wallets_by_campaign.campaignName,
				remisiones.id,
				remisiones.fecha,
				remisiones.idWalletByCampaign,
				remisiones.honorarios,
				remisiones.comision,
				remisiones.monto,
				remisiones.recaudo,
				remisiones.idCliente,
				remisiones.hora,
				campaigns.name,
				campaigns.idNumber
				FROM
				wallets_by_campaign
				INNER JOIN remisiones ON (wallets_by_campaign.idWalletByCampaign = remisiones.idWalletByCampaign)
				INNER JOIN campaigns ON (wallets_by_campaign.IdCampaign = campaigns.idCampaign)
				WHERE
				remisiones.id = :id";
		
		$colums = [ ':id' => $id ];
		$r = Yii::app()->db->createCommand($sql)->queryAll(true, $colums);
		
		$pays = explode(',', $r[0]['idPayments']);
		$r[0]['deudores'] = self::getDeudores($pays);
		return $r;
	}

	public static function getDeudores($pays)
	{
		$sql = "SELECT *, SUM(value) as recuperado,
		(SELECT legalName FROM wallets_tempo WHERE id = a.idWallet) as nombre,
		(SELECT capitalValue FROM wallets_tempo WHERE id = a.idWallet) as monto
		FROM payments a WHERE idPayment IN (".implode(',', $pays).")";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}


}