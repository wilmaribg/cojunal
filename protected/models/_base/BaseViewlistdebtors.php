<?php

/**
 * This is the model base class for the table "viewlistdebtors".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Viewlistdebtors".
 *
 * Columns in table "viewlistdebtors" available as properties of the model,
 * and there are no model relations.
 *
 * @property string $idWallet
 * @property string $idCampaign
 * @property string $name
 * @property string $idNumber
 * @property string $legalName
 * @property double $capitalValue
 * @property double $valueAssigment
 * @property double $currentDebt
 * @property double $feeValue
 * @property string $dAssigment
 * @property string $dUpdate
 * @property string $idStatus
 * @property string $description
 * @property double $interestMonth
 * @property double $interest
 * @property integer $gestion
 *
 */
abstract class BaseViewlistdebtors extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'viewlistdebtors';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Viewlistdebtors|Viewlistdebtors', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('name, idNumber, legalName, capitalValue, dAssigment, description', 'required'),
			array('gestion', 'numerical', 'integerOnly'=>true),
			array('capitalValue, valueAssigment, currentDebt, feeValue, interestMonth, interest', 'numerical'),
			array('idWallet, idCampaign, idStatus', 'length', 'max'=>20),
			array('name, idNumber, description', 'length', 'max'=>45),
			array('legalName', 'length', 'max'=>255),
			array('dUpdate', 'safe'),
			array('idWallet, idCampaign, valueAssigment, currentDebt, feeValue, dUpdate, idStatus, interestMonth, interest, gestion', 'default', 'setOnEmpty' => true, 'value' => null),
			array('idWallet, idCampaign, name, idNumber, legalName, capitalValue, valueAssigment, currentDebt, feeValue, dAssigment, dUpdate, idStatus, description, interestMonth, interest, gestion', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'idWallet' => Yii::t('app', 'Id Wallet'),
			'idCampaign' => Yii::t('app', 'Id Campaign'),
			'name' => Yii::t('app', 'Name'),
			'idNumber' => Yii::t('app', 'Id Number'),
			'legalName' => Yii::t('app', 'Legal Name'),
			'capitalValue' => Yii::t('app', 'Capital Value'),
			'valueAssigment' => Yii::t('app', 'Value Assigment'),
			'currentDebt' => Yii::t('app', 'Current Debt'),
			'feeValue' => Yii::t('app', 'Fee Value'),
			'dAssigment' => Yii::t('app', 'D Assigment'),
			'dUpdate' => Yii::t('app', 'D Update'),
			'idStatus' => Yii::t('app', 'Id Status'),
			'description' => Yii::t('app', 'Description'),
			'interestMonth' => Yii::t('app', 'Interest Month'),
			'interest' => Yii::t('app', 'Interest'),
			'gestion' => Yii::t('app', 'Gestion'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('idWallet', $this->idWallet, true);
		$criteria->compare('idCampaign', $this->idCampaign, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('idNumber', $this->idNumber, true);
		$criteria->compare('legalName', $this->legalName, true);
		$criteria->compare('capitalValue', $this->capitalValue);
		$criteria->compare('valueAssigment', $this->valueAssigment);
		$criteria->compare('currentDebt', $this->currentDebt);
		$criteria->compare('feeValue', $this->feeValue);
		$criteria->compare('dAssigment', $this->dAssigment, true);
		$criteria->compare('dUpdate', $this->dUpdate, true);
		$criteria->compare('idStatus', $this->idStatus, true);
		$criteria->compare('description', $this->description, true);
		$criteria->compare('interestMonth', $this->interestMonth);
		$criteria->compare('interest', $this->interest);
		$criteria->compare('gestion', $this->gestion);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
                        //'sort' => array('defaultOrder'=>'orden')
		));
	}
}