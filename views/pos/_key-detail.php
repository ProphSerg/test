<?php

use kartik\detail\DetailView;
use yii\helpers\Html;
use yii\bootstrap\Collapse;
use app\models\pos\arKey;

if (!arKey::CanAccess()) {
	echo '';
	return;
}

$mode = DetailView::MODE_VIEW;
$key = $model->keys;
if ($key == null) {
	$key = new arKey();
	$key->Number = $model->KeyNum;
	$key->Check = $model->TMK_CHECK;
	$mode = DetailView::MODE_EDIT;
}

echo DetailView::widget([
	'model' => $key,
	'mode' => $mode,
	'hideIfEmpty' => false,
	'enableEditMode' => true,
	'panel' => [
		'heading' => 'Компоненты ключа: ' . $key->Number
		. ($key->Check != '' ? ', контрольная сумма: ' . $key->Check : ''),
		'type' => DetailView::TYPE_INFO,
		'headingOptions' => [
		#'type' => DetailView::TYPE_INFO,
		#'template' => '{title}',
		],
		#'footer' => '1234321',
		'footerOptions' => [
			#'template' => '{title}',
		],
	],
	'buttons1' => '{update}',
	'options' => [
		'id' => implode('-', ['dvKey', $model->KeyNum]),
	],
	'attributes' => [
		[
			'attribute' => 'Comp1',
		],
		[
			'attribute' => 'Comp2',
		],
		[
			'attribute' => 'Comp3',
		],
		[
			'attribute' => 'Check',
			'visable' => false,
		],
		
	],
]);
