<?php


class NotificationType extends GxActiveRecord
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public static function getAll()
	{
		$sql = "SELECT * FROM notificationType ORDER BY notificationType.idNotificationType ASC";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	public static function get($id = 0)
	{
		$sql = "SELECT * FROM notificationType WHERE idNotificationType = :id";
		return Yii::app()->db->createCommand($sql)->queryAll(true, [':id' => $id]);
	}
}