<?php


class ServiceType extends GxActiveRecord
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public static function getAll()
	{
		$sql = "SELECT * FROM notificationType ORDER BY notificationType.idNotificationType ASC";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	public static function getDescripcion($id = 0)
	{
		$sql = "SELECT description FROM notificationType WHERE idNotificationType = :id";
		return Yii::app()->db->createCommand($sql)->queryRow(true, [':id' => $id]);
	}
}