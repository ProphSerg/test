<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\request\arRequest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ar-request-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Type')->textInput() ?>

    <?= $form->field($model, 'Number')->textInput() ?>

    <?= $form->field($model, 'Date')->textInput() ?>

    <?= $form->field($model, 'DateClose')->textInput() ?>

    <?= $form->field($model, 'Desc')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'Append')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'Contact')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'Name')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'Addr')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'Overdue')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
