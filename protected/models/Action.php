<?php

Yii::import('application.models._base.BaseAction');

class Action extends BaseAction
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}