<?php

foreach ($model as $r) {
	echo "<p>" . Yii::$app->formatter->asDatetime($r->Date, 'php:d/m/Y H:i') . " : " . $r->Text;
}