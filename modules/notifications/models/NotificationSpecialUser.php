<?php

namespace app\modules\notifications\models;

use Yii;
use app\modules\notifications\models\NotificationSpecial;

/**
 * This is the model class for table "notification_special_user".
 *
 * @property integer $id
 * @property integer $notification_id
 * @property integer $user_id
 */
class NotificationSpecialUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification_special_user';
    }

    public function getNotification()
    {
        return $this->hasOne(NotificationSpecial::className(), ['id' => 'notification_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['notification_id', 'user_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'notification_id' => 'Notification ID',
            'user_id' => 'User ID',
        ];
    }
}
