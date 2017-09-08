<?php

namespace app\modules\users\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use app\modules\users\events\UserEvent;

/**
 * User model
 * 
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property string $full_name
 * @property integer $auth_at
 * @property string $email_confirm_token
 *
  */
class UserModel extends ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const STATUS_UNCONFIRMED = 20;

    public $password;
    private $_roles;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * 
     */
    public function getRole()
    {
        return $this->hasMany(AuthAssignment::className(), ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'full_name'], 'required'],
            [['password'], 'required', 'on'=>'create'],
            [['username', 'password', 'email', 'full_name'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['email'], 'unique'],

            [['roles'], 'in', 'range'=>array_keys(Yii::$app->authManager->getRoles()), 'allowArray' => true],

            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED, self::STATUS_UNCONFIRMED]],
            
            ['email', 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Имя пользователя',
            'password' => 'Пароль',
            'email' => 'E-mail',
            'full_name' => 'ФИО',
            'status' => 'Статус',
            'statusHtml' => 'Статус',
            'roles' => 'Роли',
            'rolesListHtml' => 'Роли',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
            'auth_at' => 'Авторизован',
            'role' => 'Роль',
        ];
    }

    public static function statuses() {
        return [
            self::STATUS_ACTIVE=>'Активен',
            self::STATUS_UNCONFIRMED=>'Не подтвержден',
            self::STATUS_DELETED=>'Удален',
        ];
    }

    /**
     * @inheritdoc
     */
     public function beforeSave($insert) {
        if ($this->isNewRecord AND $this->status == self::STATUS_UNCONFIRMED) {
            $this->generateEmailConfirmToken();
        }

        if ($this->password) {
            $this->setPassword($this->password);
        }

        return parent::beforeSave($insert);
     }

    /**
     * @inheritdoc
     */
     public function afterSave($insert, $changedAttributes) {
        if (is_array($this->_roles)) {
            Yii::$app->authManager->revokeAll($this->id);

            foreach($this->_roles as $roleName) {
                $role = Yii::$app->authManager->getRole($roleName);
                Yii::$app->authManager->assign($role, $this->id);
            }
        }

        // Событие: создан новый пользователь
        if ($insert) {
            $event = new UserEvent;
            $event->model = $this;
            Yii::$app->usersEvents->trigger(Yii::$app->usersEvents::EVENT_USER_CREATED, $event);
        } else if ($this->password AND Yii::$app->user->identity->id != $this->id) {
            $event = new UserEvent;
            $event->model = $this;
            Yii::$app->usersEvents->trigger(Yii::$app->usersEvents::EVENT_PASSWORD_CHANGED_BY_ADMIN, $event);
        }

        return parent::afterSave($insert, $changedAttributes);
     }

    /**
     * @inheritdoc
     */
     public function beforeDelete() {
        Yii::$app->authManager->revokeAll($this->id);
        return parent::beforeDelete();
     }


    /**
     * Generates email confirm token
     */
    protected function generateEmailConfirmToken()
    {
        $this->email_confirm_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Подтверждение электронной почты
     */
    public static function confirmEmail($token)
    {
        $model = static::findOne(['email_confirm_token' => $token, 'status' => self::STATUS_UNCONFIRMED]);

        if ($model) {
            $model->email_confirm_token = null;
            $model->status = self::STATUS_ACTIVE;
            return $model->validate() && $model->save();
        }
        return false;
    }


    /**
     * Сохраняет дату авторизации
     */
    public static function updateAuthDate()
    {
        if (Yii::$app->user->isGuest) {
            return;
        }
        $identity = Yii::$app->user->identity;
        $model = self::findOne(['id'=>$identity->id]);
        $model->auth_at = time();
        $model->validate() AND $model->save();
    }
    /**
     * Геттер для свойства "roles". Список ролей, которые назначены пользователю.
     * @return  string[]
     */
    public function getRoles()
    {
        if ($this->_roles === null) {
            $roles = Yii::$app->authManager->getRolesByUser($this->id);
            return array_keys($roles);
        } else {
            return $this->_roles;
        }
    }
    /**
     * Сеттер для свойства "roles". Присваивает роли пользователю.
     */
    public function setRoles($roles)
    {
        $this->_roles = $roles;
    }
    /**
     * Геттер для свойства "roleList". Список ролей, которые назначены пользователю.
     * @return  yii\rbac\Role[]
     */
    public function getRoleList()
    {
        if ($this->_roles === null) {
            $roles = Yii::$app->authManager->getRolesByUser($this->id);
            return $roles;
        } else {
            $roles = [];
            foreach($this->_roles as $roleName) {
                $roles[] = Yii::$app->authManager->getRole($roleName);
            }
            return $roles;
        }
    }
    /**
     * Геттер для свойства "rolesListHtml". Список ролей, которые назначены пользователю.
     * @return string
     */
    public function getRolesListHtml() {
        $roles = $this->roleList;
        $result = [];
        foreach($roles as $role) {
            $result[] = $role->description;
        }
        return implode(', ', $result);
    }
    /**
     * Геттер для свойства "statusHtml"
     * @return string
     */
    public function getStatusHtml() {
        $statuses = self::statuses();
        return isset($statuses[$this->status]) ? $statuses[$this->status] : $this->status;
    }


    /**
     * Список ролей для выпадающего списка
     * @return array
     */
    public static function getRolesDropDownList() {
        $result = [];
        $roles = Yii::$app->authManager->getRoles();
        foreach($roles as $roleName=>$role) {
            $result[$roleName] = $role->description;
        }
        return $result;
    }


    /**
     * Список всех пользователей с указанной ролью
     * @param string $roleName
     * @return array
     */
    public static function getUsersByRole($roleName)
    {
        $rows = self::find()
            ->with('role')
            ->andWhere(['status'=>self::STATUS_ACTIVE])
            ->asArray()
            ->all();

        $users = [];

        foreach($rows as $key => $user) {
            $roleIsUser = false;
            foreach($user['role'] as $role) {
                if ($role['item_name'] == $roleName)
                    $roleIsUser = true;
            }
            if ($roleIsUser) {
                $users[] = $user;
            }
        }

        return $users;
    }
}