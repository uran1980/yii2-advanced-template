<?php

namespace frontend\modules\profile\controllers;

use common\components\controllers\FrontendController;
use common\models\User;
use common\models\LoginForm;
use frontend\modules\profile\Module;
use frontend\modules\profile\models\ProfileActivation;
use frontend\modules\profile\models\PasswordResetRequestForm;
use frontend\modules\profile\models\ResetPasswordForm;
use frontend\modules\profile\models\SignupForm;
use yii\helpers\Html;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use common\rbac\AccessControl;
use Yii;

class IndexController extends FrontendController
{
    /**
     * Returns a list of behaviors that this component should behave as.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions'   => ['signup'],
                        'allow'     => true,
                        'roles'     => ['?'],
                    ],
                    [
                        'actions'   => ['logout'],
                        'allow'     => true,
                        'roles'     => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Displays the index (home) page.
     * Use it in case your home page contains static content.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


// -----------------------------------------------------------------------------
//                      LOG IN / LOG OUT / PASSWORD RESET
// -----------------------------------------------------------------------------

    /**
     * Logs in the user if his profile is activated,
     * if not, displays appropriate message.
     *
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        // get setting value for 'Login With Email'
        $lwe = Yii::$app->params['LoginWithEmail'];

        // if 'LoginWithEmail' value is 'true' we instantiate LoginForm in 'LoginWithEmail' scenario
        $model = $lwe ? new LoginForm(['scenario' => 'LoginWithEmail']) : new LoginForm();

        // now we can try to log in the user
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            AccessControl::checkRoleAssignment();

            return $this->goBack();
        }
        // user couldn't be logged in, because he has not activated his profile
        else if($model->notActivated()) {
            // if his profile is not activated, he will have to activate it first
            Yii::$app->session->setFlash('error', Module::t('You have to activate your profile first. Please check your email.'));

            return $this->refresh();
        }
        // profile is activated, but some other errors have happened
        else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the user.
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

/*----------------*
 * PASSWORD RESET *
 *----------------*/

    /**
     * Sends email that contains link for password reset action.
     *
     * @return string|\yii\web\Response
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', Module::t('Check your email for further instructions.'));

                return $this->goHome();
            }
            else {
                Yii::$app->getSession()->setFlash('error', Module::t('Sorry, we are unable to reset password for email provided.'));
            }
        }
        else
        {
            return $this->render('requestPasswordResetToken', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Resets password.
     *
     * @param  string $token Password reset token.
     * @return string|\yii\web\Response
     *
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        }
        catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ( $model->load(Yii::$app->request->post())
             && $model->validate() && $model->resetPassword() )
        {
            Yii::$app->getSession()->setFlash('success', Module::t('New password was saved.'));

            return $this->goHome();
        }
        else {
            return $this->render('resetPassword', [
                'model' => $model,
            ]);
        }
    }

// -----------------------------------------------------------------------------
//                          SIGN UP / PROFILE ACTIVATION
// -----------------------------------------------------------------------------

    /**
     * Signs up the user.
     * If user need to activate his profile via email, we will display him
     * message with instructions and send him profile activation email
     * ( with link containing profile activation token ). If activation is not
     * necessary, we will log him in right after sign up process is complete.
     * NOTE: You can decide whether or not activation is necessary,
     * @see config/params.php
     *
     * @return string|\yii\web\Response
     */
    public function actionSignup()
    {
        // get setting value for 'Registration Needs Activation'
        $RegistrationNeedsActivation = Yii::$app->params['RegistrationNeedsActivation'];

        // if 'RegistrationNeedsActivation' value is 'true', we instantiate SignupForm in 'RegistrationNeedsActivation' scenario
        $model = $RegistrationNeedsActivation ? new SignupForm(['scenario' => 'RegistrationNeedsActivation']) : new SignupForm();

        // collect and validate user data
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // try to save user data in database
            if ( ($user = $model->signup()) ) {
                // if user is active he will be logged in automatically ( this will be first user )
                if ($user->status === User::STATUS_ACTIVE) {
                    if (Yii::$app->getUser()->login($user)) {
                        return $this->goHome();
                    }
                }
                // activation is needed, use signupWithActivation()
                else {
                    $this->signupWithActivation($model, $user);

                    return $this->refresh();
                }
            }
            // user could not be saved in database
            else {
                // display error message to user
                Yii::$app->session->setFlash('error',
                    "We couldn't sign you up, please contact us.");

                // log this error, so we can debug possible problem easier.
                Yii::error(Mosule::t('Signup failed!') . ' '
                    . Module::t('User {user} could not sign up.', ['user' => Html::encode($user->username)]) . ' '
                    . Module::t('Possible causes: something strange happened while saving user in database.'));

                return $this->refresh();
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Sign up user with activation.
     * User will have to activate his profile using activation link that we will
     * send him via email.
     *
     * @param $model
     * @param $user
     */
    private function signupWithActivation($model, $user)
    {
        // try to send profile activation email
        if ($model->sendProfileActivationEmail($user)) {
            Yii::$app->session->setFlash('success', Module::t('Hello {user}.', ['user' => Html::encode($user->username)]) . ' '
                . Module::t('To be able to log in, you need to confirm your registration.') . ' '
                . Module::t('Please check your email, we have sent you a message.'));
        }
        // email could not be sent
        else {
            // display error message to user
            Yii::$app->session->setFlash('error', Module::t("We couldn't send you profile activation email, please contact us."));

            // log this error, so we can debug possible problem easier.
            Yii::error(Module::t('Signup failed!') . ' '
                . Module::t('User {user} could not sign up.', ['user' => Html::encode($user->username)]) . ' '
                . Module::t('Possible causes: verification email could not be sent.'));
        }
    }

/*--------------------*
 * PROFILE ACTIVATION *
 *--------------------*/

    /**
     * Activates the user profile so he can log in into system.
     *
     * @param  string $token
     * @return \yii\web\Response
     *
     * @throws BadRequestHttpException
     */
    public function actionActivateProfile($token)
    {
        try
        {
            $user = new ProfileActivation($token);
        }
        catch (InvalidParamException $e)
        {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($user->activateProfile())
        {
            Yii::$app->getSession()->setFlash('success', Module::t('Success! You can now log in.') . ' '
                . Module::t('Thank you {user} for joining us!', ['user' => Html::encode($user->username)]));
        }
        else
        {
            Yii::$app->getSession()->setFlash('error', Module::t('Sorry, {user} your profile could not be activated, please contact us!', [
                'user' => Html::encode($user->username),
            ]));
        }

        return $this->redirect('/login');
//        return $this->redirect('login');
    }


}
