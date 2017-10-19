<?php

Yii::import('application.models._base.BaseAgenda');

class Agenda extends BaseAgenda
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}