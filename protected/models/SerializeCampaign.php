<?php


class SerializeCampaign extends GxActiveRecord
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	// Esta funcion guarda los datos serializados para su posterior recupéracion
	public static function create($data = [])
	{
		$sql = "INSERT INTO serializeCampaign (id, idCampaign, name, data, createdAt, aprovedAt, estatus) 
				VALUES (NULL, :idCampaign, :name, :data, CURRENT_TIMESTAMP, NULL, '1')";
	
		$params = [
			':idCampaign' => $data['idCampaign'], 
			':name' => $data['name'], 
			':data' => $data['data']
		];
		Yii::app()->db->createCommand($sql)->execute($params);
		return Yii::app()->db->getLastInsertID(); 
	}

	// Esta funcion me devuelce los datos serializados
	public static function get($id = 0)
	{
		$sql = "SELECT * FROM serializeCampaign WHERE id = :id AND estatus = 1";
		return Yii::app()->db->createCommand($sql)->queryAll(true, [':id' => $id]);
	}

	// Esta funcion actualiza el dato si campaña fue migrada con exito
	public static function update_callback_migration($id = 0)
	{
		$sql = "UPDATE serializeCampaign SET aprovedAt = CURRENT_TIMESTAMP, estatus = '2' WHERE id = :id;";
		return Yii::app()->db->createCommand($sql)->execute([':id' => $id]);
	}
}