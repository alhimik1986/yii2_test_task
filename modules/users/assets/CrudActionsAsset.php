<?php

namespace app\modules\users\assets;

use yii\web\AssetBundle;

class CrudActionsAsset extends AssetBundle
{
	public function init()
	{
		parent::init();
		
		$this->sourcePath  = realpath( __DIR__ .'/js/crud-actions');
		
		$this->js = [
			'crud-actions.js',
		];
		
		$this->depends = self::$defaultDepends;
	}
	
	public static $defaultDepends = ['yii\web\JqueryAsset'];
}
