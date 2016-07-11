<?php

use kartik\detail\DetailView;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\models\request\arRequest;
use app\models\atm\arSprATM;

$this->title = 'Новая заявка ';
$attr = [];
switch ($model->Type) {
	case arRequest::REQUEST_TS:
		$this->title .= 'ТСП';
		$attr = [
			[
				'attribute' => 'Name',
				'format' => 'text',
			],
			[
				'attribute' => 'Addr',
				'format' => 'text',
			],
			[
				'attribute' => 'Desc',
				'format' => 'text',
			],
			[
				'attribute' => 'Append',
				'format' => 'text',
			],
			[
				'attribute' => 'Contact',
				'format' => 'text',
			],
		];
		break;
	case arRequest::REQUEST_ATM:
		$this->title .= 'по банкомату';
		$attr = [
			[
				'label' => 'Банкомат',
				'attribute' => 'ATMID',
				'type' => DetailView::INPUT_SELECT2,
				'widgetOptions' => [
					#'model' => $modelATM,
					'attribute' => 'TerminalID',
					'data' => ArrayHelper::map(arSprATM::find()->orderBy('TerminalID')->all(), 'ID', 'FullName'),
					'options' => ['placeholder' => 'Выбирите банкомат ...'],
				],
			]
		];
		break;
}

$attr[] = [
	'label' => 'Вопрос/Проблема',
	'attribute' => 'Text',
	'type' => DetailView::INPUT_TEXTAREA,
];

echo DetailView::widget([
	'model' => $model,
	'mode' => DetailView::MODE_EDIT,
	'panel' => [
		'heading' => $this->title,
		'headingOptions' => [
			'type' => DetailView::TYPE_PRIMARY,
			'template' => '{title}',
		],
		'footer' => Html::submitButton('Добавить заявку', [
			'class' => 'btn btn-primary',
			'name' => 'reqAddTS',
		]),
		'footerOptions' => [
			'template' => '{title}',
		],
	],
#[['Name', 'Desc', 'Text'], 'required'],
#[['Desc', 'Append', 'Contact', 'Name', 'Addr', 'Text'], 'string'],
	'attributes' => $attr,
]);
