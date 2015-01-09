<?php

namespace frontend\modules\site\models;

use yii\base\Model;
use frontend\modules\site\Module;
use Yii;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'email', 'subject', 'body', 'verifyCode'], 'required'],
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha', 'captchaAction' => '/site/index/captcha'],
        ];
    }

    /**
     * Returns the attribute labels.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name'       => Module::t('Name'),
            'email'      => Module::t('Email'),
            'subject'    => Module::t('Subject'),
            'body'       => Module::t('Text'),
            'verifyCode' => Module::t('Verification Code'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information
     * collected by this model.
     *
     * @param  string $email The target email address.
     * @return bool          Whether the email was sent.
     */
    public function contact($email)
    {
        return Yii::$app->mailer
            ->compose()
            ->setTo($email)
            ->setFrom([$this->email => $this->name])
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send()
        ;
    }
}
