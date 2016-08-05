<?php

use kartik\widgets\ActiveForm;
use kartik\daterange\DateRangePicker;
use yii\bootstrap\Html;
?>

<div class="row">
	<div class="col-xs-5">
		<?= Html::beginForm(); ?>
		<label class="control-label">Выберите период</label>
		<div class="input-group drp-container">

			<?=
			DateRangePicker::widget([
				'name' => 'report_range',
				'convertFormat' => true,
				'useWithAddon' => false,
				'hideInput'=> true,
				'value' => $report_range,
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
<!--
			<span class="input-group-addon">
				<i class="glyphicon glyphicon-calendar"> </i>
			</span>
-->
		</div>
		<?= Html::submitButton('Сформировать отчет', ['class' => 'btn btn-primary']); ?>
		<?= Html::endForm(); ?>
	</div>
</div>