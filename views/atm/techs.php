<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use app\models\atm\arSprATMOrderStatus;
use \app\models\atm\arSprATMOrderTech;

$this->title = 'Список инженеров';

echo GridView::widget([
	'dataProvider' => $dataProvider,
	#'filterRowOptions' => ['class' => 'atmTableFilter'],
	#'pjax' => true,
	'hover' => true,
	'condensed' => true,
	'floatHeader' => true,
	'tableOptions' => ['class' => 'atmTable'],
#'striped' => false,
#'headerRowOptions' => ['class' => 'kartik-sheet-style atmTable'],
#'filterRowOptions' => ['class' => 'kartik-sheet-style'],
	'columns' => [
		[
			'attribute' => 'Code',
		],
		[
			'attribute' => 'Name',
		],
		[
			'class' => 'kartik\grid\EditableColumn',
			'attribute' => 'NameRus',
		],
		[
			'class' => 'kartik\grid\EditableColumn',
			'attribute' => 'Phone',
		],
	],
]);

#var_dump($dataProvider->query);
