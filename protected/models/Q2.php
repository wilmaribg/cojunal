<?php

Yii::import('application.models._base.BaseQ2');

class Q2 extends BaseQ2
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}