<?php

use yii\helpers\Html;

function printDate($k) {
    return (($k === null) ? "«____» __________ 20___ г." : Yii::$app->formatter->asDate($k, 'php:d/m/Y'));
}

function printDateDel($k, $ped, $add = 1) {
    if ($ped == false || $k === null) {
        return "«____» __________ 20___ г.";
    }
    $dt = new DateTime($k);
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
    </head>
    <body>

        <h2 style="text-align: center">
            <b>
                <span>Операционный офис «Омский»</span>
            </b>
        </h2>
        <h2 style="text-align: center">
            <b>
                <span>Филиала ПАО «УРАЛСИБ» в г.Новосибирск</span>
            </b>
        </h2>

        <p>
        <h3 style="text-align: center">
            <span>Группа поддержки пользователей и сопровождения платежных систем в г. Омск</span>
        </h3>

        <p><p><p><p><p><p><p><p><p><p><p><p>
        <h3 style="text-align: center">
            <b>
                <span>ЖУРНАЛ</span>
            </b>
        </h3>
        <h3 style="text-align: center">
                <span>регистрации ключей для устройств, обслуживающих МБК</span>
        </h3>

        <p><p><p><p><p><p><p><p><p><p><p><p>
        <table  class="key-title">
            <tr style="vertical-align:bottom;">
                <td align="right">
                    <span>Начат</span>
                </td>
                <td style="width:2%"></td>
                <td align="right" style="width:25%">
                    <span><?= printDate($model->MinDate) ?></span>
                </td>
            </tr>
            <tr><td></td><td></td><td></td></tr>
            <tr style="vertical-align:bottom;" height="100px">
                <td align="right" >
                    <span>Окончен</span>
                </td>
                <td></td>
                <td align="right" >
                    <span><?= printDateDel($model->MaxDate, $printEndDate) ?></span>
                </td>
            </tr>
        </table>
</body>

</html>