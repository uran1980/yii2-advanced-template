<?php

namespace common\models\forms;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $rememberMe = true;

    /**
     * @var \common\models\User
     */
    private $_user = false;

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['email', 'email'],
            ['password', 'validatePassword'],
            ['rememberMe', 'boolean'],
            // username and password are required on default scenario
            [['username', 'password'], 'required', 'on' => 'default'],
            // email and password are required on 'LoginWithEmail' (login with email) scenario
            [['email', 'password'], 'required', 'on' => 'LoginWithEmail'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute The attribute currently being validated.
     * @param array  $params    The additional name-value pairs.
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                // if scenario is 'LoginWithEmail' we use email, otherwise we use username
                $field = ($this->scenario === 'LoginWithEmail') ? 'email' : 'username' ;

                $this->addError($attribute, 'Incorrect '.$field.' or password.');
            }
        }
    }

    /**
     * Returns the attribute labels.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username'      => Yii::t('common', 'Username'),
            'password'      => Yii::t('common', 'Password'),
            'email'         => Yii::t('common', 'Email'),
            'rememberMe'    => Yii::t('common', 'Remember me'),
        ];
    }

    /**
     * Logs in a user using the provided username|email and password.
     *
     * @return bool Whether the user is logged in successfully.
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by username or email in 'LoginWithEmail' scenario.
     *
     * @return User|null|static
     */
    public function getUser()
    {
        if ($this->_user === false) {
            // in 'LoginWithEmail' scenario we find user by email, otherwise by username
            if ($this->scenario === 'LoginWithEmail') {
                $this->_user = User::findByEmail($this->email);
            } else {
                $this->_user = User::findByUsername($this->username);
            }
        }

        return $this->_user;
    }

    /**
     * Checks to see if the given user has NOT activated his profile yet.
     * We first check if user exists in our system,
     * and then did he activated his profile.
     *
     * @return bool True if not activated.
     */
    public function notActivated()
    {
        // if scenario is 'LoginWithEmail' we will use email as our username, otherwise we use username
        $username = ($this->scenario === 'LoginWithEmail') ? $this->email : $this->username;
        $user = User::userExists($username, $this->password, $this->scenario);

        if ( $user ) {
            if ($user->status === User::STATUS_NOT_ACTIVE) {
                return true;
            } else {
                return false;
            }
        }
    }
}
