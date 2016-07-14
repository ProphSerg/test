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
		[
			'class' => \kartik\grid\ActionColumn::className(),
			'template' => '{view}',
			'header' => '',
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
