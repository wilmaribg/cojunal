<?php

Yii::import('application.models._base.BaseAuthAssignment');

class AuthAssignment extends BaseAuthAssignment
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public static function getProfile($userEmail)
	{
		return Yii::app()->db->createCommand()
			->select('itemname')
			->from('authassignment')
			->where('userid=:userid', [':userid' => $userEmail])
			->queryRow();
	}
}