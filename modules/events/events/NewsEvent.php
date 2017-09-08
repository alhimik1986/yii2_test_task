<?php

namespace app\modules\events\events;

use Yii;
use app\modules\users\models\UserModel;
use app\modules\notifications\notifications\Notification;

class NewsEvent
{
    public static function newsPublished($event) {
        //Yii::trace('Мое сообщение');
        //$newsModel = $event->model;

        Notification::run([
            'users'=>UserModel::getUsersByRole('user'),
            'newsModel'=>$event->model,
        ]);
    }

    public static function newsListVisited() {
        
    }
}
