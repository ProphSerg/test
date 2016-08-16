<?php

use kartik\detail\DetailView;
use app\models\pos\arKey;
use app\assets\ClipboardAsset;
use app\common\Convert;
use app\common\KeyCheck;

if (!arKey::CanAccess()) {
	echo '';
	return;
}


#echo 'key-detail';

echo DetailView::widget([
	'model' => $key,
	'mode' => DetailView::MODE_VIEW,
	'hideIfEmpty' => false,
	'enableEditMode' => false,
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
	/*
	  'options' => [
	  'id' => implode('-', ['dvKey', $key->Number]),
	  ],
	 * 
	 */
	'rowOptions' => ['style' => 'font-size: 12px'],
	'attributes' => [
		[
			'attribute' => 'Comp1',
			'valueColOptions' => ['style' => 'font-family: monospace; font-size: 14px;'],
			'format' => 'raw',
			'value' => ClipboardAsset::buttonCopyText($key->Comp1, $key->Number . 'Comp1') .
			'<p>' . Convert::KeyByGroup($key->Comp1) .
			' (Check: <b>' . KeyCheck::KCV($key->Comp1) . '</b>)',
		],
		[
			'valueColOptions' => ['style' => 'font-family: monospace; font-size: 14px;'],
			'attribute' => 'Comp2',
			'format' => 'raw',
			'value' => ClipboardAsset::buttonCopyText($key->Comp2, $key->Number . 'Comp2') .
			'<p>' . Convert::KeyByGroup($key->Comp2) .
			' (Check: <b>' . KeyCheck::KCV($key->Comp2) . '</b>)',
		],
		[
			'attribute' => 'Comp3',
			'valueColOptions' => ['style' => 'font-family: monospace; font-size: 14px;'],
			'format' => 'raw',
			'value' => ClipboardAsset::buttonCopyText($key->Comp3, $key->Number . 'Comp3') .
			'<p>' . Convert::KeyByGroup($key->Comp3) .
			' (Check: <b>' . KeyCheck::KCV($key->Comp3) . '</b>)',
		],
	],
]);
