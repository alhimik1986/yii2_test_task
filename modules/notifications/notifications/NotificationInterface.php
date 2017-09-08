<?php

namespace app\modules\notifications\notifications;


interface NotificationInterface
{
	public static function getTitle();
	public static function getDescription();
	public function run($template, $params);
}