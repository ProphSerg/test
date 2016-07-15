<?php

use kartik\grid\GridView;
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
		<style>
			table {
				border-collapse: collapse;
				border: 2px black;
				font-size: 10px;
				padding: 0;
				margin: 0; 
			}
			td {
				border: 2px black;
			}
		</style>
    </head>
    <body>
		<?php
		echo GridView::widget([
			'dataProvider' => $dataProvider,
			'pjax' => false,
			'hover' => false,
			'condensed' => true,
			'floatHeader' => true,
			#'tableOptions' => ['class' => 'reqTable'],
			#'headerRowOptions' => ['class' => 'reqTable'],
			/*
			'rowOptions' => function ($model, $key, $index, $grid) {
			if ($model->Overdue === true) {
				#return ['style' => 'background-color:red'];
				return ['class' => 'reqTableRowOverdue'];
			} elseif ($index % 2 == 0) {
				#return ['style' => 'background-color:#CCCCCC'];
			}
		},*/
			'columns' => [
				[
					'attribute' => 'Number',
					'format' => 'text',
				],
				[
					'attribute' => 'Date',
					'format' => ['date', 'php:d/m/Y'],
				],
				[
					'attribute' => 'DateClose',
					'format' => ['date', 'php:d/m/Y'],
					'visible' => ($type == 'actived' ? false : true),
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
	</body>
</html>
