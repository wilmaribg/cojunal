<?php

/**
 * This is the model base class for the table "demographics".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Demographics".
 *
 * Columns in table "demographics" available as properties of the model,
 * followed by relations of table "demographics" available as properties of the model.
 *
 * @property string $idDemographic
 * @property string $value
 * @property string $idCity
 * @property string $idAdviser
 * @property string $idType
 * @property string $dCreation
 * @property string $idWallet
 * @property string $comment
 * @property string $relationshipType
 * @property string $phoneType
 * @property string $contactName
 * @property string $addressType
 *
 * @property Advisers $idAdviser0
 * @property Wallets $idWallet0
 * @property Types $idType0
 * @property Cities $idCity0
 */
abstract class BaseDemographics extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'demographics';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Demographics|Demographics', $n);
	}

	public static function representingColumn() {
		return 'value';
	}

	public function rules() {
		return array(
			array('value, idAdviser, idType, dCreation, idWallet', 'required'),
			array('value', 'length', 'max'=>45),
			array('idCity, idAdviser, idType, idWallet', 'length', 'max'=>20),
			array('relationshipType, phoneType, contactName, addressType', 'length', 'max'=>155),
			array('comment', 'safe'),
			array('idCity, comment, relationshipType, phoneType, contactName, addressType', 'default', 'setOnEmpty' => true, 'value' => null),
			array('idDemographic, value, idCity, idAdviser, idType, dCreation, idWallet, comment, relationshipType, phoneType, contactName, addressType', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'idAdviser0' => array(self::BELONGS_TO, 'Advisers', 'idAdviser'),
			'idWallet0' => array(self::BELONGS_TO, 'Wallets', 'idWallet'),
			'idType0' => array(self::BELONGS_TO, 'Types', 'idType'),
			'idCity0' => array(self::BELONGS_TO, 'Cities', 'idCity'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'idDemographic' => Yii::t('app', 'Id Demographic'),
			'value' => Yii::t('app', 'Value'),
			'idCity' => null,
			'idAdviser' => null,
			'idType' => null,
			'dCreation' => Yii::t('app', 'D Creation'),
			'idWallet' => null,
			'comment' => Yii::t('app', 'Comment'),
			'relationshipType' => Yii::t('app', 'Relationship Type'),
			'phoneType' => Yii::t('app', 'Phone Type'),
			'contactName' => Yii::t('app', 'Contact Name'),
			'addressType' => Yii::t('app', 'Address Type'),
			'idAdviser0' => null,
			'idWallet0' => null,
			'idType0' => null,
			'idCity0' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('idDemographic', $this->idDemographic, true);
		$criteria->compare('value', $this->value, true);
		$criteria->compare('idCity', $this->idCity);
		$criteria->compare('idAdviser', $this->idAdviser);
		$criteria->compare('idType', $this->idType);
		$criteria->compare('dCreation', $this->dCreation, true);
		$criteria->compare('idWallet', $this->idWallet);
		$criteria->compare('comment', $this->comment, true);
		$criteria->compare('relationshipType', $this->relationshipType, true);
		$criteria->compare('phoneType', $this->phoneType, true);
		$criteria->compare('contactName', $this->contactName, true);
		$criteria->compare('addressType', $this->addressType, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
                        //'sort' => array('defaultOrder'=>'orden')
		));
	}
}