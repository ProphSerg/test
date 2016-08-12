<?php

use kartik\detail\DetailView;
use yii\helpers\Html;
use yii\bootstrap\Collapse;
use app\models\pos\arKey;

#var_dump($model->keys);

$keymode = DetailView::MODE_VIEW;
$key = $model->keys;
if ($key == null) {
	$key = new arKey();
	$key->Number = $model->KeyNum;
	$key->Check = $model->TMK_CHECK;
	$keymode = DetailView::MODE_EDIT;
}

$keyView = DetailView::widget([
		'model' => $key,
		'mode' => $keymode,
		'hideIfEmpty' => false,
		#'enableEditMode' => false,
		'panel' => [
			'heading' => 'Компоненты ключа111: ' . $key->Number
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
		],
	]);


echo DetailView::widget([
	'model' => $model,
	'mode' => DetailView::MODE_VIEW,
	'hideIfEmpty' => true,
	'enableEditMode' => false,
	'panel' => [
		'heading' => 'Terminal ID ' . $model->TerminalID,
		'type' => DetailView::TYPE_INFO,
		'headingOptions' => [
#'type' => DetailView::TYPE_INFO,
			'template' => '{title}',
		],
		#'footer' => '1234321',
		'footerOptions' => [
			'template' => '{title}',
		],
	],
	'options' => [
		'id' => implode('-', [$model->TerminalID, $model->KeyNum]),
	],
	/*
	'formOptions' => [
		'action' => ['register'],
	],
	 * 
	 */
	'attributes' => [
		/*
		  'ClientN' => 'Client #',
		  'Name' => 'Название ТСП',
		  'ContractN' => 'Contract #',
		  'TerminalID' => 'Terminal ID',
		  'City' => 'Город',
		  'Address' => 'Адрес установки',
		  'MerchantID' => 'MerchantID',
		  'KeyNum' => 'Серийный номер ключа',
		  'TMK_CHECK' => 'TMK_CHECK',
		  'TPK_KEY' => 'TPK_KEY',
		  'TPK_CHECK' => 'TPK_CHECK',
		  'TAK_KEY' => 'TAK_KEY',
		  'TAK_CHECK' => 'TAK_CHECK',
		  'TDK_KEY' => 'TDK_KEY',
		  'TDK_CHECK' => 'TDK_CHECK',
		 */
		[
			'attribute' => 'Name',
		],
		[
			'attribute' => 'Address',
		],
		[
			'attribute' => 'MerchantID',
		],
		[
			'attribute' => 'TPK_KEY',
		],
		[
			'attribute' => 'TAK_KEY',
		],
		[
			'attribute' => 'TDK_KEY',
		],
		[
			'attribute' => 'TMK_CHECK',
		],
		[
			'attribute' => 'KeyNum',
			'format' => 'raw',
			'value' => (arKey::CanAccess() ?
				Collapse::widget([
					'id' => implode('-', [$model->TerminalID, $model->KeyNum, 'keys']),
					'items' => [
						[
							'encode' => false,
							'label' => $model->KeyNum,
							#	'content' => $keyView,
							'content' => $this->render('_key-detail', [
								'model' => $model,
							]),
						]
					],
				]) : $model->KeyNum),
		],
	/*
	  [
	  'label' => 'Вопрос/Проблема' .
	  ($model->DateClose === null ? ' ' .
	  Html::a('', '', [
	  'class' => 'btn glyphicon glyphicon-pencil',
	  'data-toggle' => 'modal',
	  'data-target' => '#addComment',
	  'title' => 'Добавить комментарий',
	  ]) : ''),
	  'format' => 'html',
	  'value' => $TextDetail,
	  #'value' => implode('<p>', ArrayHelper::map($model->texts, 'ID', 'FullDesc')),
	  ]
	 * 
	 */
	],
]);
