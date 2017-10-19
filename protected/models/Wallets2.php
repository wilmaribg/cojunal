<?php
class Wallets2 extends GxActiveRecord
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'wallets';
	}

}