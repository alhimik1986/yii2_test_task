<?php

namespace app\modules\users;

/**
 * users module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $defaultRoute = 'user/index';
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\users\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
