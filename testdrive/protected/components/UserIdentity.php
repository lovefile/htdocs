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
	public function authenticate()
	{
		$users=array(
			// username => password
			'demo'=>'demo',
			'admin'=>'admin',
		);
		$user = $this->getUser();
		$users = array();
		if($user['userName']==$this->username && $user['password']==$this->password)
		{
			$this->errorCode=self::ERROR_NONE;
		}
		else 
			$this->errorCode = self::ERROR_USERNAME_INVALID;
			return !$this->errorCode;
		if(!isset($users[$this->username]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif($users[$this->username]!==$this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
			$this->errorCode=self::ERROR_NONE;
		return !$this->errorCode;
	}
	public function getUser()
	{
		$connection = Yii::app()->db;
		$command = $connection->createCommand("select * from user where userName="."'".$this->username."'". "and password="."'".$this->password."'");
		$reader = $command->query();
		foreach($reader as $key => $val)
			return $val;
	}
}