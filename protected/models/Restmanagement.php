<?php

Yii::import('application.models._base.BaseRestmanagement');

class Restmanagement extends BaseRestmanagement
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}