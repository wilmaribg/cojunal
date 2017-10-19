<?php

Yii::import('application.models._base.BaseCmsService');

class CmsService extends BaseCmsService
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}