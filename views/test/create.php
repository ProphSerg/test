<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\request\arRequest */

$this->title = 'Create Ar Request';
$this->params['breadcrumbs'][] = ['label' => 'Ar Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ar-request-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
