<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
            'id' => 'order-form',
            'enableAjaxValidation' => true,
        ]);
?>

<div class="modal-body">
    <?= $form->field($model, 'Number')->textInput(['readonly' => "readonly", 'style' => "font-size: 14px"]); ?>
    <?= $form->field($model, 'Check')->textInput(['readonly' => "readonly", 'style' => "font-size: 14px"]); ?>
    <?= $form->field($model, 'Comp1')->textInput(['onkeyup' => "this.value = this.value.toUpperCase();", 'style' => "font-size: 14px", 'autocomplete' => "off"]) ?>
    <?= $form->field($model, 'Comp2')->textInput(['onkeyup' => "this.value = this.value.toUpperCase();", 'style' => "font-size: 14px", 'autocomplete' => "off"]) ?>
    <?= $form->field($model, 'Comp3')->textInput(['onkeyup' => "this.value = this.value.toUpperCase();", 'style' => "font-size: 14px", 'autocomplete' => "off"]) ?>
</div>

<div class="modal-footer">
    <?= Html::submitButton('Отменить', ['class' => 'btn btn-default', 'data-dismiss' => "modal"]) ?>
    <?= Html::submitButton('Cохранить', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
