<?php

Yii::import('application.models._base.BaseCmsMenu');

class CmsMenu extends BaseCmsMenu
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}