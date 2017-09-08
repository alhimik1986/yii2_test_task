<?php

namespace app\modules\notifications\models;

use Yii;
use app\modules\users\models\UserModel;
use app\modules\notifications\models\Notification;
use app\modules\notifications\models\NotificationSpecialUser;

/**
 * This is the model class for table "notification_special".
 *
 * @property integer $id
 * @property integer $notification_type_id
 * @property string $title
 * @property string $body
 */
class NotificationSpecial extends \yii\db\ActiveRecord
{
    public $users;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification_special';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['body'], 'required'],
            [['notification_type_id'], 'integer'],
            [['body'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['users'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'notification_type_id' => 'Тип уведомления',
            'title' => 'Название',
            'body' => 'Текст уведомления',
            'users' => 'Пользователи',
        ];
    }

    /**
     * @inheritdoc
     */
     public function beforeSave($insert) {
        if ($insert AND ( ! $this->users OR ! is_array($this->users))) {
            $this->addError('users', 'Выберите пользователей.');
            return false;
        }

        return parent::beforeSave($insert);
     }

    /**
     * @inheritdoc
     */
     public function afterSave($insert, $changedAttributes) {
        if ($insert AND $this->users and is_array($this->users)) {

            $users = array_keys($this->users);

            foreach($users as $user_id) {
                $model = new NotificationSpecialUser;
                $model->user_id = $user_id;
                $model->notification_id = $this->id;
                $model->save();

                if ($model->hasErrors()) {
                    foreach($model->getErrors() as $errors) {
                        foreach($errors as $error) {
                            $this->addError('body', $error);
                        }
                    }
                }
            }
        }

        return parent::afterSave($insert, $changedAttributes);
     }

    /**
     * Список всех пользователей, сгруппированных по ролям
     */
    public static function getUsers()
    {
        $result = [];
        $users = UserModel::find()
            ->andWhere(['status'=>UserModel::STATUS_ACTIVE])
            ->with('role')
            ->asArray()
            ->all();

        // Список всех ролей
        $roles = [];
        $roleList = Yii::$app->authManager->getRoles();
        foreach($roleList as $roleName=>$role) {
            $roles[$roleName] = $role->description;
        }

        foreach($users as $user) {
            if (count($user['role'])) {
                foreach($user['role'] as $role) {
                    $roleName = $roles[$role['item_name']];
                    $result[$roleName][$user['id']] = $user;
                }
            }
        }
        foreach($users as $user) {
            if ( ! count($user['role'])) {
                $roleName = 'Без роли';
                $result[$roleName][$user['id']] = $user;
            }
        }

        return $result;
    }

    /**
     * Список типов уведомлений для выпадающего списка
     */
    public static function getNotificationTypes()
    {
        $result = [];
        $notifications = Notification::find()->all();

        foreach($notifications as $notification) {
            $result[$notification->id] = $notification->title;
        }

        return $result;
    }
}
