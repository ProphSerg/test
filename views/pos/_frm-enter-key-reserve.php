<?php

use yii\bootstrap\ActiveForm;
#use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\pos\arKey;

echo "<h2 align=\"center\">Генерация списка ключей</h2>";

$form = ActiveForm::begin([
            'id' => 'enter-key-reserve',
            'layout' => 'horizontal',
        ]);
?>

<div class="row col-xs-offset-1">
    <?= $form->field($model, 'KeyType')->dropDownList(arKey::NUMBER_PREFIX) ?>
    <?= $form->field($model, 'KeyDate') ?>
    <?= $form->field($model, 'KeyStart') ?>
    <?= $form->field($model, 'KeyEnd') ?>
</div>

<div class="form-group">
    <div class="col-xs-offset-2 col-xs-6">
        <?=
        Html::submitButton('Сформировать список', [
            'class' => 'btn btn-primary',
            'name' => 'btn-key-reserve'
        ])
        ?>
    </div>
</div>

<?php ActiveForm::end() ?>
