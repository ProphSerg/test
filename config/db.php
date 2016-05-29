<?php

return [
	'dbApi' => [
		'class' => 'yii\db\Connection',
		'dsn' => 'sqlite:' . dirname(__DIR__) . '/db/api.sqlite',
	],
	'dbRequest' => [
		'class' => 'yii\db\Connection',
		'dsn' => 'sqlite:' . dirname(__DIR__) . '/db/request.sqlite',
	],
];
