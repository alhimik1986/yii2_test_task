<?php

namespace app\modules\users\models;

use Yii;
use yii\base\Model;
use app\modules\users\models\UserModel as User;

class RegistrationForm extends Model
{
    public $username;
    public $password;
    public $confirm_password;
    public $email;
    public $full_name;


    public function rules()
    {
        return [
            [['username', 'password', 'confirm_password', 'email', 'full_name'], 'required'],
            [['username', 'password', 'confirm_password', 'email', 'full_name'], 'string', 'max'=>255],
            [['confirm_password'], 'validateConfirmPassword'],
            ['email', 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'password' => 'Пароль',
            'confirm_password' => 'Подтвердить пароль',
            'email' => 'E-mail',
            'full_name' => 'ФИО',
        ];
    }


    public function validateConfirmPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if ($this->confirm_password) {
                if ($this->password !== $this->confirm_password) {
                    $this->addError($attribute, 'Подтверждение не совпадает с паролем.');
                }
            }
        }
    }

    public function register()
    {
        if ($this->validate()) {
            $model = new User;
            $model->attributes = $this->attributes;
            $model->status = User::STATUS_UNCONFIRMED;
            if ($model->hasErrors()) {
                //print_r($model->getErrors()); die();
                foreach($model->getErrors() as $field=>$errors) {
                    foreach($errors as $error) {
                        if (array_key_exists($field, $this)) {
                            $this->addError($field, $error);
                        } else {
                            $this->addError('password', $error);
                        }
                    }
                }
            }

            $result = $model->save();

            if ($result) {
                Yii::$app->authManager->assign(Yii::$app->authManager->getRole('user'), $model->id);
            }
            
            return $result;
        }
        return false;
    }
}
