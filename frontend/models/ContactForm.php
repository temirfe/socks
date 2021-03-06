<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

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
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['email', 'body'], 'required'],
            [['name', 'subject'], 'string'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Введите код с картины',
            'name' => 'Имя',
            'body' => 'Сообщение',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail($email)
    {
        /*return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([$this->email => $this->name])
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();*/
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom(['info@prestigesocks.kg' => 'Prestige Socks'])
            ->setSubject('Пользователь отпрвил письмо')
            ->setTextBody('Имя: '.$this->name.'
            E-mail: '.$this->email.'
            Сообщение: '.$this->body)
            ->send();
    }
}
