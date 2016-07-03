<?php

return [
	/*
	'db' => [
		'class' => 'yii\db\Connection',
		'dsn' => 'sqlite:' . dirname(__DIR__) . '/db/system.sqlite',
	],
	*/ 
	'dbSys' => [
		'class' => 'yii\db\Connection',
		'dsn' => 'sqlite:@dbs/system.sqlite',
	],
	'dbRequest' => [
		'class' => 'yii\db\Connection',
		'dsn' => 'sqlite:@dbs/request.sqlite',
	],
	'dbATM' => [
		'class' => 'yii\db\Connection',
		'dsn' => 'sqlite:@dbs/atm.sqlite',
	],
];
