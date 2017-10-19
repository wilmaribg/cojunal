<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
        private $_id;
        
	public function authenticate($site = false, $red = "correo")
	{       
                //login cms
                if(!$site){
                    $users = CmsUsuario::model()->find('email=:user or usuario=:user', array(':user'=>$this->username));
                //login front optional
                }else{
                    //tabla de usuarios del front
                    $users = Usuario::model()->find("$red=:user", array(':user'=>$this->username));
                }
                //login cms
                if(!$site){
                    if($users == null){
                        $this->errorCode=self::ERROR_USERNAME_INVALID;
                        return $this->errorCode;
                    }elseif($users->contrasena != md5 ($this->password)){
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
                        return $this->errorCode;
                    }else if($users->activo == "0"){
                        $this->errorCode = "3";
                        return $this->errorCode;
                    }else{
                        $this->_id = $users->idcmsusuario;
                        $this->username = $users->usuario;
                        $this->setState('title', $users->nombres . ' ' . $users->apellidos);
                        $this->setState('rol', $users->cms_rol_id);
			$this->errorCode=self::ERROR_NONE;
                    }
                //login front optional
                }else{
                    if($users == null){
                        $this->errorCode=self::ERROR_USERNAME_INVALID;
                        return $this->errorCode;
                    }elseif($users->contrasena != md5 ($this->password) && $red == "correo"){
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
                        return $this->errorCode;
                    }else if($users->activo == "0"){
                        $this->errorCode = "3";
                        return $this->errorCode;
                    }else{
                        $this->_id = $users->idusuario;
                        $this->username = $users->correo;
                        $this->setState('title', $users->nombre . " " . $users->apellido );
                        $this->setState('rol', $users->cms_rol_id);
			$this->errorCode=self::ERROR_NONE;
                    }
                }
		return $this->errorCode;
	}
        
        public function getId() {
            return $this->_id;
        }
}