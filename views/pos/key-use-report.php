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
        <div class=WordSection1>
            <?php
            foreach ($model as $key) {
                ?>
                <div align=center>
                    <table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0 width=939
                           style='width:704.35pt;border-collapse:collapse;border:none'>
                        <tr style='height:12.75pt'>
                            <td width=401 nowrap colspan=5 rowspan=2 style='width:300.9pt;border-top:
                                1.5pt;border-left:1.5pt;border-bottom:1.0pt;border-right:1.0pt;border-color:
                                windowtext;border-style:solid;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt'>
                                <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'>
                                    <b>
                                        <span style='font-size:10.0pt'>Серийный номер: <u><?= $key->Number ?></u>
                                        </span>
                                    </b>
                                </p>
                            </td>
                            <td width=331 nowrap colspan=2 rowspan=2 style='width:248.0pt;border-top:
                                solid windowtext 1.5pt;border-left:none;border-bottom:solid windowtext 1.0pt;
                                border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt'>
                                <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'>
                                    <b>
                                        <span style='font-size:10.0pt'>Terminal_Id: <u><?= (($key->pos === null) ? "________" : $key->pos->TerminalID) ?></u>
                                        </span>
                                    </b>
                                    <span style='font-size:6.0pt;text-transform:uppercase'>Компрометация: </span>
                                </p>
                            </td>
                            <td width=170 colspan=2 rowspan=2 style='width:127.2pt;border-top:solid windowtext 1.5pt;
                                border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <b>
                                        <span lang=EN-US style='font-size:10.0pt'>POS</span>
                                    </b>
                                </p>
                            </td>
                            <td width=38 nowrap style='width:28.25pt;border-top:solid windowtext 1.5pt;
                                border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <b>
                                        <s>
                                            <span style='font-size:6.0pt'>DES</span>
                                        </s>
                                    </b>
                                </p>
                            </td>
                        </tr>
                        <tr style='height:12.75pt'>
                            <td width=38 style='width:28.25pt;border-top:none;border-left:none;
                                border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <b>
                                        <span style='font-size:6.0pt'>TDES</span>
                                    </b>
                                </p>
                            </td>
                        </tr>
                        <tr style='height:10.1pt'>
                            <td width=40 nowrap style='width:29.75pt;border-top:none;border-left:solid windowtext 1.5pt;
                                border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:10.1pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <span style='font-size:6.0pt'>&nbsp;</span>
                                </p>
                            </td>
                            <td width=173 nowrap colspan=2 style='width:129.85pt;border-top:none;
                                border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:10.1pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <span style='font-size:6.0pt;text-transform:uppercase'>Ответственный за настройку</span>
                                </p>
                            </td>
                            <td width=40 nowrap style='width:29.75pt;border-top:none;border-left:none;
                                border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:10.1pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <span style='font-size:6.0pt;text-transform:uppercase'>&nbsp;</span>
                                </p>
                            </td>
                            <td width=479 nowrap colspan=3 style='width:359.55pt;border-top:none;
                                border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:10.1pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <span style='font-size:6.0pt;text-transform:uppercase'>Ответственные за получение и загрузку ОКТМК</span>
                                </p>
                            </td>
                            <td width=40 nowrap style='width:29.75pt;border-top:none;border-left:none;
                                border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:10.1pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <span style='font-size:6.0pt'>&nbsp;</span>
                                </p>
                            </td>
                            <td width=168 nowrap colspan=2 style='width:125.7pt;border-top:none;
                                border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:10.1pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <span style='font-size:6.0pt;text-transform:uppercase'>ответственный наблюдатель</span>
                                </p>
                            </td>
                        </tr>
                        <tr style='height:3.6pt'>
                            <td width=40 nowrap rowspan=2 style='width:29.75pt;border-top:none;
                                border-left:solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;
                                border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:3.6pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <b>
                                        <sup>
                                            <span style='font-size:6.0pt;text-transform:uppercase'>Фамилия И.О.</span>
                                        </sup>
                                    </b>
                                </p>
                            </td>
                            <td width=173 nowrap colspan=2 style='width:129.85pt;border:none;border-right:
                                solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:3.6pt'>
                                <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'></p>
                            </td>
                            <td width=40 nowrap rowspan=2 style='width:29.75pt;border-top:none;
                                border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:3.6pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <b>
                                        <sup>
                                            <span style='font-size:6.0pt;text-transform:uppercase'>Фамилия И.О.</span>
                                        </sup>
                                    </b>
                                </p>
                            </td>
                            <td width=149 nowrap style='width:111.55pt;border:none;border-right:solid windowtext 1.0pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:3.6pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <sup>
                                        <span style='font-size:8.0pt;'>1-ая</span>
                                    </sup>
                                </p>
                            </td>
                            <td width=165 nowrap style='width:124.0pt;border:none;border-right:solid windowtext 1.0pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:3.6pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <sup>
                                        <span style='font-size:8.0pt;'>2-ая</span>
                                    </sup>
                                </p>
                            </td>
                            <td width=165 nowrap style='width:124.0pt;border:none;border-right:solid windowtext 1.0pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:3.6pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <sup>
                                        <span style='font-size:8.0pt;'>3-я</span>
                                    </sup>
                                </p>
                            </td>
                            <td width=40 nowrap rowspan=2 style='width:29.75pt;border-top:none;
                                border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:3.6pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <b>
                                        <sup>
                                            <span style='font-size:6.0pt;text-transform:uppercase'>Фамилия И.О.</span>
                                        </sup>
                                    </b>
                                </p>
                            </td>
                            <td width=168 nowrap colspan=2 style='width:125.7pt;border:none;border-right:
                                solid windowtext 1.5pt;padding:0cm 5.4pt 0cm 5.4pt;height:3.6pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'></p>
                            </td>
                        </tr>
                        <tr style='height:25.05pt'>
                            <td width=173 nowrap colspan=2 style='width:129.85pt;border-top:none;
                                border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:25.05pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <span style='font-size:10.0pt;'>Курочкин А.С.</span>
                                </p>
                            </td>
                            <td width=149 nowrap style='width:111.55pt;border-top:none;border-left:none;
                                border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:25.05pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <span style='font-size:10.0pt;'>Ротарь С.А.</span>
                                </p>
                            </td>
                            <td width=165 nowrap style='width:124.0pt;border-top:none;border-left:none;
                                border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:25.05pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <span style='font-size:10.0pt;'>Курочкин А.С.</span>
                                </p>
                            </td>
                            <td width=165 nowrap style='width:124.0pt;border-top:none;border-left:none;
                                border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:25.05pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <span style='font-size:10.0pt;'>Зуев Ю.С.</span>
                                </p>
                            </td>
                            <td width=168 nowrap colspan=2 style='width:125.7pt;border-top:none;
                                border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:25.05pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <span style='font-size:10.0pt;'>Бурлак В.Г.</span>
                                </p>
                            </td>
                        </tr>
                        <tr style='page-break-inside:avoid;height:39.7pt'>
                            <td width=40 nowrap style='width:29.75pt;border-top:none;border-left:solid windowtext 1.5pt;
                                border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:39.7pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <b>
                                        <sup>
                                            <span style='font-size:6.0pt;text-transform:uppercase'>Вскрытие МСК</span>
                                        </sup>
                                    </b>
                                </p>
                            </td>
                            <td width=173 nowrap colspan=2 valign=bottom style='width:129.85pt;
                                border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;
                                border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:39.7pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <span style='font-size:8.0pt;'><?= printDate($key) ?></span>
                                </p>
                            </td>
                            <td width=40 nowrap style='width:29.75pt;border-top:none;border-left:none;
                                border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:39.7pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <b>
                                        <sup>
                                            <span style='font-size:6.0pt;text-transform:uppercase'>Вскрытие МСК</span>
                                        </sup>
                                    </b>
                                </p>
                            </td>
                            <td width=149 nowrap valign=bottom style='width:111.55pt;border-top:none;
                                border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:39.7pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <span style='font-size:8.0pt;'><?= printDate($key) ?></span>
                                </p>
                            </td>
                            <td width=165 nowrap valign=bottom style='width:124.0pt;border-top:none;
                                border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:39.7pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <span style='font-size:8.0pt;'><?= printDate($key) ?></span>
                                </p>
                            </td>
                            <td width=165 nowrap valign=bottom style='width:124.0pt;border-top:none;
                                border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:39.7pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <span style='font-size:8.0pt;'><?= printDate($key) ?></span>
                                </p>
                            </td>
                            <td width=40 nowrap style='width:29.75pt;border-top:none;border-left:none;
                                border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:39.7pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <b>
                                        <sup>
                                            <span style='font-size:6.0pt;text-transform:uppercase'>коментарий</span>
                                        </sup>
                                    </b>
                                </p>
                            </td>
                            <td width=168 nowrap colspan=2 valign=bottom style='width:125.7pt;border-top:
                                none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:39.7pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'></p>
                            </td>
                        </tr>
                        <tr style='page-break-inside:avoid;height:19.85pt'>
                            <td width=40 nowrap rowspan=2 style='width:29.75pt;border-top:none;
                                border-left:solid windowtext 1.5pt;border-bottom:solid windowtext 1.5pt;
                                border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:19.85pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <b>
                                        <sup>
                                            <span style='font-size:6.0pt;text-transform:uppercase'>Check Value</span>
                                        </sup>
                                    </b>
                                </p>
                            </td>
                            <td width=89 nowrap valign=top style='width:66.65pt;border-top:none;
                                border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:19.85pt'>
                                <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'>
                                    <b>
                                        <span style='font-size:8.0pt'>TMK</span>
                                    </b>
                                </p>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <span lang=EN-US style='font-size:8.0pt;'><?= printCheck($key,'TMK') ?></span>
                                </p>
                            </td>
                            <td width=84 nowrap valign=top style='width:63.2pt;border-top:none;
                                border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:19.85pt'>
                                <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'>
                                    <b>
                                        <span style='font-size:8.0pt'>TPK</span>
                                    </b>
                                </p>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <span lang=EN-US style='font-size:8.0pt;'><?= printCheck($key,'TPK') ?></span>
                                </p>
                            </td>
                            <td width=40 nowrap rowspan=2 style='width:29.75pt;border-top:none;
                                border-left:none;border-bottom:solid windowtext 1.5pt;border-right:solid windowtext 1.0pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:19.85pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <b>
                                        <sup>
                                            <span style='font-size:6.0pt;text-transform:uppercase'>Уничтожение</span>
                                        </sup>
                                    </b>
                                </p>
                            </td>
                            <td width=149 nowrap rowspan=2 valign=bottom style='width:111.55pt;
                                border-top:none;border-left:none;border-bottom:solid windowtext 1.5pt;
                                border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:19.85pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <span style='font-size:8.0pt;'><?= printDateDel($key) ?></span>
                                </p>
                            </td>
                            <td width=165 nowrap rowspan=2 valign=bottom style='width:124.0pt;border-top:
                                none;border-left:none;border-bottom:solid windowtext 1.5pt;border-right:solid windowtext 1.0pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:19.85pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <span style='font-size:8.0pt;'><?= printDateDel($key) ?></span>
                                </p>
                            </td>
                            <td width=165 nowrap rowspan=2 valign=bottom style='width:124.0pt;border-top:
                                none;border-left:none;border-bottom:solid windowtext 1.5pt;border-right:solid windowtext 1.0pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:19.85pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <span style='font-size:8.0pt;'><?= printDateDel($key) ?></span>
                                </p>
                            </td>
                            <td width=40 nowrap rowspan=2 style='width:29.75pt;border-top:none;
                                border-left:none;border-bottom:solid windowtext 1.5pt;border-right:solid windowtext 1.0pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:19.85pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <b>
                                        <sup>
                                            <span style='font-size:6.0pt;text-transform:uppercase'>Уничтожение</span>
                                        </sup>
                                    </b>
                                </p>
                            </td>
                            <td width=168 nowrap colspan=2 rowspan=2 valign=bottom style='width:125.7pt;
                                border-top:none;border-left:none;border-bottom:solid windowtext 1.5pt;
                                border-right:solid windowtext 1.5pt;padding:0cm 5.4pt 0cm 5.4pt;height:19.85pt'>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <span style='font-size:8.0pt;'><?= printDateDel($key) ?></span>
                                </p>
                            </td>
                        </tr>
                        <tr style='height:19.85pt'>
                            <td width=89 valign=top style='width:66.65pt;border-top:none;border-left:
                                none;border-bottom:solid windowtext 1.5pt;border-right:solid windowtext 1.0pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:19.85pt'>
                                <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'>
                                    <b>
                                        <span style='font-size:8.0pt'>TDK</span>
                                    </b>
                                </p>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <span lang=EN-US style='font-size:8.0pt;'><?= printCheck($key,'TDK') ?></span>
                                </p>
                            </td>
                            <td width=84 nowrap valign=top style='width:63.2pt;border-top:none;
                                border-left:none;border-bottom:solid windowtext 1.5pt;border-right:solid windowtext 1.0pt;
                                padding:0cm 5.4pt 0cm 5.4pt;height:19.85pt'>
                                <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'>
                                    <b>
                                        <span style='font-size:8.0pt'>TAK</span>
                                    </b>
                                </p>
                                <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                                    <span lang=EN-US style='font-size:8.0pt;'><?= printCheck($key,'TAK') ?></span>
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php } ?>
        </div>
    </body>
</html>
