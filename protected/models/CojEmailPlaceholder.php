<?php

class CojEmailPlaceholder extends GxActiveRecord
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public static function getEmailsPlaceholder()
	{
		$sql = "SELECT * FROM coj_email_placeholder WHERE idEmailPlaceholder = 1";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	public static function getEmailsPlaceholderClient()
	{
		$sql = "SELECT * FROM coj_email_placeholder WHERE idEmailPlaceholder = 2";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	public static function updateRegiaterClientNotification($text) 
	{
		return Yii::app()->db->createCommand()->update(
			'coj_email_placeholder', 
			['regiaterClientNotification' => $text], 
			'idEmailPlaceholder=:idEmailPlaceholder',
			[':idEmailPlaceholder' => 1]
		);
	}

	public static function updateTermsConditions($text) 
	{
		return Yii::app()->db->createCommand()->update(
			'coj_email_placeholder', 
			['termsConditions' => $text], 
			'idEmailPlaceholder=:idEmailPlaceholder',
			[':idEmailPlaceholder' => 1]
		);
	}

}