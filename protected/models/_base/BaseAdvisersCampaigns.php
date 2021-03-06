<?php

/**
 * This is the model base class for the table "advisers_campaigns".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "AdvisersCampaigns".
 *
 * Columns in table "advisers_campaigns" available as properties of the model,
 * followed by relations of table "advisers_campaigns" available as properties of the model.
 *
 * @property string $idAvidsersCampaign
 * @property string $idAdvisers
 * @property string $idCampaign
 * @property string $comment
 *
 * @property Advisers $idAdvisers0
 * @property Campaigns $idCampaign0
 */
abstract class BaseAdvisersCampaigns extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'advisers_campaigns';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Campañas a asesores|Campañas a asesores', $n);
	}

	public static function representingColumn() {
		return 'comment';
	}

	public function rules() {
		return array(
			array('idAdvisers, idCampaign', 'length', 'max'=>20),
			array('comment', 'safe'),
			array('idAdvisers, idCampaign, comment', 'default', 'setOnEmpty' => true, 'value' => null),
			array('idAvidsersCampaign, idAdvisers, idCampaign, comment', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'idAdvisers0' => array(self::BELONGS_TO, 'Advisers', 'idAdvisers'),
			'idCampaign0' => array(self::BELONGS_TO, 'Campaigns', 'idCampaign'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'idAvidsersCampaign' => Yii::t('app', 'Id Avidsers Campaign'),
			'idAdvisers' => null,
			'idCampaign' => null,
			'comment' => Yii::t('app', 'Comment'),
			'idAdvisers0' => null,
			'idCampaign0' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('idAvidsersCampaign', $this->idAvidsersCampaign, true);
		$criteria->compare('idAdvisers', $this->idAdvisers);
		$criteria->compare('idCampaign', $this->idCampaign);
		$criteria->compare('comment', $this->comment, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
                        //'sort' => array('defaultOrder'=>'orden')
		));
	}
}