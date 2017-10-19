<?php

Yii::import('application.models._base.BaseDemographics');

class Demographics extends BaseDemographics
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}