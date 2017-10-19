<?php

/*==========================================================================================
	11/Sept/2017 Unisoft - Wilmar Ibarguen M.
==========================================================================================*/

class CampaignsEmailsNotifications extends GxActiveRecord
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	// Esta funcion me agrega un email para notificar al cliente del estado de su campaña 
	public static function agregarEmailNotificacion($data)
	{
		$sql = sprintf("INSERT INTO campaigns_emails_notifications (idCampaign, emailNotification) VALUES ('%s', '%s')",
			$data['idCampaign'],
			$data['email']
		);
		return Yii::app()->db->createCommand($sql)->execute();
	}
}