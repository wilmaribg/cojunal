<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel {

    public $username;
    public $password;
    public $rememberMe;
    public $site;
    public $social;
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('username, password', 'required'),
            // rememberMe needs to be a boolean
            array('rememberMe, site', 'boolean'),
            // password needs to be authenticated
            array('password', 'authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'username' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Contraseña'),
            'rememberMe' => Yii::t('app', 'Recordarme la próxima vez'),
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {
            $this->_identity = new UserIdentity($this->username, $this->password);

            $resultLogin = $this->_identity->authenticate($this->site, $this->social);

            switch ($resultLogin) {
                case 1:
                    $this->addError('username', Yii::t('app', 'Usuario o contraseña incorrecta.'));
                    break;
                case 2:
                    $this->addError('password', Yii::t('app', 'Usuario o contraseña incorrecta.'));
                    break;
                case 3:
                    $this->addError('username', Yii::t('app', 'Usuario inactivo, Por favor contacta con el administrador.'));
                    break;
                case 4:
                    $this->addError('username', Yii::t('app', 'Usuario inactivo, Por favor contacta con el administrador.'));
                    break;
                case 5:
                    $this->addError('username', Yii::t('app', 'Usted ya inicio sesión en otro equipo, Por favor contacta con el administrador.'));
                    break;
            }
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login($adminProfile = false) {
        if ($this->_identity === null) {
            $this->_identity = new UserIdentity($this->username, $this->password);
            $this->_identity->authenticate($this->site);
        }
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
            $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
            Yii::app()->user->login($this->_identity, $duration);
            if($adminProfile == true) {
                return $this->_identity;
            }else {
                return true;
            }
        } else
            return false;
    }

}
