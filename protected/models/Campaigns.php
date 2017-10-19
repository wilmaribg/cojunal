<?php

Yii::import('application.models._base.BaseCampaigns');

class Campaigns extends BaseCampaigns
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * [getClientsConfig description]
	 * @param  integer $limit   [description]
	 * @param  integer $records [description]
	 * @return [type]           [description]
	 */
	public static function getClientsConfig($limit = 0, $records = 10)
	{
		/*$sql = "SELECT idCampaign, name, contactEmail, fCreacion,
		(SELECT COUNT(idWallet) FROM wallets_has_campaigns WHERE idCampaign = a.idCampaign) AS numCampanas, 
		(SELECT SUM(feeValue) FROM viewlistdebtors WHERE idCampaign = a.idCampaign) AS sumHonorarios, 
		(SELECT SUM(interest) FROM viewlistdebtors WHERE idCampaign = a.idCampaign) AS sumintereses, 
		(SELECT SUM(valueAssigment) FROM viewlistdebtors WHERE idCampaign = a.idCampaign) AS saldoAsignado, 
		(SELECT SUM(capitalValue) FROM viewlistdebtors WHERE idCampaign = a.idCampaign) AS totalRecuperado 
		FROM campaigns a ORDER BY name";*/
		$sql = "SELECT * FROM campanas_asignadas ORDER BY name";
		$sql .= sprintf(" LIMIT %d, %d", ($limit * $records), $records);
		$listado = Yii::app()->db->createCommand($sql)->queryAll();
		return $listado;
	}

	public static function getCampaingsGrafico($idCampaign)
	{
		$sql = "SELECT a.*, b.valueService1, b.valueService2,
					(SELECT SUM(value) FROM payments WHERE idWallet IN (SELECT id FROM wallets_tempo WHERE idCampaign = a.idWalletByCampaign) ) AS monto_recuperado,
					(SELECT COUNT(id) FROM wallets_tempo WHERE idCampaign = a.idWalletByCampaign) AS num_clientes,
					(SELECT SUM(capitalValue) FROM wallets_tempo WHERE idCampaign = a.idWalletByCampaign) AS monto_total
				FROM wallets_by_campaign a 
				INNER JOIN campaigns b ON b.idCampaign = a.IdCampaign 
				WHERE a.idWalletByCampaign = :idCampaign";

		return Yii::app()->db->createCommand($sql)->queryAll(true, [':idCampaign' => $idCampaign]);
	}

	/**
	 * [getClientsNames description]
	 * @return [type] [description]
	 */
	public static function getClientsNames()
	{
		$sql = "SELECT idCampaign, name FROM campaigns ORDER BY name";
		$listado = Yii::app()->db->createCommand($sql)->queryAll();;
		return $listado;
	}

	/**
	 * [getClientsCount description]
	 * @return [type] [description]
	 */
	public static function getClientsCount()
	{
		$sql = "SELECT COUNT(idCampaign) as total FROM campaigns";
		$listado = Yii::app()->db->createCommand($sql)->queryAll();;
		return $listado;
	}

	/**
	 * [getCampaignByClient description]
	 * @return [type] [description]
	 */
	public static function getCampaignByClient($idCampaign = 0)
	{	
		$sql = "SELECT DISTINCT campaigns.companyName,
			SUM(wallets.capitalValue) AS saldo, 
			SUM(wallets.feeValue) AS intereses, 
			SUM(wallets.interestsValue) AS FIELD_1 
			FROM campaigns 
			INNER JOIN wallets_has_campaigns ON (campaigns.idCampaign = wallets_has_campaigns.idCampaign) 
			INNER JOIN wallets ON (wallets_has_campaigns.idWallet = wallets.idWallet)
			WHERE campaigns.idCampaign = '%s' 
			GROUP BY campaigns.companyName";

		$sql = sprintf($sql, $idCampaign);
		$listado = Yii::app()->db->createCommand($sql)->queryAll();
		return $listado;
	}

	public static function getCampanasForRemision($idCampaign)
	{
		$sql = "SELECT a.*,
			

		(SELECT SUM(recaudo) FROM remisiones WHERE idWalletByCampaign = a.idWalletByCampaign) as totalRecaudado, (SELECT fecha FROM remisiones WHERE idWalletByCampaign = a.idWalletByCampaign ORDER BY id DESC LIMIT 1) AS fechaUltimaRemision, 

		(SELECT GROUP_CONCAT(idPayment) FROM payments WHERE idWallet IN (SELECT id FROM wallets_tempo WHERE idCampaign = a.idWalletByCampaign) AND dPayment > IF(fechaUltimaRemision, fechaUltimaRemision, '0000-00-00')) AS idPayments,

		(SELECT SUM(value) FROM payments WHERE idWallet IN (SELECT id FROM wallets_tempo WHERE idCampaign = a.idWalletByCampaign) AND dPayment > IF(fechaUltimaRemision, fechaUltimaRemision, '0000-00-00')) AS recaudado, (SELECT SUM(capitalValue) FROM wallets_tempo WHERE idCampaign = a.idWalletByCampaign) AS saldoCampana 

		FROM wallets_by_campaign a WHERE a.IdCampaign = :IdCampaign";

		return Yii::app()->db->createCommand($sql)->queryAll(true, [':IdCampaign' => $idCampaign]);
	}

	public static function getCampaingsValues($idCampaign)
	{
		return Yii::app()->db->createCommand()
			->select('percentageCommission, interest, fees, valueService1, valueService2')
			->from('campaigns')
			->where('idCampaign=:idCampaign', array(':idCampaign'=>$idCampaign))
			->queryRow();
	}

	// Esta funcion devuelve el id filtrado por email
	public static function getIdCampaignByEmail($contactEmail='') 
	{
		return Yii::app()->db->createCommand()
			->select('idCampaign')
			->from('campaigns')
			->where('contactEmail=:contactEmail', array(':contactEmail'=>$contactEmail))
			->queryRow();
	}

	// Esta funcion devuelve los valores para los servicios 1 y 2 del cliente
	public static function getValuesServices() 
	{
		$session = Yii::app()->session;
        $emailUsuario = $session['cojunal'];
        
        return Yii::app()->db->createCommand()
        	->select('valueService1, valueService2')
        	->from('campaigns')
        	->where('contactEmail=:contactEmail', array(':contactEmail'=>$emailUsuario))
        	->queryRow();
	}

	// Esta funcion me devuelve los datos para la pestaña generar reporte en la ruta campañas del admin
	function getReportAdminCampanas($idCliente)
	{
		$sql = "SELECT COUNT(a.idWalletByCampaign) AS numCampanas,
				(SELECT COUNT(idNumber) FROM wallets_tempo WHERE idCampaign = a.idWalletByCampaign) AS numDeudores,
				a.createAt,
				(SELECT SUM(capitalValue) FROM wallets_tempo WHERE idCampaign = a.idWalletByCampaign) AS totalAsignado,
				(SELECT 'falta') AS totalRecuperado,
				(SELECT 'falta') AS asesorAsignado,
				(SELECT 'falta') AS cuadrante1,
				(SELECT 'falta') AS cuadrante2,
				(SELECT 'falta') AS cuadrante3,
				(SELECT 'falta') AS cuadrante4,
				(SELECT 'falta') AS cuadrante5,
				(SELECT 'falta') AS cuadrante6
				FROM wallets_by_campaign a 
				WHERE IdCampaign = :IdCampaign";
		return Yii::app()->db->createCommand($sql)->queryAll(true, [':IdCampaign' => $idCliente]);
	} 

	// Obtener el id del usuaro filtrando por el id
	public static function getIdCampaignPorID($id)
	{
		$sql = 'SELECT idCampaign FROM campaigns WHERE idCampaign = :idCampaign LIMIT 1';
		$params = [':idCampaign' => $id];
		return Yii::app()->db->createCommand($sql)->queryColumn($params);
	}

	// Obtener el id del usuaro filtrando por el correo
	public static function getIdCampaignPorEmail($email = '')
	{
		$sql = 'SELECT idCampaign FROM campaigns WHERE contactEmail = :contactEmail ORDER BY contactEmail DESC LIMIT 1';
		$params = [':contactEmail' => $email];
		return Yii::app()->db->createCommand($sql)->queryColumn($params);
	}

	// Esta funcione me devuelve Cliente # campañas por cliente  Valor total  Saldo a la fecha  % recaudo  # deudores 
    public static function getCampanasPorCliente_cpj($email)
    {
    	$sql = sprintf('SELECT idCampaign, name,
		(SELECT COUNT(idCampaign) FROM campaigns_coordinator b WHERE b.idCoordinator = (SELECT idAdviser FROM advisers WHERE email = "%s")) AS numCampanas, 
		(SELECT SUM(capitalValue) FROM wallets_tempo WHERE idCampaign IN (SELECT idCampaign FROM campaigns_coordinator WHERE idCoordinator = ((SELECT idAdviser FROM advisers WHERE email = "%s")))) AS valorTotal,
		(SELECT COUNT(idNumber) FROM wallets_tempo WHERE idCampaign IN (SELECT idCampaign FROM campaigns_coordinator WHERE idCoordinator = ((SELECT idAdviser FROM advisers WHERE email = "%s")))) AS numDeuddores
		FROM campaigns a
		WHERE idCampaign IN (SELECT IdCampaign FROM wallets_by_campaign WHERE idWalletByCampaign IN (SELECT idCampaign FROM campaigns_coordinator WHERE idCoordinator = (SELECT idAdviser FROM advisers WHERE email = "%s")))',
		$email, $email, $email, $email);

		return Yii::app()->db->createCommand($sql)->queryAll();
    }

    
	// Esta funcion devuelve Campañas Cliente Saldo Número Asesor Tipo
	public static function getCampanasPorClienteMin_cpj($correoCordinador)
	{
		$sql = sprintf("SELECT a.idWalletByCampaign, a.campaignName, b.idCampaign, b.name, a.serviceType,
		(SELECT SUM(capitalValue) FROM wallets_tempo WHERE idCampaign = a.idWalletByCampaign) AS saldoTotal,
		(SELECT COUNT(capitalValue) FROM wallets_tempo WHERE idCampaign = a.idWalletByCampaign) AS numDeudores
		FROM wallets_by_campaign a
		INNER JOIN campaigns b ON b.idCampaign = a.IdCampaign 
		WHERE idWalletByCampaign IN (SELECT idCampaign FROM campaigns_coordinator WHERE idCoordinator = 
			(SELECT idAdviser FROM advisers WHERE email = '%s')
		)", $correoCordinador);
		return Yii::app()->db->createCommand($sql)->queryAll();
	}


	// Esta funcion devuelve Campañas por Cliente 
	public static function getIdCampaignByUsers($idCampaign)
	{
		$sql = "SELECT idWalletByCampaign, campaignName, createAt, serviceType, 
			(SELECT SUM(capitalValue) FROM wallets_tempo WHERE idCampaign = a.idWalletByCampaign) AS saldoAsignado
			FROM wallets_by_campaign a
			WHERE IdCampaign = :IdCampaign";
		if(isset($_POST['field']) && isset($_POST['orderBy'])) {
			$sql .= sprintf(" ORDER BY %s %s", $_POST['field'], $_POST['orderBy']);
		}	
		$prms = [':IdCampaign' => $idCampaign];
		return Yii::app()->db->createCommand($sql)->queryAll(true, $prms);
	}

}