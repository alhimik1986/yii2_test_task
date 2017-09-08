<?php

namespace app\modules\users\models;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;
use yii\web\User as WebUser;
use app\modules\users\models\UserModel;

/**
 * User identity
 *
  */
class User implements IdentityInterface
{
    public $id;
    public $username;
    public $password_hash;
    public $authKey;
    public $accessToken;

    public function setModelAttributes($model)
    {
        if ( ! $model)
            return;

        $this->id = $model->getPrimaryKey();
        $this->username = $model->username;
        $this->password_hash = $model->password_hash;
        $this->authKey = $model->auth_key;
        //$this->accessToken = $model->accessToken;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $model = UserModel::findOne(['id' => $id, 'status' => UserModel::STATUS_ACTIVE]);
        $identity = new static();
        $identity->setModelAttributes($model);
        return $identity;
    }
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $model = UserModel::findOne(['username' => $username, 'status' => UserModel::STATUS_ACTIVE]);
        
        if ( ! $model)
            return null;

        $identity = new static();
        $identity->setModelAttributes($model);
        return $identity;
    }
    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }
        $model = UserModel::findOne([
            'password_reset_token' => $token,
            'status' => UserModel::STATUS_ACTIVE,
        ]);

        $identity = new static();
        $identity->setModelAttributes($model);
        return $identity;
    }
    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }
    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
}