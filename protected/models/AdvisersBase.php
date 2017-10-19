<?php

Yii::import('application.models._base.BaseAdvisers');

class AdvisersBase extends BaseAdvisers
{
	// NO BORRAR ESTA FUNCION
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public static function listCampanas($id=""){
		$connection = Yii::app()->db;
		$sql = "SELECT 
												`advisers`.`name` AS `coordinador`,
												`campaigns`.`name` AS `campana`,
												`campaigns`.`companyName`,
												`campaigns`.`fCreacion`,
												`advisers1`.`name` as asesor,
												(SELECT `paymentypes`.`paymentTypeName` FROM `paymentypes` INNER JOIN `viewlistdebtors` ON (`paymentypes`.`idPaymentType` = `viewlistdebtors`.`type`) WHERE `viewlistdebtors`.`idCampaign` = `campaigns`.`idCampaign` GROUP BY viewlistdebtors.type) AS `type`,
												(SELECT SUM(`viewlistdebtors`.`capitalValue`) AS `FIELD_1` FROM `viewlistdebtors` WHERE `viewlistdebtors`.`idCampaign` = `campaigns`.`idCampaign` GROUP BY viewlistdebtors.type) AS `total_campa`,
												`advisers_campaigns`.`idAdvisers`,
												campaigns.idCampaign
												FROM
												`campaigns`
												INNER JOIN `advisers_campaigns` ON (`campaigns`.`idCampaign` = `advisers_campaigns`.`idCampaign`)
												INNER JOIN `advisers` ON (`advisers_campaigns`.`idAdvisers` = `advisers`.`idAdviser`)
												INNER JOIN `advisers` `advisers1` ON (`campaigns`.`idAdviser` = `advisers1`.`idAdviser`)
												WHERE
												`advisers_campaigns`.`idAdvisers` = '".$id."'";
		$listado = Yii::app()->db->createCommand($sql)->queryAll();
		return $listado;
	}


	public static function lista_asesores(){
		$connection = Yii::app()->db;
		$sql = 'SELECT DISTINCT 
												  advisers.name,
												  SUM(wallets.capitalValue) AS total,
												  COUNT(campaigns.name) AS num_campana
												FROM
												  advisers
												  INNER JOIN advisers_campaigns ON (advisers.idAdviser = advisers_campaigns.idAdvisers)
												  INNER JOIN campaigns ON (advisers_campaigns.idCampaign = campaigns.idCampaign)
												  INNER JOIN wallets_has_campaigns ON (campaigns.idCampaign = wallets_has_campaigns.idCampaign)
												  INNER JOIN wallets ON (wallets_has_campaigns.idWallet = wallets.idWallet)
												WHERE
												  advisers.status_idStatus = 2
												GROUP BY
												  advisers.name';
		$listado = Yii::app()->db->createCommand($sql)->queryAll();
		return $listado;
	}
	
	
	public static function actionSaveComment(){
		$idWallet = $_REQUEST['idWallet'];
		$idAdviser = $_REQUEST['idAdviser'];
		$comment = $_REQUEST['comment'];
		
		$model = new Comments;
		$model->idWallet = $idWallet;
		$model->idAdviser = $idAdviser;
		$model->comment = $comment;
		
		if(!$model->save()){                
				Yii::log("Error Campaign", "error", "actionSaveComment");
		}else{
				Yii::app()->user->setFlash('success', "Registros actualizados con éxito");
		}
}

	public function add_coordi_campana($idCampaign,$idCoordinator){
		$connection = Yii::app()->db;
		$sql = "INSERT INTO 
				  `advisers_campaigns`
				(
				  `idAdvisers`,
				  `idCampaign`
				) 
				VALUE (				 
				  :idAdvisers,
				  :idCampaign
				);";
		$parameters = array(":idAdvisers" 	=> $idCoordinator,
							":idCampaign" 	=> $idCampaign);
		Yii::app()->db->createCommand($sql)->execute($parameters);		
	}
	
