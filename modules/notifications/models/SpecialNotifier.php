<?php

namespace app\modules\notifications\models;

use Yii;

class SpecialNotifier
{
    /**
     * Получает список всех последних новостей, которые появились с момента 
     * последнего просмотра ленты новостей
     * @param integer $notification_type_id
     * @return array
     */
    public static function getUserNotifications($notification_type_id)
    {
        if (Yii::$app->user->isGuest) {
            return [];
        }

        $user_id = Yii::$app->user->identity->id;

        $userNotifications = NotificationSpecialUser::find()
            ->andWhere(['user_id' => $user_id])
            ->asArray()
            ->with('notification')
            ->all();

        $result = [];
        foreach($userNotifications as $userNote) {
            $notification = $userNote['notification'];
            if ( ! $notification)
                continue;

            if ($notification['notification_type_id'] != $notification_type_id)
                continue;

            $result[] = $notification;
        }

        return $result;
    }

    /**
     * Запомнить последнюю новость
     * @return boolean Успешность операции
     */
    public static function resetUserNotifications()
    {
        if (Yii::$app->user->isGuest)
            return;

        $user_id = Yii::$app->user->identity->id;
        $models = NotificationSpecialUser::find()->andWhere(['user_id' => $user_id])->all();
        foreach($models as $model) {
            $model->delete();
        }
    }
}
