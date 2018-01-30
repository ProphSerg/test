<?php

use yii\bootstrap\ActiveForm;
#use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\pos\arKey;

$this->title = 'Генерация списка ключей';
?>

<?= $this->render('_frm-enter-key-reserve', ['model' => $model,]) ?>