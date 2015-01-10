<?php
namespace console\controllers;

use yii\helpers\Console;
use yii\console\Controller;
use common\rbac\AccessControl;
use Yii;

/**
 * Creates base rbac authorization data for our application.
 * -----------------------------------------------------------------------------
 * Creates 6 roles:
 *
 * - root : you, developer of this site (super admin)
 * - admin      : your direct clients, administrators of this site
 * - editor     : editor of this site
 * - support    : support staff
 * - premium    : premium user of this site
 * - user       : user of this site who has registered his profile and can log in
 *
 * Creates 7 permissions:
 *
 * - usePremiumContent  : allows premium users to use premium content
 * - createArticle      : allows editor+ roles to create articles
 * - updateOwnArticle   : allows editor+ roles to update own articles
 * - updateArticle      : allows admin+ roles to update all articles
 * - deleteArticle      : allows admin+ roles to delete articles
 * - adminArticle       : allows admin+ roles to manage articles
 * - manageUsers        : allows admin+ roles to manage users (CRUD plus role assignment)
 *
 * Creates 1 rule:
 *
 * - AuthorRule : allows editor+ roles to update their own content
 */
class RbacController extends Controller
{
    /**
     * Initializes the RBAC authorization data.
     */
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        //----------------------------- RULES ----------------------------------
        // add the rule
        $rule = new \common\rbac\rules\AuthorRule;
        $auth->add($rule);

        //-------------------------- PERMISSIONS -------------------------------
        // add "usePremiumContent" permission
        $usePremiumContent = $auth->createPermission(AccessControl::PERMISSION_USE_PREMIUM_CONTENT);
        $usePremiumContent->description = 'Allows premium+ roles to use premium content';
        $auth->add($usePremiumContent);

        // add "manageUsers" permission
        $manageUsers = $auth->createPermission(AccessControl::PERMISSION_MANAGE_USERS);
        $manageUsers->description = 'Allows admin+ roles to manage users';
        $auth->add($manageUsers);

        // add "createArticle" permission
        $createArticle = $auth->createPermission(AccessControl::PERMISSION_CREATE_ARTICLE);
        $createArticle->description = 'Allows editor+ roles to create articles';
        $auth->add($createArticle);

        // add "deleteArticle" permission
        $deleteArticle = $auth->createPermission(AccessControl::PERMISSION_DELETE_ARTICLE);
        $deleteArticle->description = 'Allows admin+ roles to delete articles';
        $auth->add($deleteArticle);

        // add "adminArticle" permission
        $adminArticle = $auth->createPermission(AccessControl::PERMISSION_ADMIN_ARTICLE);
        $adminArticle->description = 'Allows admin+ roles to manage articles';
        $auth->add($adminArticle);

        // add "updateArticle" permission
        $updateArticle = $auth->createPermission(AccessControl::PERMISSION_UPDATE_ARTICLE);
        $updateArticle->description = 'Allows editor+ roles to update articles';
        $auth->add($updateArticle);

        // add the "updateOwnArticle" permission and associate the rule with it.
        $updateOwnArticle = $auth->createPermission(AccessControl::PERMISSION_UPDATE_OWN_ARTICLE);
        $updateOwnArticle->description = 'Update own article';
        $updateOwnArticle->ruleName = $rule->name;
        $auth->add($updateOwnArticle);

        // "updateOwnArticle" will be used from "updateArticle"
        $auth->addChild($updateOwnArticle, $updateArticle);

        //-------------------------- ROLES -------------------------------------
        // add "user" role
        $user = $auth->createRole(AccessControl::ROLE_USER);
        $user->description = 'Registered users, users of this site';
        $auth->add($user);

        // add "premium" role
        $premium = $auth->createRole(AccessControl::ROLE_PREMIUM);
        $premium->description = 'Premium users. They have more permissions than normal users';
        $auth->add($premium);
        $auth->addChild($premium, $usePremiumContent);

        // add "support" role
        // support can do everything that user and premium can, plus you can add him more powers
        $support = $auth->createRole(AccessControl::ROLE_SUPPORT);
        $support->description = 'Support staff';
        $auth->add($support);
        $auth->addChild($support, $premium);
        $auth->addChild($support, $user);

        // add "editor" role and give this role:
        // createArticle, updateOwnArticle and adminArticle permissions, plus he can do everything that support role can do.
        $editor = $auth->createRole(AccessControl::ROLE_EDITOR);
        $editor->description = 'Editor of this application';
        $auth->add($editor);
        $auth->addChild($editor, $support);
        $auth->addChild($editor, $createArticle);
        $auth->addChild($editor, $updateOwnArticle);
        $auth->addChild($editor, $adminArticle);

        // add "admin" role and give this role:
        // manageUsers, updateArticle adn deleteArticle permissions, plus he can do everything that editor role can do.
        $admin = $auth->createRole(AccessControl::ROLE_ADMIN);
        $admin->description = 'Administrator of this application';
        $auth->add($admin);
        $auth->addChild($admin, $editor);
        $auth->addChild($admin, $manageUsers);
        $auth->addChild($admin, $updateArticle);
        $auth->addChild($admin, $deleteArticle);

        // add "root" role ( this is you :) )
        // You can do everything that admin can do plus more (if You decide so)
        $root = $auth->createRole(AccessControl::ROLE_ROOT);
        $root->description = 'You!';
        $auth->add($root);
        $auth->addChild($root, $admin);

        if ($auth) {
            $this->stdout("\nRbac authorization data are installed successfully.\n", Console::FG_GREEN);
        }
    }
}