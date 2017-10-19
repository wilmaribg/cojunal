<?php

/**
 * This is the model base class for the table "AuthItem".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "AuthItem".
 *
 * Columns in table "AuthItem" available as properties of the model,
 * followed by relations of table "AuthItem" available as properties of the model.
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $bizrule
 * @property string $data
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthItemChild[] $authItemChildren
 * @property AuthItemChild[] $authItemChildren1
 */
abstract class BaseAuthItem extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'authitem';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'AuthItem|AuthItems', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('name, type', 'required'),
			array('type', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
			array('description, bizrule, data', 'safe'),
			array('description, bizrule, data', 'default', 'setOnEmpty' => true, 'value' => null),
			array('name, type, description, bizrule, data', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'authAssignments' => array(self::HAS_MANY, 'AuthAssignment', 'itemname'),
			'authItemChildren' => array(self::HAS_MANY, 'AuthItemChild', 'parent'),
			'authItemChildren1' => array(self::HAS_MANY, 'AuthItemChild', 'child'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'name' => Yii::t('app', 'Name'),
			'type' => Yii::t('app', 'Type'),
			'description' => Yii::t('app', 'Description'),
			'bizrule' => Yii::t('app', 'Bizrule'),
			'data' => Yii::t('app', 'Data'),
			'authAssignments' => null,
			'authItemChildren' => null,
			'authItemChildren1' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('name', $this->name, true);
		$criteria->compare('type', $this->type);
		$criteria->compare('description', $this->description, true);
		$criteria->compare('bizrule', $this->bizrule, true);
		$criteria->compare('data', $this->data, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
                        //'sort' => array('defaultOrder'=>'orden')
		));
	}
}