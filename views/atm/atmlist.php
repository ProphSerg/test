<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use app\models\atm\arSprATMOrderStatus;
use \app\models\atm\arSprATMOrderTech;

$this->title = 'Список банкоматов';

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
			'attribute' => 'Model',
			'class' => 'kartik\grid\EditableColumn',
			'editableOptions' => [
				#'header' => 'Name',
				#'size' => 'md',
				'formOptions' => ['action' => ['/atm/editatm']]
			],
		],
		[
			'attribute' => 'Serial',
			'class' => 'kartik\grid\EditableColumn',
			'editableOptions' => [
				#'header' => 'Name',
				#'size' => 'md',
				'formOptions' => ['action' => ['/atm/editatm']]
			],
		],
		[
			'attribute' => 'TerminalID',
			'class' => 'kartik\grid\EditableColumn',
			'editableOptions' => [
				#'header' => 'Name',
				#'size' => 'md',
				'formOptions' => ['action' => ['/atm/editatm']]
			],
		],
		[
			'attribute' => 'Addres',
			'class' => 'kartik\grid\EditableColumn',
			'editableOptions' => [
				#'header' => 'Name',
				#'size' => 'md',
				'formOptions' => ['action' => ['/atm/editatm']]
			],
		],
		[
			'attribute' => 'Type',
			'class' => 'kartik\grid\EditableColumn',
			'editableOptions' => [
				#'header' => 'Name',
				#'size' => 'md',
				'formOptions' => ['action' => ['/atm/editatm']]
			],
		],
		[
			'attribute' => 'InvNum',
			'class' => 'kartik\grid\EditableColumn',
			'editableOptions' => [
				#'header' => 'Name',
				#'size' => 'md',
				'formOptions' => ['action' => ['/atm/editatm']]
			],
		],
	],
]);

#var_dump($dataProvider->query);
