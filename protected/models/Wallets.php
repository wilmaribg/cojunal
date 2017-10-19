<?php

Yii::import('application.models._base.BaseWallets');

class Wallets extends BaseWallets
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}