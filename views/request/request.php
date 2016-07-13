<?php

use kartik\grid\GridView;
use yii\helpers\Html;

$this->title = 'Заявки';
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
	'columns' => [
#['class' => 'yii\grid\SerialColumn'],
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
			[
				'attribute' => 'Date',
				'format' => ['date', 'php:d/m/Y'],
			],
			[
				'attribute' => 'DateClose',
				'format' => ['date', 'php:d/m/Y'],
				'visible' => (Yii::$app->controller->action->id === 'actived' ? false : true),
			],
			[
				'attribute' => 'Name',
				'format' => 'text',
			],
			[
				'attribute' => 'Desc',
				'format' => 'text',
			],
			[
				'attribute' => 'Addr',
				'format' => 'text',
			],
			[
				'attribute' => 'texts.FullDesc',
				'format' => 'html',
				'value' => function($data) {
					$str = '';
					$i = 0;
					$tt = [];
					foreach ($data['texts'] as $item) {
						$tt[$i++] = [
							'class' => 'reqTableComent' . ($i % 2 == 1 ? 'Even' : 'Odd'),
							'value' => $item['FullDesc'],
						];
						//$str.='<p class="reqTableComent' . ($i++ % 2 == 0 ? 'Even' : 'Odd') . '">' . $item['FullDesc'];
					}
					if (isset($data['DateClose']) && $data['DateClose'] !== null) {
						$tt[$i - 1]['class'] = 'reqTableComentClose';
						#var_dump($tt);
						
					}
					foreach ($tt as $t) {
						$str.='<p class="' . $t['class'] . '">' . $t['value'];
					}
					return $str;
				}
				],
			],
		]);
?>
