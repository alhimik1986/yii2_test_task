<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
	'language' => 'ru-RU',
    'bootstrap' => ['log', 'events'],
    'defaultRoute' => '/news/list/index',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'ylmOG2vihcbSAdXlsxoMngKSLM0J_nXB',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\modules\users\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/users/sign/in'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true, // Нужно выставить false, если вводишь реальные данные
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.mail.ru',
                'username' => 'account@mail.ru',
                'password' => 'mypassword',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],

        // RBAC
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],

        // Задаю формат чисел даты-времени
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'datetimeFormat' => 'dd.MM.yyyy H:i:s',
            'dateFormat' => 'dd.MM.yyyy',
            'decimalSeparator' => '.',
            'thousandSeparator' => ' ',
            //'currencyCode' => 'EUR',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

// Добавляю генератор кода ajax_form_crud
if (YII_ENV_DEV) {
	$config['modules']['gii']['generators']['ajax_form_crud_generator'] = [
		'class' => 'alhimik1986\yii2_crud_module\generators\crud\Generator',
		'templates' => [
			'ajax_form_template' => '@vendor/alhimik1986/yii2_crud_module/generators/crud/default',
		],
	];
}


//------------------------------
// Подключаю модули приложения -
//------------------------------

// Модуль для привязки всех событий
$config['components']['events'] = ['class'=>'app\modules\events\components\Events'];

// Модуль пользователей
$config['modules']['users']['class'] = 'app\modules\users\Module';
$config['components']['usersEvents'] = ['class'=>'app\modules\users\components\UsersEvents'];

// Модуль новостей
$config['modules']['news']['class'] = 'app\modules\news\Module';
$config['components']['newsEvents'] = ['class'=>'app\modules\news\components\NewsEvents'];

// Модуль уведомлений
$config['modules']['notifications']['class'] = 'app\modules\notifications\Module';


return $config;
