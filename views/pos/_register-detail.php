<?php

use kartik\detail\DetailView;
use yii\helpers\Html;
use yii\bootstrap\Collapse;
use app\models\pos\arKey;
use app\assets\ClipboardAsset;
use yii\helpers\Url;

#var_dump($model->keys);
#echo 'register-detail';
echo DetailView::widget([
    'model' => $model,
    'mode' => DetailView::MODE_VIEW,
    'hideIfEmpty' => true,
    'enableEditMode' => false,
    'panel' => [
        'heading' => 'Terminal ID ' . $model->TerminalID,
        'type' => DetailView::TYPE_INFO,
        'headingOptions' => [
#'type' => DetailView::TYPE_INFO,
            'template' => '{title}',
        ],
        #'footer' => '1234321',
        'footerOptions' => [
            'template' => '{title}',
        ],
    ],
    /*
      'options' => [
      'id' => implode('-', [$model->TerminalID, $model->KeyNum]),
      ],
      /*
      'formOptions' => [
      'action' => ['register'],
      ],
     * 
     */
    'rowOptions' => ['style' => 'font-size: 12px'],
    'attributes' => [
        /*
          'ClientN' => 'Client #',
          'Name' => 'Название ТСП',
          'ContractN' => 'Contract #',
          'TerminalID' => 'Terminal ID',
          'City' => 'Город',
          'Address' => 'Адрес установки',
          'MerchantID' => 'MerchantID',
          'KeyNum' => 'Серийный номер ключа',
          'TMK_CHECK' => 'TMK_CHECK',
          'TPK_KEY' => 'TPK_KEY',
          'TPK_CHECK' => 'TPK_CHECK',
          'TAK_KEY' => 'TAK_KEY',
          'TAK_CHECK' => 'TAK_CHECK',
          'TDK_KEY' => 'TDK_KEY',
          'TDK_CHECK' => 'TDK_CHECK',
         */
        [
            'attribute' => 'Name',
            'format' => 'raw',
            'value' => ClipboardAsset::buttonCopyText($model->Name, $model->TerminalID . $model->KeyNum . 'Name'),
        ],
        [
            'attribute' => 'City',
            'format' => 'raw',
            'value' => ClipboardAsset::buttonCopyText($model->City, $model->TerminalID . $model->KeyNum . 'City'),
        ],
        [
            'attribute' => 'Address',
            'format' => 'raw',
            'value' => ClipboardAsset::buttonCopyText($model->Address, $model->TerminalID . $model->KeyNum . 'Address'),
        ],
        [
            'attribute' => 'MerchantID',
            'format' => 'raw',
            'value' => ClipboardAsset::buttonCopyText($model->MerchantID, $model->TerminalID . $model->KeyNum . 'MerchantID'),
        ],
        [
            'attribute' => 'TPK_KEY',
            'valueColOptions' => ['style' => 'font-family: monospace; font-size: 14px;'],
            'format' => 'raw',
            'value' => ClipboardAsset::buttonCopyText($model->TPK_KEY, $model->TerminalID . $model->KeyNum . 'TPK_KEY') .
            '<p>' . ClipboardAsset::buttonCopyText(substr($model->TPK_KEY, 0, 16), $model->TerminalID . $model->KeyNum . 'TPK_KEY1') .
            ClipboardAsset::buttonCopyText(substr($model->TPK_KEY, 16, 16), $model->TerminalID . $model->KeyNum . 'TPK_KEY2'),
        ],
        [
            'attribute' => 'TAK_KEY',
            'valueColOptions' => ['style' => 'font-family: monospace; font-size: 14px;'],
            'format' => 'raw',
            'value' => ClipboardAsset::buttonCopyText($model->TAK_KEY, $model->TerminalID . $model->KeyNum . 'TAK_KEY') .
            '<p>' . ClipboardAsset::buttonCopyText(substr($model->TAK_KEY, 0, 16), $model->TerminalID . $model->KeyNum . 'TAK_KEY1') .
            ClipboardAsset::buttonCopyText(substr($model->TAK_KEY, 16, 16), $model->TerminalID . $model->KeyNum . 'TAK_KEY2'),
        ],
        [
            'attribute' => 'TDK_KEY',
            'valueColOptions' => ['style' => 'font-family: monospace; font-size: 14px;'],
            'format' => 'raw',
            'value' => ClipboardAsset::buttonCopyText($model->TDK_KEY, $model->TerminalID . $model->KeyNum . 'TDK_KEY') .
            '<p>' . ClipboardAsset::buttonCopyText(substr($model->TDK_KEY, 0, 16), $model->TerminalID . $model->KeyNum . 'TDK_KEY1') .
            ClipboardAsset::buttonCopyText(substr($model->TDK_KEY, 16, 16), $model->TerminalID . $model->KeyNum . 'TDK_KEY2'),
        ],
        [
            'attribute' => 'TMK_CHECK',
            'valueColOptions' => ['style' => 'font-family: monospace; font-size: 14px;'],
        ],
        [
            'attribute' => 'KeyNum',
            'format' => 'raw',
            'value' => (arKey::CanAccess() && $model->keys != null ?
                    Collapse::widget([
                        'id' => $model->TerminalID . $model->KeyNum,
                        'items' => [
                            [
                                'encode' => false,
                                'label' => $model->KeyNum,
                                #	'content' => $keyView,
                                'content' => $this->render('_key-detail', [
                                    'key' => $model->keys,
                                ]),
                            ]
                        ],
                    ]) : $model->KeyNum . (!arKey::CanAccess() ? '' :
                            Html::a('', '#', [
                                'id' => 'modal-btn-add-key',
                                'class' => 'btn glyphicon glyphicon-plus',
                                #'data-toggle' => 'modal',
                                'data' => [
                                    'target' => Url::to(['addkey']),
                                    'keynum' => $model->KeyNum,
                                    'keycheck' => $model->TMK_CHECK,
                                ],
                                'title' => 'Ввести ключ',
                            ]))
            ),
        ],
    ],
]);

#echo "END";
if (($model->keys == null) && arKey::CanAccess()) {
    yii\bootstrap\Modal::begin([
        'header' => 'Введите компоненты ключа',
        'id' => 'modal-form-add-key',
        'size' => 'modal-md',
    ]);
    ?>
    <div id='modal-content'>Загрузка</div>
    <?php yii\bootstrap\Modal::end(); ?>
    <script type="text/javascript">
        $('#modal-btn-add-key').on('click', function () {
            $('#modal-form-add-key').modal('show')
                    .find('#modal-content')
                    .load($(this).attr('data-target')
                            , {
                                'Number': "<?= $model->KeyNum; ?>",
                                'Check': "<?= $model->TMK_CHECK; ?>"
                            }

                    );
        });
    </script>
    <?php
}
