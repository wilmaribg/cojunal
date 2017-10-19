<?php

Yii::import('application.models._base.BaseCojServices');

class CojServices extends BaseCojServices
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}