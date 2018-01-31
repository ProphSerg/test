<?php

use yii\helpers\Html;

function printDate($k) {
    return (($k->pos === null) ? "" : Yii::$app->formatter->asDate($k->pos->DateReg, 'php:d/m/Y'));
}

function printDateDel($k, $add = 1) {
    if ($k->pos === null) {
        return "";
    }
    $dt = new DateTime($k->pos->DateReg);
    $day = Yii::$app->formatter->asDate($dt, 'php:N');
    if ((($day + $add - 1) % 7) > 4) {
        $add += 7 - (($day + $add - 1) % 7);
    }
    return Yii::$app->formatter->asDate($dt->modify('+' . $add . ' day'), 'php:d/m/Y');
}

function printCheck($k, $p) {
    $p .= '_CHECK';
    return (($k->pos === null) ? "" : $k->pos->$p);
}
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <?= Html::cssFile('@web/../views/pos/key-use-report.css') ?>
    </head>

    <body>
        <?php
        $cntKey = 0;
        foreach ($model as $key) {
            $cntKey++;
            ?>
            <table class="key-list">
                <tr>
                    <td colspan="5">
                        <b>
                            <span>Серийный номер: <u><?= $key->Number ?></u>
                            </span>
                        </b>
                    </td>
                    <td>                                    
                        <b>
                            <span>Terminal_Id: <u><?= (($key->pos === null) ? "" : $key->pos->TerminalID) ?></u>
                            </span>
                        </b>
                    </td>
                    <td>
                        <span style="text-transform:uppercase">Компрометация:</span>
                    </td>
                    <td colspan="2" >
                        <b>
                            <span>POS <?= (substr($key->Number, 3, 1) == 'S' ? 'SISO' : 'KLK') ?></span>
                        </b>
                    </td>
                    <td>
                        <b>
                            <span>TDES</span>
                        </b>
                    </td>
                </tr>
            </table>

            <table class="key-list" <?= ($cntKey % 3 ? '' : 'style="page-break-after:always;"') ?> >
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2">
                        <span style="text-transform:uppercase">ответственный за настройку</span>
                    </td>
                    <td>&nbsp;</td>
                    <td colspan="3">
                        <span style="text-transform:uppercase">ответственные за получение и загрузку октмк</span>
                    </td>
                    <td>&nbsp;</td>
                    <td>
                        <span style="text-transform:uppercase">ответственный наблюдатель</span>
                    </td>
                </tr>
                <tr>
                    <td rowspan="2">
                        <span style="font-size:5pt">ф.<p>и.<p>о.</span>
                    </td>
                    <td colspan="2" rowspan="2" style="vertical-align:bottom;width:8%">
                        <span>Курочкин А.С.</span>
                    </td>
                    <td rowspan="2">
                        <span style="font-size:5pt">ф.<p>и.<p>о.</span>
                    </td>
                    <td style="width:18%">
                        <span style="font-size:5pt">1-ая</span>
                    </td>
                    <td style="width:18%">
                        <span style="font-size:5pt">2-ая</span>
                    </td>
                    <td style="width:18%">
                        <span style="font-size:5pt">3-я</span>
                    </td>
                    <td rowspan="2">
                        <span style="font-size:5pt">ф.<p>и.<p>о.</span>
                    </td>
                    <td rowspan="2"  style="vertical-align:bottom;width:18%">
                        <span>Бурлак В.Г.</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Ротарь С.А.</span>
                    </td>
                    <td>
                        <span>Курочкин А.С.</span>
                    </td>
                    <td>
                        <span>Зуев Ю.С.</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span style="font-size:5pt">в<p>с<p>к<p>р<p>ы<p>т<p>и<p>е</span>
                    </td>
                    <td colspan="2" style="vertical-align:bottom;"><?= printDate($key) ?></td>
                    <td>
                        <span style="font-size:5pt">в<p>с<p>к<p>р<p>ы<p>т<p>и<p>е<p></span>
                    </td>
                    <td style="vertical-align:bottom;"><?= printDate($key) ?></td>
                    <td style="vertical-align:bottom;"><?= printDate($key) ?></td>
                    <td style="vertical-align:bottom;"><?= printDate($key) ?></td>
                    <td>
                        <span style="font-size:5pt">к<p>о<p>м<p>е<p>н<p>т<p>а<p>р<p>и<p>й</span>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr>
                    <td rowspan="4">
                        <span style="font-size:5pt">c<p>h<p>e<p>c<p>k<p>&nbsp;<p>v<p>a<p>l<p>u<p>e</span>
                    </td>
                    <td>
                        <b>
                            <span style="text-transform:uppercase">tmk</span>
                        </b>
                    </td>
                    <td>
                        <b>
                            <span style="text-transform:uppercase">tpk</span>
                        </b>
                    </td>
                    <td rowspan="4">
                        <span style="font-size:5pt">у<p>н<p>и<p>ч<p>т<p>о<p>ж<p>е<p>н<p>и<p>е</span>
                    </td>
                    <td rowspan="4" style="vertical-align:bottom;"><?= printDateDel($key) ?></td>
                    <td rowspan="4" style="vertical-align:bottom;"><?= printDateDel($key) ?></td>
                    <td rowspan="4" style="vertical-align:bottom;"><?= printDateDel($key) ?></td>
                    <td rowspan="4">
                        <span style="font-size:5pt">у<p>н<p>и<p>ч<p>т<p>о<p>ж<p>е<p>н<p>и<p>е</span>
                    </td>
                    <td rowspan="4" style="vertical-align:bottom;"><?= printDateDel($key) ?></td>
                </tr>
                <tr>
                    <td><?= printCheck($key, 'TMK') ?></td>
                    <td><?= printCheck($key, 'TPK') ?></td>
                </tr>
                <tr>
                    <td>
                        <b>
                            <span style="text-transform:uppercase">tdk</span>
                        </b>
                    </td>
                    <td>
                        <b>
                            <span style="text-transform:uppercase">tak</span>
                        </b>
                    </td>
                </tr>
                <tr>
                    <td><?= printCheck($key, 'TDK') ?></td>
                    <td><?= printCheck($key, 'TAK') ?></td>
                </tr>
            </table>
            <p>
            <?php } ?>
    </body>
</html>
