<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use app\models\atm\arSprATMOrderStatus;
use app\models\atm\arSprATMOrderTech;

$this->title = 'Заявки на ремонт банкоматов';

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    #'filterRowOptions' => ['class' => 'atmTableFilter'],
    'pjax' => true,
    'hover' => true,
    'condensed' => true,
    'floatHeader' => true,
    'tableOptions' => ['class' => 'atmTable'],
    'striped' => false,
    'headerRowOptions' => ['class' => 'kartik-sheet-style atmTable'],
    'filterRowOptions' => ['class' => 'kartik-sheet-style'],
    'rowOptions' => function ($model, $key, $index, $grid) {
        return ['class' => 'atmTableRowStatus' . $model->statusLast->Status];
    },
    'columns' => [
        [
            'class' => \kartik\grid\ExpandRowColumn::className(),
            'width' => '50px',
            'value' => function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            #'detailUrl' => 'order-remarks',
            'detail' => function ($model, $key, $index, $column) {
                return Yii::$app->controller->renderPartial('_expand-order-details', ['model' => $model->remarks]);
            },
            'headerOptions' => ['class' => 'kartik-sheet-style'],
            'expandOneOnly' => true,
        ],
        [
            'attribute' => 'EnterDate',
            'format' => ['date', 'php:d/m/Y'],
            'width' => '100px',
        ],
        [
            'attribute' => 'Number',
            'format' => 'text',
            'width' => '100px',
        ],
        [
            'attribute' => 'statusNameLast.StatusName',
            'format' => 'text',
            'filter' => arSprATMOrderStatus::getStatusList(),
        ],
        [
            'attribute' => 'sprATM.TerminalID',
            'format' => 'text',
            'width' => '80px',
        ],
        [
            'attribute' => 'techNameLast.Name',
            #'format' => 'text',
            'filter' => arSprATMOrderTech::getTechList(),
            'label' => 'Инженер',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a($model->techNameLast['Name'], '#', [
                            #'class' => 'btn',
                            'data' => [
                                'pjax' => '0',
                                'toggle' => 'modal',
                                'target' => '#detail-' . $model->techNameLast['Code'],
                            ],
                                #'title' => 'Добавить комментарий',
                ]);
            },
        ],
        [
            'attribute' => 'sprATM.Addres',
            'format' => 'text',
        ],
    ],
]);

foreach ($techList as $tech) {
    Modal::begin([
        'header' => 'Подробности',
        #'toggleButton' => ['label' => 'Modal click'],
        'id' => 'detail-' . $tech['Code'],
    ]);

#		$aForm = ActiveForm::begin([]);
#		echo $aForm->activeLabel($tech, ($tech['NameRus'] === null ? 'Name' : 'NameRus'));
    echo Html::label($tech['NameRus'] === null ? $tech['Name'] : $tech['NameRus']);
    if ($tech['Phone'] !== null) {
        echo '<br>' . Html::label($tech['Phone']);
    }

#echo 'Hello MODAL!!';
#		ActiveForm::end();
    Modal::end();
}
#var_dump($dataProvider->query);
