<?php

use kartik\detail\DetailView;

echo DetailView::widget([
	'model' => $model,
	'mode' => DetailView::MODE_VIEW,
	'hideIfEmpty' => true,
	#'enableEditMode' => false,
	'panel' => [
		'heading' => 'Terminal ID ' . $model->TerminalID,
		'type' => DetailView::TYPE_INFO,
		'headingOptions' => [
			#'type' => DetailView::TYPE_INFO,
			'template' => '{title}',
		],
		#'footer' => '1234321',
		'footerOptions' => [
			'template' => '{title}',
		],
	],
	'attributes' => [
		/*
		  'ClientN' => 'Client #',
		  'Name' => 'Название ТСП',
		  'ContractN' => 'Contract #',
		  'TerminalID' => 'Terminal ID',
		  'City' => 'Город',
		  'Address' => 'Адрес установки',
		  'MerchantID' => 'MerchantID',
		  'KeyNum' => 'Серийный номер ключа',
		  'TMK_CHECK' => 'TMK_CHECK',
		  'TPK_KEY' => 'TPK_KEY',
		  'TPK_CHECK' => 'TPK_CHECK',
		  'TAK_KEY' => 'TAK_KEY',
		  'TAK_CHECK' => 'TAK_CHECK',
		  'TDK_KEY' => 'TDK_KEY',
		  'TDK_CHECK' => 'TDK_CHECK',
		 */
		[
			'attribute' => 'Name',
		],
		[
			'attribute' => 'Address',
		],
		[
			'attribute' => 'MerchantID',
		],
		[
			'attribute' => 'TPK_KEY',
		],
		[
			'attribute' => 'TAK_KEY',
		],
		[
			'attribute' => 'TDK_KEY',
		],
		[
			'attribute' => 'TMK_CHECK',
		],
		[
			'attribute' => 'KeyNum',
		],
	/*
	  [
	  'label' => 'Вопрос/Проблема' .
	  ($model->DateClose === null ? ' ' .
	  Html::a('', '', [
	  'class' => 'btn glyphicon glyphicon-pencil',
	  'data-toggle' => 'modal',
	  'data-target' => '#addComment',
	  'title' => 'Добавить комментарий',
	  ]) : ''),
	  'format' => 'html',
	  'value' => $TextDetail,
	  #'value' => implode('<p>', ArrayHelper::map($model->texts, 'ID', 'FullDesc')),
	  ]
	 * 
	 */
	],
]);
