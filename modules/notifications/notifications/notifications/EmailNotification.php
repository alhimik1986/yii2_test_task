<?php

namespace app\modules\notifications\notifications\notifications;

use Yii;
use yii\db\ActiveRecord;
use app\modules\notifications\notifications\NotificationInterface;
use app\modules\notifications\models\Notification as NotificationModel;
use app\modules\notifications\notifications\Notification;

class EmailNotification implements NotificationInterface
{
	public static function getTitle()
	{
		return 'E-mail';
	}

	public static function getDescription()
	{
		return 'Уведомление по электронной почте.';
	}

	/**
	 * @param string $template
	 * @param array $params Данные для вставки значений в шаблон
	 */
	public function run($template, $params)
	{
		$emailNotification = NotificationModel::findOne(['class_name'=> __CLASS__ ]);

		if ( ! $emailNotification)
			return;

		$users = isset($params['users']) ? $params['users'] : [];
		$newsModel = isset($params['newsModel']) ? $params['newsModel'] : null;

		foreach($users as $user) {
			$text = Notification::renderNotificationText($template, $user, $newsModel);
			$email = $user['email'];
			$companyName = Yii::$app->params['companyName'];

			Yii::$app->mailer->compose('@app/mail/layouts/html', ['content'=>$text])
			     ->setFrom([Yii::$app->params['adminEmail']=>$companyName])
			     ->setTo($email)
			     ->setSubject('Уведомление от '.$companyName)
			     ->send();
		}
	}
}
