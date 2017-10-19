<?php

Yii::import('application.models._base.BaseCmsUsuario');

class CmsUsuario extends BaseCmsUsuario
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/*==========================================================================================
		11/Sept/2017 Unisoft - Wilmar Ibarguen M.
	==========================================================================================*/

	// Esta funcion devuelve los correos de los usuarios admin para enviar notificacion 
	// de creacion de campaña
	public static function obtenerEmailsAdmins()
	{
		$sql = "SELECT email FROM cms_usuario WHERE activo = 1 AND cms_rol_id = 2";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}
}