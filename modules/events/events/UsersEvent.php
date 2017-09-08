<?php

namespace app\modules\events\events;

use app\modules\users\models\UserModel;

class UsersEvent
{
	public static function afterLogin()
	{
		UserModel::updateAuthDate();
	}

	public static function userCreated($event)
	{
		//$user = $event->model;
		//die('The user '.$user->username.' has been created!');
	}

	public static function passwordChangedByAdmin($event)
	{
		//$user = $event->model;
		//die($user->password);
	}
}
