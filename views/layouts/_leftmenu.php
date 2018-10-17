<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use app\assets\AppAsset;
use app\common\myMenuHelper;

if (isset(Yii::$app->controller->ControllerMenu)) {
	$items = myMenuHelper::getAssignedMenuByName(1, Yii::$app->controller->ControllerMenu);
} elseif (isset($this->params['LeftMenuItemsURL'])) {
	$items = $this->params['LeftMenuItemsURL'];
}

echo Nav::widget([
	'options' => ['class' => 'nav nav-pills nav-stacked'],
	'items' => $items,
]);
