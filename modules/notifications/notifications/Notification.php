<?php

namespace app\modules\notifications\notifications;

use Yii;
use yii\helpers\Url;
use yii\base\Component;
use app\modules\notifications\models\Notification as Model;
use app\modules\notifications\models\NotificationTemplate;

class Notification
{
	public static function run($params)
	{
		$notifications = Model::find()->all();
		$templates = self::getTemplates();


		foreach($notifications as $notification) {
			$instance = new $notification->class_name();
			$template = isset($templates[$notification->template_id]) ? $templates[$notification->template_id] : null;
			$instance->run($template['body'], $params);
		}
	}


	/**
	 * Список типов уведомлений для выпадающего списка
	 */
	public static function getClassNames()
	{
		$result = [];
		$namespace = 'app\modules\notifications\notifications\notifications\\';
		foreach (glob( __DIR__ . "/notifications/*.php") as $filename) {
			$path_info = pathinfo($filename);
			$className = $namespace.$path_info['filename'];
		    $result[$className] = call_user_func([$className, 'getTitle']);
		}
		return $result;
	}

	protected static function getTemplates()
	{
		$templates = NotificationTemplate::find()->all();
		$result = [];
		foreach($templates as $template) {
			$result[$template->id] = $template;
		}
		return $result;
	}

	/**
	 * Рендерит текст сообщения из шаблона (подставляем шаблонные переменные)
	 * @param string $template
	 * @param yii\db\ActiveRecord $user
	 * @param yii\db\ActiveRecord $news
	 * @return string
	 */
	public static function renderNotificationText($template, $user, $news = null)
	{
		$username = $user['username'];
		$site_url = Yii::$app->getUrlManager()->getBaseUrl();
		$new_link = Url::to(['/news/list/detail', 'id'=>$news ? $news->id : '']);
		$new_title = $news ? $news->title : '';
		$new_description = $news ? $news->preview : '';

		return strtr($template, [
			'{username}' => $username,
			'{site_url}' => $site_url,
			'{new-link}' => $new_link,
			'{new-title}' => $new_title,
			'{new-description}' => $new_description,
		]);
	}
}