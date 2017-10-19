<?php

Yii::import('application.models._base.BaseManagement');

class Management extends BaseManagement
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}