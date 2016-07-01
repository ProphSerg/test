<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\test\reqsearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ar-request-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'Type') ?>

    <?= $form->field($model, 'Number') ?>

    <?= $form->field($model, 'Date') ?>

    <?= $form->field($model, 'DateClose') ?>

    <?php // echo $form->field($model, 'Desc') ?>

    <?php // echo $form->field($model, 'Append') ?>

    <?php // echo $form->field($model, 'Contact') ?>

    <?php // echo $form->field($model, 'Name') ?>

    <?php // echo $form->field($model, 'Addr') ?>

    <?php // echo $form->field($model, 'Overdue')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
