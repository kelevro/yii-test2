<?php

namespace user\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
	public $email;
	public $password;

	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
			[['email', 'password'], 'required'],
			['password', 'validatePassword'],
		];
	}

	/**
	 * Validates the password.
	 * This method serves as the inline validation for password.
	 */
	public function validatePassword()
	{
		$user = User::findByEmail($this->email);
		if (!$user || !$user->validatePassword($this->password)) {
			$this->addError('password', 'Incorrect username or password.');
		}
	}

	/**
	 * Logs in a user using the provided username and password.
	 * @return boolean whether the user is logged in successfully
	 */
	public function login()
	{
		if ($this->validate()) {
			$user = User::findByEmail($this->email);
			Yii::$app->user->login($user, \Y::param('login.duration'));
			return true;
		} else {
			return false;
		}
	}
}
