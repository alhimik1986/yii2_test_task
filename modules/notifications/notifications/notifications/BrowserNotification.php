<?php

namespace app\modules\notifications\notifications\notifications;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\notifications\notifications\NotificationInterface;
use app\modules\notifications\models\Notification as NotificationModel;
use app\modules\notifications\notifications\Notification;
use app\modules\notifications\models\NotificationSpecialUser;
use app\modules\notifications\models\SpecialNotifier;
use app\modules\notifications\models\NewsNotifier;
use app\modules\notifications\models\NotificationTemplate;
use app\modules\news\models\News;
use app\modules\users\models\UserModel;

class BrowserNotification implements NotificationInterface
{
	public static function getTitle()
	{
		return 'Браузер';
	}

	public static function getDescription()
	{
		return 'Уведомление в виде всплывающего сообщения (alert) в браузере.';
	}

	/**
	 * @param string $template
	 * @param array $params Данные для вставки значений в шаблон
	 */
	public function run($template, $params)
	{
		//echo 'browser';
	}


	/**
	 * Выводить уведомление в alert браузера. Запускается из app\modules\events\components\Events.
	 */
	public static function alertNotifications()
	{
		if (Yii::$app->user->isGuest OR Yii::$app->session->getAllFlashes())
			return;

		$browserNotification = NotificationModel::findOne(['class_name'=> __CLASS__ ]);

		if ( ! $browserNotification)
			return;

		$user = self::getUserByRole('user');

		if ($user) {
			$template = NotificationTemplate::findOne(['id'=>$browserNotification->template_id]);
			$news = NewsNotifier::getLastNews();

			foreach($news as $newsModel) {
				$text = Notification::renderNotificationText($template->body, $user, $newsModel);
				$text .= '<br>';
				$text .= self::iKnowButton();
				Yii::$app->session->addFlash('success', $text);
			}
		}

		// Уведомление партнеров в браузере производится вне зависимости от роли пользователя
		$user = $user ? $user : self::getUser();
		self::alertSpecialNotifications($user, $browserNotification);
	}

	/**
	 * Выводить уведомления выбранным пользователям в alert браузера
	 */
	protected static function alertSpecialNotifications($user, $browserNotification)
	{
		$notifications = SpecialNotifier::getUserNotifications($browserNotification->id);

		foreach($notifications as $notification) {
			$template = $notification ? $notification['body'] : '';
			$text = Notification::renderNotificationText($template, $user);
			$text .= '<br>';
			$text .= self::iKnowButton();
			Yii::$app->session->addFlash('success', $text);
		}

	}

	protected static function iKnowButton()
	{
		return Html::a('Я в курсе всех новостей', ['/news/list/i-know'], [
			'class' => 'btn btn-success',
			'style' => 'margin-top: 10px;',
		]);
	}

	protected static function getUserByRole($roleName)
	{
		$user = UserModel::find()
			->with('role')
			->andWhere(['id' => Yii::$app->user->identity->id])
			->one();

		$roleIsUser = false;

		foreach($user->role as $role) {
			if ($role['item_name'] == $roleName)
				$roleIsUser = true;
		}

		return $roleIsUser ? $user : null;
	}

	protected static function getUser()
	{
		$user = UserModel::find()
			->andWhere(['id' => Yii::$app->user->identity->id])
			->one();

		return $user;
	}
}
