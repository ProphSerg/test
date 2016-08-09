<?php

use kartik\widgets\ActiveForm;
use kartik\daterange\DateRangePicker;
use yii\bootstrap\Html;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
?>

<div class="row">
	<div class="col-xs-3">
		<?= Html::beginForm(); ?>
		<label class="control-label">Выберите период</label>

		<?=
		DateRangePicker::widget([
			'name' => 'report_range',
			'convertFormat' => true,
			'useWithAddon' => false,
			'hideInput' => true,
			'value' => $range['value'],
			'pluginOptions' => [
				'ranges' => [
					'Прошедшая неделя' => ["moment().startOf('week').subtract(1,'week')", "moment().endOf('week').subtract(1,'week')"],
				],
				'locale' => ['format' => 'd.m.Y'],
			#'opens' => 'left',
			],
			#'options' => ['size' => '100px'],
		]);
		?>
		<?= Html::submitButton('Сформировать отчет', ['class' => 'btn btn-primary']); ?>
		<?= Html::endForm(); ?>
	</div>
</div>
<div class="row">
	<?= $this->render($report, ['range' => $range]) ?>
</div>

	
