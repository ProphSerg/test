<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use app\models\atm\arSprATMOrderStatus;
use \app\models\atm\arSprATMOrderTech;

$this->title = 'Список свободных ключей';

echo GridView::widget([
	'dataProvider' => $dataProvider,
	#'filterRowOptions' => ['class' => 'atmTableFilter'],
	#'pjax' => true,
	'hover' => true,
	'condensed' => true,
	'floatHeader' => true,
	'tableOptions' => ['class' => 'keyTable'],
#'striped' => false,
#'headerRowOptions' => ['class' => 'kartik-sheet-style atmTable'],
#'filterRowOptions' => ['class' => 'kartik-sheet-style'],
	'columns' => [
		[
			'attribute' => 'Number',
		],
		[
			'class' => 'kartik\grid\EditableColumn',
			'attribute' => 'Comment',
			'editableOptions' => [
				#'header' => 'Name',
				#'size' => 'md',
				'formOptions' => ['action' => ['/pos/key-reserve-edit']]
			],
		],
	],
]);
