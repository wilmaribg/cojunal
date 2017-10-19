<?php

/**
 * This is the model base class for the table "status".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Status".
 *
 * Columns in table "status" available as properties of the model,
 * followed by relations of table "status" available as properties of the model.
 *
 * @property string $idStatus
 * @property string $description
 * @property string $dCreation
 *
 * @property Wallets[] $wallets
 */
abstract class BaseStatus extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'status';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Status|Statuses', $n);
	}

	public static function representingColumn() {
		return 'description';
	}

	public function rules() {
		return array(
			array('description, dCreation', 'required'),
			array('description', 'length', 'max'=>45),
			array('idStatus, description, dCreation', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'wallets' => array(self::HAS_MANY, 'Wallets', 'idStatus'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'idStatus' => Yii::t('app', 'Id Status'),
			'description' => Yii::t('app', 'Description'),
			'dCreation' => Yii::t('app', 'D Creation'),
			'wallets' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('idStatus', $this->idStatus, true);
		$criteria->compare('description', $this->description, true);
		$criteria->compare('dCreation', $this->dCreation, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
                        //'sort' => array('defaultOrder'=>'orden')
		));
	}
}