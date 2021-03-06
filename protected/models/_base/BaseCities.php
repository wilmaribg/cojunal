<?php

/**
 * This is the model base class for the table "cities".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Cities".
 *
 * Columns in table "cities" available as properties of the model,
 * followed by relations of table "cities" available as properties of the model.
 *
 * @property string $idCity
 * @property string $name
 * @property string $idDepartament
 *
 * @property Departaments $idDepartament0
 * @property Districts[] $districts
 */
abstract class BaseCities extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'cities';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Cities|Cities', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('name, idDepartament', 'required'),
			array('name', 'length', 'max'=>45),
			array('idDepartament', 'length', 'max'=>20),
			array('idCity, name, idDepartament', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'departments' => array(self::BELONGS_TO, 'Departaments', 'idDepartament'),
			'districts' => array(self::HAS_MANY, 'Districts', 'idCity'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'idCity' => Yii::t('app', 'Id City'),
			'name' => Yii::t('app', 'Name'),
			'idDepartament' => null,
			'idDepartament0' => null,
			'districts' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('idCity', $this->idCity, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('idDepartament', $this->idDepartament);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
                        //'sort' => array('defaultOrder'=>'orden')
		));
	}
}