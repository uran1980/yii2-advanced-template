<?php
namespace common\rbac\helpers;

use common\models\User;
use common\rbac\models\Role;
use Yii;

/**
 * Rbac helper class.
 */
class RbacHelper
{
    /**
     * Assigns the appropriate role to the registered user.
     * If this is the first registered user in our system, he will get the
     * root role (this should be you), if not, he will get the user role.
     *
     * @param  User   $user User object.
     * @return string       Role name.
     */
    public static function assignRole(User $user)
    {
        $id = $user->getId();

        // make sure there are no leftovers
        Role::deleteAll(['user_id' => $id]);

        $auth = Yii::$app->authManager;
        $role = $auth->getRole($user->role);
        $auth->assign($role, $id);

        // return assigned role name in case you want to use this method in tests
        return $role->name;
    }
}

