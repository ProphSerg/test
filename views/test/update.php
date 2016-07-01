<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\request\arRequest */

$this->title = 'Update Ar Request: ' . $model->Name;
$this->params['breadcrumbs'][] = ['label' => 'Ar Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Name, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ar-request-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
