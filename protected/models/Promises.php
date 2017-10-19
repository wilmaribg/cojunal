<?php

Yii::import('application.models._base.BasePromises');

class Promises extends BasePromises
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}