<?php

$params = require(__DIR__ . '/params.php');

$config = [
	'id' => 'UralsibPS',
	'name' => 'Сервисы Платежных систем',
	'language' => 'ru_RU',
	'sourceLanguage' => 'ru_RU',
	'timeZone' => 'Asia/Omsk',
	'basePath' => dirname(__DIR__),
	'bootstrap' => ['log', 'admin'],
	'aliases' => require(__DIR__ . '/aliases.php'),
	'defaultRoute' => 'request',
	'components' => [
		'request' => [
			// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
			'cookieValidationKey' => 'EoAXSKDv9v1mHfLT0zZmqsxDNjvGdBYa',
		],
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'user' => [
			#'identityClass' => 'app\models\User',
			'enableAutoLogin' => true,
			'identityClass' => 'mdm\admin\models\User',
			'loginUrl' => ['admin/user/login'],
		#'db' => 'dbSys',
		],
		'errorHandler' => [
			'errorAction' => 'site/error',
		],
		'mailer' => [
			'class' => 'yii\swiftmailer\Mailer',
			// send all mails to a file by default. You have to set
			// 'useFileTransport' to false and configure a transport
			// for the mailer to send real emails.
			#'useFileTransport' => true,
			'transport' => [
				'class' => 'Swift_SmtpTransport',
				'host' => 'oms-ln01.fc.uralsibbank.ru'
			],
		],
		'log' => [
			'flushInterval' => 1,
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets' => [
				[
					'exportInterval' => 10,
					'class' => 'yii\log\FileTarget',
					'levels' => ['error'],
					'categories' => [],
					'logFile' => '@app/runtime/logs/error.log',
					'logVars' => [],
					'maxFileSize' => 1024 * 2,
					'maxLogFiles' => 10,
				],
				[
					'exportInterval' => 10,
					#'class' => 'yii\log\FileTarget',
					'class' => 'app\common\myFileTarget',
					'categories' => ['api'],
					'levels' => ['info', 'warning'],
					'logFile' => '@app/runtime/logs/api.log',
					'logVars' => [],
					'maxFileSize' => 1024 * 2,
					'maxLogFiles' => 10,
				],
				[
					'exportInterval' => 10,
					'prefix' => false,
					'class' => 'app\common\myFileTarget',
					'categories' => ['api'],
					'levels' => ['trace'],
					'logFile' => '@app/runtime/logs/apiTrace.log',
					'logVars' => [],
					'maxFileSize' => 1024 * 2,
					'maxLogFiles' => 1,
				],
				[
					'exportInterval' => 10,
					'prefix' => false,
					'class' => 'app\common\myFileTarget',
					'categories' => ['parse'],
					'levels' => ['info', 'warning'],
					'logFile' => '@app/runtime/logs/parse.log',
					'logVars' => [],
					'maxFileSize' => 1024,
					'maxLogFiles' => 2,
				],
			],
		],
		'authManager' => [
			'class' => 'yii\rbac\DbManager',
			#'db' => 'dbSys',
		],
		/*
		  'as access' => [
		  'class' => 'mdm\admin\components\AccessControl',
		  'allowActions' => [
		  'admin/*',
		  ],
		  ],

		 */
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules' => [
				[
					'class' => 'yii\rest\UrlRule',
					'controller' => 'api',
					'only' => ['create'],
				],
				'request/detail/<id:\d+>' => 'request/detail',
				'request/add/<type:\d+>' => 'request/add',
				'request/print/<type:\w+>' => 'request/print',
				
			],
		],
	],
	'params' => $params,
	'modules' => [
		'admin' => [
			'class' => 'mdm\admin\Module',
			'layout' => '@app/views/layouts/rbac.php',
		],
		'gridview' => [
			'class' => '\kartik\grid\Module',
		],
	],
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
