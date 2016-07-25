<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use app\models\atm\arSprATMOrderStatus;

$this->title = 'Обслуживание банкоматов';

echo GridView::widget([
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
	#'filterRowOptions' => ['class' => 'atmTableFilter'],
	'pjax' => true,
	'hover' => true,
	'condensed' => true,
	'floatHeader' => true,
	'tableOptions' => ['class' => 'atmTable'],
	'striped' => false,
	'headerRowOptions' => ['class' => 'kartik-sheet-style atmTable'],
	'filterRowOptions' => ['class' => 'kartik-sheet-style'],
	'rowOptions' => function ($model, $key, $index, $grid) {
	return ['class' => 'atmTableRowStatus' . $model->statusLast->Status];
},
	'columns' => [
		[
			'class' => \kartik\grid\ExpandRowColumn::className(),
			'width' => '50px',
			'value' => function ($model, $key, $index, $column) {
				return GridView::ROW_COLLAPSED;
			},
			#'detailUrl' => 'order-remarks',
			'detail' => function ($model, $key, $index, $column) {
				return Yii::$app->controller->renderPartial('_expand-order-details', ['model' => $model->remarks]);
			},
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'expandOneOnly' => true,
			],
			[
				'attribute' => 'EnterDate',
				'format' => ['date', 'php:d/m/Y'],
				'width' => '100px',
			],
			[
				'attribute' => 'Number',
				'format' => 'text',
				'width' => '100px',
			],
			[
				'attribute' => 'statusNameLast.StatusName',
				'format' => 'text',
				'filter' => arSprATMOrderStatus::getStatusList(),
			],
			[
				'attribute' => 'sprATM.TerminalID',
				'format' => 'text',
				'width' => '80px',
			],
			[
				'attribute' => 'techNameLast.Name',
				'format' => 'text',
				'label' => 'Инженер'
			],
			[
				'attribute' => 'sprATM.Addres',
				'format' => 'text',
			],
		],
	]);

#var_dump($dataProvider->query);
