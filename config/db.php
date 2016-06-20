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
		'dsn' => 'sqlite:' . dirname(__DIR__) . '/db/system.sqlite',
	],
	'dbRequest' => [
		'class' => 'yii\db\Connection',
		'dsn' => 'sqlite:' . dirname(__DIR__) . '/db/request.sqlite',
	],
	'dbATM' => [
		'class' => 'yii\db\Connection',
		'dsn' => 'sqlite:' . dirname(__DIR__) . '/db/atm.sqlite',
	],
];
