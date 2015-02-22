<?php

namespace frontend\modules\profile\models\forms;

use common\models\User;
use common\rbac\AccessControl;
use common\rbac\helpers\RbacHelper;
use nenad\passwordStrength\StrengthValidator;
use yii\base\Model;
use Yii;

/**
 * Model representing  Signup Form.
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $status;

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['username', 'unique', 'targetClass' => '\common\models\User',
                'message' => Yii::t('frontend-profile', 'This username has already been taken.')],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User',
                'message' => Yii::t('frontend-profile', 'This email address has already been taken.')],

            ['password', 'required'],
            // use passwordStrengthRule() method to determine password strength
            $this->passwordStrengthRule(),

            // on default scenario, user status is set to active
            ['status', 'default', 'value' => User::STATUS_ACTIVE, 'on' => 'default'],
            // status is set to not active on RegistrationNeedsActivation (registration needs activation) scenario
            ['status', 'default', 'value' => User::STATUS_NOT_ACTIVE, 'on' => 'RegistrationNeedsActivation'],
            // status has to be integer value in the given range. Check User model.
            ['status', 'in', 'range' => [User::STATUS_NOT_ACTIVE, User::STATUS_ACTIVE]]
        ];
    }

    /**
     * Set password rule based on our setting value (Force Strong Password).
     *
     * @return array Password strength rule
     */
    private function passwordStrengthRule()
    {
        // get setting value for 'Force Strong Password'
        $fsp = Yii::$app->params['ForceStrongPassword'];

        // password strength rule is determined by StrengthValidator
        // presets are located in: vendor/nenad/yii2-password-strength/presets.php
        $strong = [['password'], StrengthValidator::className(), 'preset' => 'normal'];

        // use normal yii rule
        $normal = ['password', 'string', 'min' => 6];

        // if 'Force Strong Password' is set to 'true' use $strong rule, else use $normal rule
        return ($fsp) ? $strong : $normal;
    }

    /**
     * Returns the attribute labels.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username'  => Yii::t('frontend-profile', 'Username'),
            'password'  => Yii::t('frontend-profile', 'Password'),
            'email'     => Yii::t('frontend-profile', 'Email'),
        ];
    }

    /**
     * Signs up the user.
     * If scenario is set to "RegistrationNeedsActivation" (registration needs activation), this means
     * that user need to activate his profile using email confirmation method.
     *
     * @return User|null The saved model or null if saving fails.
     */
    public function signup()
    {
        $user = new User();

        $user->username  = $this->username;
        $user->email     = $this->email;
        $user->user_role = ( (int) User::find()->count() === 0 )
                         ? AccessControl::ROLE_ROOT
                         : AccessControl::ROLE_USER;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->status = $this->status;

        // if scenario is "RegistrationNeedsActivation" we will generate profile activation token
        if ($this->scenario === 'RegistrationNeedsActivation') {
            $user->generateProfileActivationToken();
        }

        // if user is saved and role is assigned return user object
        return $user->save() && RbacHelper::assignRole($user) ? $user : null;
    }

    /**
     * Sends email to registered user with profile activation link.
     *
     * @param  object $user Registered user.
     * @return bool         Whether the message has been sent successfully.
     */
    public function sendProfileActivationEmail($user)
    {
        return Yii::$app->mailer
            ->compose('profileActivationToken', ['user' => $user])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setTo($this->email)
            ->setSubject(Yii::t('frontend-profile', 'Profile activation for') . ' ' . Yii::$app->name)
            ->send()
        ;
    }
}
