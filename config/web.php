<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'UralsibPS',
    'name' => 'Сервисы Платежных систем',
    'language' => 'ru_RU',
    'sourceLanguage' => 'ru_RU',
    'timeZone' => 'Asia/Omsk',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
	'request' => [
	    // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
	    'cookieValidationKey' => 'EoAXSKDv9v1mHfLT0zZmqsxDNjvGdBYa',
	],
	'cache' => [
	    'class' => 'yii\caching\FileCache',
	],
	'user' => [
	    'identityClass' => 'app\models\User',
	    'enableAutoLogin' => true,
	],
	'errorHandler' => [
	    'errorAction' => 'site/error',
	],
	'mailer' => [
	    'class' => 'yii\swiftmailer\Mailer',
	    // send all mails to a file by default. You have to set
	    // 'useFileTransport' to false and configure a transport
	    // for the mailer to send real emails.
	    'useFileTransport' => true,
	],
	'log' => [
	    'flushInterval' => 1,
	    'traceLevel' => YII_DEBUG ? 3 : 0,
	    'targets' => [
		[
		    'exportInterval' => 10,
		    'class' => 'yii\log\FileTarget',
		    'levels' => ['error'],
		    'categories' => ['api'],
		    'logFile' => '@app/runtime/logs/apiError.log',
		    'logVars' => [],
		    'maxFileSize' => 1024 * 2,
		    'maxLogFiles' => 10,
		],
		[
		    'exportInterval' => 10,
		    'class' => 'yii\log\FileTarget',
		    'categories' => ['api'],
		    'levels' => ['info', 'warning'],
		    'logFile' => '@app/runtime/logs/api.log',
		    'logVars' => [],
		    'maxFileSize' => 1024 * 2,
		    'maxLogFiles' => 10,
		],
	    ],
	],
	'urlManager' => [
	    'enablePrettyUrl' => true,
	    'showScriptName' => false,
	    'rules' => [
		[
		    'class' => 'yii\rest\UrlRule',
		    'controller' => 'api',
		    'only' => ['create'],
		],
	    ],
	],
    ],
    'params' => $params,
];
foreach (require(__DIR__ . '/db.php') as $d => $c) {
#	$config['components'][] = $d;
    $config['components'][$d] = $c;
}
#var_dump($config);

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
	'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
	'class' => 'yii\gii\Module',
    ];
}

return $config;
