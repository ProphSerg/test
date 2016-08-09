<?php

use kartik\widgets\ActiveForm;
use kartik\daterange\DateRangePicker;
use yii\bootstrap\Html;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use app\models\request\arRequest;

if (isset($range['start'])) {
	$model = arRequest::find()->ReportClose($range);
	$dataProvider = new ActiveDataProvider([
		'query' => $model,
	]);
	?>

	<div class="col-xs-6 col-xs-offset-1">
		<h3>Количество закрытых заявок за период</h3>
		<?=
		GridView::widget([
			'tableOptions' => ['class' => 'reportTable'],
			'headerRowOptions' => ['class' => 'reportTable'],
			'dataProvider' => $dataProvider,
			'summary' => '',
			'columns' => [
				'typeName',
				'countType',
			],
		])
		?>
	</div>
	<?php
}