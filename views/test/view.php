<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\request\arRequest */

$this->title = $model->Name;
$this->params['breadcrumbs'][] = ['label' => 'Ar Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ar-request-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            'Type',
            'Number',
            'Date',
            'DateClose',
            'Desc:ntext',
            'Append:ntext',
            'Contact:ntext',
            'Name:ntext',
            'Addr:ntext',
            'Overdue:boolean',
        ],
    ]) ?>

</div>
