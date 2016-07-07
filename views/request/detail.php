<?php

use kartik\detail\DetailView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = 'Заявка №' . $model->Number;

$TextDetail = '';
$i = 0;
foreach ($model->texts as $text) {
	$TextDetail.='<p class="reqTableComent' . ($i++ % 2 == 0 ? 'Even' : 'Odd') . '">' . $text->FullDesc;
}

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
	],
]);

Modal::begin([
	'header' => 'Model',
	#'toggleButton' => ['label' => 'Modal click'],
	'id' => 'addComment',
]);
echo 'Hello MODAL!!';
Modal::end();

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