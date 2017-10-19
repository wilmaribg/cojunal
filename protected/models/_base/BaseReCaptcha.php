<?php

abstract class BaseReCaptcha extends CModel{
	public $model;
	public $attribute;
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function attributeNames(){

	}
    public function rules()
    {
        return array(
            array('verifyCode', 'required'),
            array('verifyCode', 'ext.yiiReCaptcha.ReCaptchaValidator'),
        );
    }

    public function attributeLabels() {
            return array(
                    'verifyCode'=>'Código de Verificación',
            );
    }
	
}