		public static function lista_deudores(){
		$connection = Yii::app()->db;
		$sql = 'SELECT 
												  wallets.idWallet,
												  wallets.legalName,
												  wallets.idStatus,
												  `status`.description,
												  wallets.email,
												  wallets.capitalValue
												FROM
												  `status`
												  INNER JOIN wallets ON (`status`.idStatus = wallets.idStatus)
												WHERE
												  `status`.idStatus = 5';
		$listado = Yii::app()->db->createCommand($sql)->queryAll($sql);
		return $listado;
	}
	
	
	public static function lista_user_juridicos(){
		$connection = Yii::app()->db;
		$sql = 'SELECT 
						advisers.name,
						advisers.idAdviser
					FROM
						advisers
					WHERE
						advisers.status_idStatus = 5';
		$listado = Yii::app()->db->createCommand($sql)->queryAll($sql);
		return $listado;
	}
	


	public function update_wallets($idWallet,$idAdviser){

		$connection = Yii::app()->db;
		$idWallet = $_REQUEST['idWallet'];
		$idAdviser = $_REQUEST['idAdviser'];
	
		// $command = Yii::app()->db->createCommand()->update('wallets', 
		// 	array('idAdviser' => $idAdviser), 
		// 	'idWallet=:idWallet', 
		// 	array(':idWallet'=> $idWallet);				
		
		return Yii::app()->db->createCommand()->update(
			'wallets', 
			['idAdviser' => $idAdviser], 
			'idWallet=:idWallet',
			[':idWallet' => $idWallet]
		);
	}


	public static function listado_estados(){
		$connection = Yii::app()->db;
		$sql = 'SELECT 
					`status`.idStatus,
					`status`.description,
					`status`.dCreation
				FROM
					`status`';
		$listado = Yii::app()->db->createCommand($sql)->queryAll($sql);
		return $listado;
	}
	
	
	public function add_estados(){
		$connection = Yii::app()->db;
		$descripction = $_REQUEST['description'];
		$idCampaing = $_REQUEST['idCampaing'];
		//$creacion = $_REQUEST['dCreation'];

		$sql = "INSERT INTO `status` (`description`, `idCampaing`, `dCreation` ) 
			VALUES (:description, :idCampaing, :dCreation);";
		$parameters = [
			":description" 	=> $descripction,
			":idCampaing" 	=> $idCampaing,
			":dCreation" 	=> date('Y-m-d')
		];
		return Yii::app()->db->createCommand($sql)->execute($parameters);		
	}
	
	public function get_status(){
		$idCampaing = $_REQUEST['idCampaing'];
		$sql = sprintf('SELECT * FROM `status` WHERE idCampaing = "%s"', $idCampaing);
		$listado = Yii::app()->db->createCommand($sql)->queryAll($sql);
		return $listado;
	}
	
	
		public function update_status(){

		$connection = Yii::app()->db;
		$descripcion = $_REQUEST['descripcion'];
		$idStatus = $_REQUEST['idStatus'];
	
		$command = Yii::app()->db->createCommand()->update(
			'status', 
			array('description'=>$descripcion), 
			'idStatus=:idStatus', 
			array(':idStatus'=>$idStatus)
		);
		return $command;
	}	
	
	public function listado_campanas_coordinador(){
		$sql = 'SELECT DISTINCT 
				  campaigns.name,
				  campaigns.companyName,
				  COUNT(campaigns.name) AS campanas,
				  COUNT(wallets.idWallet) AS num_deudores,
				  SUM(wallets.capitalValue) AS saldo
				FROM
				  wallets_has_campaigns
				  INNER JOIN campaigns ON (wallets_has_campaigns.idCampaign = campaigns.idCampaign)
				  INNER JOIN wallets ON (wallets_has_campaigns.idWallet = wallets.idWallet)
				GROUP BY
				  campaigns.name,
				  campaigns.companyName';
		$listado = Yii::app()->db->createCommand($sql)->queryAll($sql);
		return $listado;
	}			
	

