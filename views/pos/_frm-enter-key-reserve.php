<?php
use yii\bootstrap\ActiveForm;
#use yii\widgets\ActiveForm;
use yii\helpers\Html;

echo "<h2 align=\"center\">Генерация списка ключей</h3>";

$form = ActiveForm::begin([
		'id' => 'enter-key-reserve',
		'layout' => 'horizontal',
	]);
?>
<div class="row">
	<div class="col-xs-3 col-xs-offset-1">
		<?= $form->field($model, 'KeyDate') ?>
	</div>
	<div class="col-xs-2">
		<?= $form->field($model, 'KeyStart') ?>
	</div>
	<div class="col-xs-2">
		<?= $form->field($model, 'KeyEnd') ?>
	</div>
</div>
<div class="form-group">
	<div class="col-xs-offset-2 col-xs-6">
		<?= Html::submitButton('Сформировать список', [
                        'class' => 'btn btn-primary',
                        'name' => 'btn-key-reserve'
                    ]) ?>
	</div>
</div>
<?php ActiveForm::end() ?>
