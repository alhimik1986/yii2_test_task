<?php

namespace app\modules\events\components;

use Yii;
use yii\base\Component;

// https://stackoverflow.com/a/27180098
/**
 * В этом классе мы будем слушать все события. Поскольку события триггерятся в разных местах,
 * а если они еще будут слушаться в разных местах, то поиск ошибок в событиях будет осложнен.
 * Поэтому все события будем слушать из одного места, т.е. здесь.
 */
class Events extends Component
{
    public function init() {

    	// Пользователь авторизовался
    	Yii::$app->user->on(yii\web\User::EVENT_AFTER_LOGIN, ['app\modules\events\events\UsersEvent', 'afterLogin']);

    	// Создан новый пользователь
    	Yii::$app->usersEvents->on(Yii::$app->usersEvents::EVENT_USER_CREATED, ['app\modules\events\events\UsersEvent', 'userCreated']);

    	// Администратор сменил пароль пользователю
    	Yii::$app->usersEvents->on(Yii::$app->usersEvents::EVENT_PASSWORD_CHANGED_BY_ADMIN, ['app\modules\events\events\UsersEvent', 'passwordChangedByAdmin']);

    	// Новость опубликована (статус изменился на активный)
    	Yii::$app->newsEvents->on(Yii::$app->newsEvents::EVENT_NEWS_PUBLISHED, ['app\modules\events\events\NewsEvent', 'newsPublished']);

    	// Авторизованный пользователь посетил страницу новостей
    	Yii::$app->newsEvents->on(Yii::$app->newsEvents::EVENT_NEWS_LIST_VISITED, ['app\modules\events\events\NewsEvent', 'newsListVisited']);

        // Пользователь зашел на сайт (запускаю уведомления браузера)
        \app\modules\notifications\notifications\notifications\BrowserNotification::alertNotifications();


        parent::init();
    }
}