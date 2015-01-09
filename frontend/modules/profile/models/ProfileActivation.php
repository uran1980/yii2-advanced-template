<?php
namespace frontend\modules\profile\models;

use common\models\User;
use yii\base\InvalidParamException;
use yii\base\Model;

/**
 * Class representing profile activation.
 */
class ProfileActivation extends Model
{
    /**
     * @var \common\models\User
     */
    private $_user;

    /**
     * Creates the user object given a token.
     *
     * @param  string $token  Account activation token.
     * @param  array  $config Name-value pairs that will be used to initialize the object properties.
     *
     * @throws \yii\base\InvalidParamException  If token is empty or not valid.
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Profile activation token cannot be blank.');
        }

        $this->_user = User::findByProfileActivationToken($token);

        if (!$this->_user) {
            throw new InvalidParamException('Wrong profile activation token. Please try again.');
        }

        parent::__construct($config);
    }

    /**
     * Activates profile.
     *
     * @return bool Whether the profile was activated.
     */
    public function activateProfile()
    {
        $user = $this->_user;

        $user->status = User::STATUS_ACTIVE;
        $user->removeProfileActivationToken();

        return $user->save();
    }

    /**
     * Returns the username of the user who has activated profile.
     *
     * @return string
     */
    public function getUsername()
    {
        $user = $this->_user;

        return $user->username;
    }
}
