<?php

use kartik\grid\GridView;
use yii\data\ActiveDataProvider;

$this->title = 'Заявки';

$dataProvider = new ActiveDataProvider([
	'query' => $model,
	'pagination' => [
		'pageSize' => 20,
	],
	]);

echo GridView::widget([
	'dataProvider' => $dataProvider,
	'pjax' => true,
	'floatHeader'=>true,
	'columns' => [
		#['class' => 'yii\grid\SerialColumn'],
		[
			'attribute' => 'Number',
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
				foreach ($data['texts'] as $item) {
					$str.='<p>' . $item['FullDesc'];
				}
				return $str;
			}
		],
	],
]);
?>
