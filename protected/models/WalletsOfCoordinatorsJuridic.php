<?php


class WalletsOfCoordinatorsJuridic extends GxActiveRecord
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/*===========================================================================================================
    	11/Sept/2017 Unisoft - Wilmar Ibarguen M.
    ===========================================================================================================*/ 
    public static function setClienteParaJuridico($idCliente, $idCoordinator, $idCampaign)
    {
    	$prms = [
    		':idWalletTempo' => $idCliente, 
    		':idCoordinatorJuridic' => $idCoordinator, 
    		':idCampaign' => $idCampaign 
    	];
    	// Elimina
    	$sql0 = "UPDATE wallets_of_coordinators_juridic SET idCoordinatorJuridic = :idCoordinatorJuridic 
    			WHERE idWalletTempo = :idWalletTempo AND idCampaign = :idCampaign";
    	// Inserta
    	$sql1 = "INSERT INTO wallets_of_coordinators_juridic (idWalletTempo, idCoordinatorJuridic, idCampaign) 
    			VALUES (:idWalletTempo, :idCoordinatorJuridic, :idCampaign)";
		if(! Yii::app()->db->createCommand($sql0)->execute($prms)) {
			return Yii::app()->db->createCommand($sql1)->execute($prms);
		}else {
			return 1;
		}
    }

}