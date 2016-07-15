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
$pbt = <<< HTML
    <div class="pull-left">
        <div class="btn-toolbar kv-grid-toolbar" role="toolbar">
            {toolbar}
        </div>
    </div>
    {before}
    <div class="clearfix"></div>
HTML;

echo GridView::widget([
	'id' => 'gvRequests',
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
	'toolbar' => [
		[
			'content' =>
			Html::a(
				'<i class="glyphicon glyphicon-refresh"></i>', [''], [
				#'type' => 'button',
				'class' => 'btn btn-default',
				'id' => 'btnReqRefresh',
				'title' => 'Обновить',
			])
			. '  ' .
			Html::a(
				'<i class="glyphicon glyphicon-print"></i>', ['/request/print', 'type' => Yii::$app->controller->action->id], [
				'target' => '_blank',
				'data-toggle' => 'tooltip',
				'class' => 'btn btn-default',
				#'id' => 'btnReqPrint',
				'title' => 'Печать',
			]),
		],
		'{export}',
	#'{toggleData}',
	],
	'panel' => [
		'type' => GridView::TYPE_PRIMARY,
		'heading' => 'Заявки',
	],
	'panelBeforeTemplate' => $pbt,
	'export' => [
		'icon' => 'print',
		'label' => 'Печать',
		'showConfirmAlert' => false,
		#'target' => GridView::TARGET_SELF,
		'header' => (Yii::$app->controller->action->id == 'actived' ? 'Активные заявки' : 'Закрытые заявки'),
		'exportConfig' => [
			GridView::PDF => [
				'config' => [
					'methods' => [
						'SetHeader' => (Yii::$app->controller->action->id == 'actived' ? 'Активные заявки' : 'Закрытые заявки') . '||' . date('r'),
						'SetFooter' => '||стр. {PAGENO}',
					],
				],
			],
		],
	],
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
