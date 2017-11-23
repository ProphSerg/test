<?php

#use yii\bootstrap\ActiveForm;
#use yii\widgets\ActiveForm;
#use yii\helpers\Html;

$this->title = 'Работа с ключами';
?>

<?= $this->render('_frm-enter-key-reserve', ['model' => $KeyReserveModel,]) ?>

<?= $this->render('_frm-rpt-block-key', ['model' => $BlockKeyModel,]) ?>
