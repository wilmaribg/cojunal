<?php

Yii::import('application.models.AdvisersBase');

class Advisers extends AdvisersBase
{
	/**
	 * [getCoordinadores description]
	 * @param  [type] $active [description]
	 * @return [type]         [description]
	 */
	public static function getCoordinadores($active = null)
	{
		$sql = "SELECT idAdviser, name, active, email FROM advisers a WHERE a.status_idStatus = 6";
		$sql .= ($active != null) ? sprintf(" AND active = %s", $active) : ""; 
		$connection = Yii::app()->db;
		$listado = Yii::app()->db->createCommand($sql)->queryAll();
		return $listado;
	}

	/**
	 * [getCoordinadoresInfo description]
	 * @return [type] [description]
	 */
	public static function getCoordinadoresInfo()
	{
		$sql = "SELECT idAdviser, name, active,
		(SELECT COUNT(idAdviser) FROM advisers WHERE parentAdviser = a.idAdviser) as total_asesores, 
		(SELECT COUNT(idAvidsersCampaign) FROM advisers_campaigns WHERE idAdvisers = a.idAdviser) as total_campanas, 
		(SELECT SUM(value) FROM payments WHERE idAdviser = a.idAdviser) as total_recuperado,
		(SELECT SUM(capitalValue) FROM viewlistdebtors WHERE idCampaign IN (SELECT idCampaign FROM advisers_campaigns WHERE idAdvisers = a.idAdviser)) as total_asignado
		FROM advisers a WHERE a.status_idStatus = 6";
		$connection = Yii::app()->db;
		$listado = Yii::app()->db->createCommand($sql)->queryAll();;
		return $listado;
	}

	/**
	 * [getAsesoresInfo description]
	 * @return [type] [description]
	 */
	public static function getAsesoresInfo()
	{
		$sql = "SELECT idAdviser, name, active, parentAdviser,
		(SELECT name FROM advisers WHERE idAdviser = a.parentAdviser) as coordinador, 
		(SELECT COUNT(idAvidsersCampaign) FROM advisers_campaigns WHERE idAdvisers = a.idAdviser) as total_campanas, 
		(SELECT SUM(value) FROM payments WHERE idAdviser = a.idAdviser) as total_recuperado,
		(SELECT SUM(capitalValue) FROM viewlistdebtors WHERE idCampaign IN (SELECT idCampaign FROM advisers_campaigns WHERE idAdvisers = a.idAdviser)) as total_asignado
		FROM advisers a WHERE a.status_idStatus = 2";
		$connection = Yii::app()->db;
		$listado = Yii::app()->db->createCommand($sql)->queryAll();
		return $listado;
	}

	/**
	 * [enableDisableAdviser description]
	 * @param  [type] $active    [description]
	 * @param  [type] $idAdviser [description]
	 * @return [type]            [description]
	 */
	public static function enableDisableAdviser($active, $idAdviser)
	{
		$resp = Yii::app()->db->createCommand()->update(
			'advisers', 
			['active' => $active], 
			'idAdviser=:idAdviser',
			[':idAdviser' => $idAdviser]
		);
		return $resp;
	}

	/**
	 * [setParentAdviser description]
	 * @param [type] $idAdviser     [description]
	 * @param [type] $parentAdviser [description]
	 */
	public static function setParentAdviser($parentAdviser, $idAdviser)
	{
		$resp = Yii::app()->db->createCommand()->update(
			'advisers', 
			['parentAdviser' => $parentAdviser], 
			'idAdviser=:idAdviser',
			[':idAdviser' => $idAdviser]
		);
		return $resp;
	}

	public static function campanas_sin_asignar()
	{
		$sql = "SELECT DISTINCT campaigns.companyName,  campaigns.idCampaign
				FROM  advisers_campaigns 
				INNER JOIN campaigns ON (advisers_campaigns.idCampaign <> campaigns.idCampaign)";
		$listado = Yii::app()->db->createCommand($sql)->queryAll();;
		return $listado;
		
	}

	public static function get_dashboard_admin()
	{
		$sql = "SELECT DISTINCT 
			COUNT(campaigns.name) AS campanas,  
			COUNT(wallets.idWallet) AS num_deudores,  
			SUM(payments.value) AS recuperado
			FROM  wallets_has_campaigns  
			INNER JOIN campaigns ON (wallets_has_campaigns.idCampaign = campaigns.idCampaign)  
			INNER JOIN wallets ON (wallets_has_campaigns.idWallet = wallets.idWallet)  
			INNER JOIN payments ON (wallets.idWallet = payments.idWallet)";

		$listado = Yii::app()->db->createCommand($sql)->queryAll();
		return $listado;
	}


	/*================================================================================================
		8 Junio 2017 Wilmar Ibarguen - Unisoft
	================================================================================================*/
	// Obtener el listado de los coordinadores jurídicos
	public static function getCoordinadoresJuridicos()
	{
		$sql = "SELECT idAdviser, name, email, active FROM advisers a
			WHERE active = 1 AND email IN (SELECT userid FROM `authassignment` WHERE itemname like '%Coordinador jurídico%')";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	// Obtener el listado de coordinadores que se muestra al administrador
	public static function getCoordinators()
	{
		$sql = "SELECT idAdviser, name, email, active,
			(SELECT COUNT(idAdviser) FROM advisers WHERE parentAdviser = a.idAdviser) AS num_asesores,
			(SELECT COUNT(id) FROM campaigns_coordinator WHERE idCoordinator = a.idAdviser) AS num_camapanas
			FROM advisers a
			WHERE email IN (SELECT userid FROM `authassignment` WHERE itemname like '%coordinador%')";

		if(isset($_POST['field']) && $_POST['field'] != '') {
			$sql .= sprintf(" ORDER BY %s %s", $_POST['field'], $_POST['orderBy']);
		}

		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	/*obtener listado asesores segun perfil*/
	public static function getAssesoresPerfil($id=0)
	{
		$sql = "SELECT 
				advisers.name,
				advisers.status_idStatus,
				advisers.idAdviser,
				authassignment.itemname
				FROM
				advisers
				INNER JOIN authassignment ON (advisers.email = authassignment.userid)
				WHERE
				advisers.active = 1 AND 
				authassignment.itemname LIKE '%".$id."'";


		return Yii::app()->db->createCommand($sql)->queryAll();
	}


	// Obtener el listado de asesores que se muestra al administrador
	public static function getAssesores()
	{
		$sql = "SELECT idAdviser, name, email, active, parentAdviser,
			(SELECT COUNT(idCampaign) FROM wallets_has_campaigns 
			WHERE idWallet IN  (SELECT idWallet FROM wallets WHERE idAdviser = a.idAdviser) GROUP BY idCampaign) AS num_camapanas
			FROM advisers a
			WHERE idAuthAssignment IN (SELECT idAuthAssignment FROM authassignment WHERE itemname LIKE '%asesor%')";

		if(isset($_POST['field']) && $_POST['field'] != '') {
			$sql .= sprintf(" ORDER BY %s %s", $_POST['field'], $_POST['orderBy']);
		}

		return Yii::app()->db->createCommand($sql)->queryAll();
	}

}
