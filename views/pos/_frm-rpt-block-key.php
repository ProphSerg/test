<?php

use yii\bootstrap\ActiveForm;
#use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

echo "<h2 align=\"center\">Журнал использования ключей</h3>";

$form = ActiveForm::begin([
            'id' => 'rpt-block-key',
#            'layout' => 'horizontal',
#            'target' => '_blank',
        ]);
$items = ArrayHelper::map($model, 'blockKey', 'blockKey');
$params = [
    'prompt' => 'Укажите блок ключей'
];
#echo $form->field($model, 'blockKey')->dropDownList($items,$params);
?>

<div class="row">
    <div class="col-xs-3 col-xs-offset-2">
        <?= Html::dropDownList('ddl-blockKey', null, $items, $params) ?>
    </div>
    <div class="col-xs-3">
        <?=
        Html::submitButton('Сформировать журнал', [
#        Html::a('Сформировать журнал', [''], [
            'class' => 'btn btn-primary',
            'name' => 'btn-rpt-block-key',
                #           'target' => '_blank',
                #           'data-pjax' => '0',
        ])
        ?>
    </div>
    <div class="col-xs-3">
        <?=
        Html::submitButton('Сформировать титул', [
#        Html::a('Сформировать журнал', [''], [
            'class' => 'btn btn-primary',
            'name' => 'btn-rpt-block-key-titul',
                #           'target' => '_blank',
                #           'data-pjax' => '0',
        ])
        ?>
    </div>
</div>

<?php ActiveForm::end() ?>
