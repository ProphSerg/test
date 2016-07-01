<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\test\reqsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ar Requests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ar-request-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ar Request', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'Type',
            'Number',
            'Date',
            'DateClose',
            // 'Desc:ntext',
            // 'Append:ntext',
            // 'Contact:ntext',
            // 'Name:ntext',
            // 'Addr:ntext',
            // 'Overdue:boolean',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