	public function lista_clientes_editar(){
		$idcampana = $_REQUEST['idcampaight'];
		$sql = 'SELECT 
				campaigns.idCampaign,
				campaigns.name,
				campaigns.contactEmail,
				campaigns.fCreacion,
				campaigns.idNumber,
				campaigns.valueService1,
				campaigns.valueService2,
				campaigns.interest,
				campaigns.percentageCommission,
				campaigns.fees
			FROM
				campaigns
			WHERE
				campaigns.idCampaign = '.$idcampana;
		$listado = Yii::app()->db->createCommand($sql)->queryAll($sql);
		return $listado;
	}	


	public function update_clientes(){
		
		
				$connection = Yii::app()->db;
				//$nombre 	= $_POST['Campaigns']['name'];
				//$email 		= $_POST['Campaigns']['contactEmail'];
				//$nit 		= $_POST['Campaigns']['idNumber'];
				$value1 	= $_POST['Campaigns']['valueService1'];
				$value2 	= $_POST['Campaigns']['valueService2'];
				$interes 	= $_POST['Campaigns']['interest'];
				$com 		= $_POST['Campaigns']['percentageCommission'];
				$hono 		= $_POST['Campaigns']['fees'];
				$id			= $_POST['Campaigns']['idAdviser'];

				

			return Yii::app()->db->createCommand()->update(
				'campaigns', 
				['valueService1' => $value1], 
				'idCampaign=:idCampaign',
				[':idCampaign' => $id]
			);
	}

	
	function asigna_campana(){
		
				/*$sql = "INSERT INTO wallets_by_campaign (idCampaign, campaignName, serviceType, notificationType, createAt) 
				VALUES (:idCampaign, :campaignName, :serviceType, :notificationType, CURRENT_TIMESTAMP)";
				$parameters = [
					':idCampaign' => $data['idCampaign'], 
					':campaignName' => $data['campaignName'], 
					':serviceType' => $data['serviceType'], 
					':notificationType' => $data ['notificationType']
				];
				return Yii::app()->db->createCommand($sql)->execute($parameters);*/
		
				return "jj";
		
			}


			public function lista_remisiones(){
				$idcliente = $_REQUEST['idCliente'];
				$sql = 'SELECT 
						campaigns.name,
						remisiones.hora,
						remisiones.fecha,
						remisiones.id
						FROM
						remisiones
						INNER JOIN campaigns ON (remisiones.idCliente = campaigns.idCampaign)
						WHERE
						campaigns.idCampaign = '.$idcliente;
				$listado = Yii::app()->db->createCommand($sql)->queryAll($sql);
				return $listado;
			}	

			public function lista_deudores_wallets($id){
				
				$sql = 'SELECT 
						wallets.legalName,
						remisiones.intereses,
						remisiones.honorarios,
						remisiones.comision,
						remisiones.monto,
						remisiones.recaudo,
						remisiones.hora,
						remisiones.idCliente,
						remisiones.id,
						remisiones.idPayments,
						remisiones.idWalletByCampaign
						FROM
						wallets_has_campaigns
						INNER JOIN remisiones ON (wallets_has_campaigns.idCampaign = remisiones.idWalletByCampaign)
						INNER JOIN wallets ON (wallets_has_campaigns.idWallet = wallets.idWallet)
						WHERE
						remisiones.idWalletByCampaign  =  '.$id;
				$listado = Yii::app()->db->createCommand($sql)->queryAll($sql);
				return $listado;
			}			

	public function search_ordenes_servicio($busqueda){			
			$sql = "SELECT 
						campaigns.name,
						remisiones.hora,
						remisiones.fecha,
						remisiones.id
						FROM
						remisiones
						INNER JOIN campaigns ON (remisiones.idCliente = campaigns.idCampaign)
						WHERE
						remisiones.id = {$busqueda}";			
			$listado = Yii::app()->db->createCommand($sql)->queryAll();
			return $listado;
		
	}
}
