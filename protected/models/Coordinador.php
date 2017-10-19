<?php
Yii::import('application.models._base.BaseCoordinador');

class Coordinador extends BaseCoordinador
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}