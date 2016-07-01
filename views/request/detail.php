<?php

use kartik\detail\DetailView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = 'Заявка №' . $model->Number;

$TextDetail = '<table cellspacing="5" border="1">';
foreach ($model->texts as $text) {
	$TextDetail .='<tr><td nowrap>' . Yii::$app->formatter->asDatetime($text->Date, 'php:d/m/Y H:i') . '</td><td>' .
		$text->Text . '</td></tr>';
}
$TextDetail .= '</table>';

echo DetailView::widget([
	'model' => $model,
	'mode' => DetailView::MODE_VIEW,
	'hideIfEmpty' => true,
	#'enableEditMode' => false,
	'panel' => [
		'heading' => 'Заявка №' . $model->Number,
		'headingOptions' => [
			'type' => DetailView::TYPE_PRIMARY,
			'template' => '{title}',
		],
		#'footer' => '1234321',
		'footerOptions' => [
			'template' => '{title}',
		],
	],
	'attributes' => [
		[
			'attribute' => 'Date',
			'format' => ['date', 'php:d/m/Y H:i'],
		],
		[
			'attribute' => 'DateClose',
			'format' => ['date', 'php:d/m/Y'],
			'visible' => ($model->DateClose !== null),
		],
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
		[
			'label' => 'Вопрос/Проблема',
			'format' => 'html',
			#'value' => $TextDetail,
			'value' => implode('<p>', ArrayHelper::map($model->texts, 'ID', 'FullDesc')),
		]
	],
]);


if ($model->DateClose === null) {
	$closed = new \app\models\request\arReqText();
	$closed->RequestID = $model->ID;
	$closed->Date = date('d/m/Y');
	echo DetailView::widget([
		'model' => $closed,
		'mode' => DetailView::MODE_EDIT,
		'hideIfEmpty' => true,
		#'enableEditMode' => false,
		'panel' => [
			'heading' => 'Закрытие заявки',
			'headingOptions' => [
				'type' => DetailView::TYPE_INFO,
				'template' => '{title}',
			],
			'footer' => Html::submitButton('Закрыть заявку', [
				'class' => 'btn btn-primary',
				'name' => 'reqCloseBtn',
			]),
			'footerOptions' => [
				'template' => '{title}',
			],
		],
		'attributes' => [
			[
				'attribute' => 'Date',
				'type' => DetailView::INPUT_DATE,
				'widgetOptions' => [
					'pluginOptions' => [
						'format' => 'dd/mm/yyyy',
					],
				],
			],
			[
				'attribute' => 'Text',
				'label' => 'Описание',
				'type' => DetailView::INPUT_TEXTAREA,
			#'type' => 'html',
			#'value' => ''
			],
		],
	]);
}