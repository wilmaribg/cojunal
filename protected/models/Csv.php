<?php

Yii::import('application.models._base.BaseCsv');

class Csv extends BaseCsv
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}