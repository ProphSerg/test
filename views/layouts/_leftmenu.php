<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use app\assets\AppAsset;
use app\common\myMenuHelper;

if (isset(Yii::$app->controller->ControllerMenu)) {
	echo Nav::widget([
		'options' => ['class' => 'nav nav-pills nav-stacked'],
		'items' => myMenuHelper::getAssignedMenuByName(Yii::$app->user->id, Yii::$app->controller->ControllerMenu),
	]);
} elseif (isset($this->params['LeftMenuItemsURL'])) {
	echo Nav::widget([
		'options' => ['class' => 'nav nav-pills nav-stacked'],
		'items' => $this->params['LeftMenuItemsURL'],
	]);
}
