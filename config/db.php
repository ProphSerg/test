<?php

return [
	/*
	  'db' => [
	  'class' => 'yii\db\Connection',
	  'dsn' => 'sqlite:' . dirname(__DIR__) . '/db/system.sqlite',
	  ],
	 */
	'db' => [
		'class' => 'yii\db\Connection',
		'dsn' => 'sqlite:@dbs/system.sqlite',
	],
	'dbApi' => [
		'class' => 'yii\db\Connection',
		'dsn' => 'sqlite:@dbs/api.sqlite',
		'on afterOpen' => function ($event) {
			$event->sender->createCommand('PRAGMA foreign_keys = ON;');
		},
	],
	'dbRequest' => [
		'class' => 'yii\db\Connection',
		'dsn' => 'sqlite:@dbs/request.sqlite',
		'on afterOpen' => function ($event) {
			$event->sender->createCommand('PRAGMA foreign_keys = ON;');
		},
	],
	'dbATM' => [
		'class' => 'yii\db\Connection',
		'dsn' => 'sqlite:@dbs/atm.sqlite',
		'on afterOpen' => function ($event) {
			$event->sender->createCommand('PRAGMA foreign_keys = ON;');
		},
	],
	'dbKey' => [
		'class' => 'yii\db\Connection',
		'dsn' => 'sqlite:@dbs/key.sqlite',
	],
	'dbPos' => [
		'class' => 'yii\db\Connection',
		'dsn' => 'sqlite:@dbs/pos.sqlite',
		'on afterOpen' => function ($event) {
			$event->sender->createCommand('PRAGMA foreign_keys = ON;');
		},
	],
];
