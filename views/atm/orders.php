<?php

use kartik\grid\GridView;
use yii\helpers\Html;

$this->title = 'Обслуживание банкоматов';
/*
  $dataProvider = new ActiveDataProvider([
  'query' => $model,
  'pagination' => [
  'pageSize' => 20,
  ],
  ]);
 */

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
	'headerRowOptions' => ['class' => 'atmTable'],
	'rowOptions' => function ($model, $key, $index, $grid) {
	return ['class' => 'atmTableRowStatus' . $model->statusLast->Status];
},
	'columns' => [
#['class' => 'yii\grid\SerialColumn'],
		/*
		  [
		  'attribute' => 'Number',
		  'format' => 'raw',
		  'value' => function ($data) {
		  return Html::a($data->Number, [
		  'request/detail',
		  'id' => $data->ID
		  ]
		  );
		  }
		  ],
		 * 
		 */
		/*
		  [
		  'class' => \kartik\grid\ActionColumn::className(),
		  'template' => '{view}',
		  'header' => '',
		  'contentOptions'=> ['class' => 'glyphicon-white'],
		  ],
		 * 
		 */
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
				'format' => ['date', 'php:d/m/Y H:i'],
			],
			[
				'attribute' => 'Number',
				'format' => 'text',
			],
			[
				'attribute' => 'statusNameLast.StatusName',
				'format' => 'text',
			],
			[
				'attribute' => 'serial.TerminalID',
				'format' => 'text',
			],
			[
				'attribute' => 'serial.Addres',
				'format' => 'text',
			],
		],
	]);
?>
