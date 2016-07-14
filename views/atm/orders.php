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
	'pjax' => true,
	'hover' => true,
	'condensed' => true,
	'floatHeader' => true,
	/*
	  'tableOptions' => ['class' => 'reqTable'],
	  'headerRowOptions' => ['class' => 'reqTable'],
	  'rowOptions' => function ($model, $key, $index, $grid) {
	  if ($model->Overdue === true) {
	  #return ['style' => 'background-color:red'];
	  return ['class' => 'reqTableRowOverdue'];
	  } elseif ($index % 2 == 0) {
	  #return ['style' => 'background-color:#CCCCCC'];
	  }
	  },
	 * 
	 */
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
	],
]);
?>
