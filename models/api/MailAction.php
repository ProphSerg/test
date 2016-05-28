<?php

namespace app\models\api;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;

/**
 * Description of PostMail
 *
 * @author proph
 */
class MailAction extends \yii\base\Action {

    public $checkAccess;

    private function pairAttr(\SimpleXMLElement $kids) {
	$r = [];
	foreach ($kids->attributes() as $a => $b) {
	    $r[] = (string) $a . "=" . (string) $b;
	}
	return implode(', ', $r);
    }

    private function logDebug(\SimpleXMLElement $items) {
	$fd = fopen("/Users/proph/Sites/debug.log", "a");

	fwrite($fd, ">>>" . (string) $items->noteinfo[0]['unid'] . "\n");
	foreach ($items->item as $item) {
	    fwrite($fd, (string) $item['name'] .
		    "\n===\n" . mb_convert_encoding(base64_decode(trim((string) $item)), 'UTF-8', 'UTF-16LE') .
		    "\n---------------------------------------------\n");
	    fwrite($fd, "====================================================================================\n\n");
	}
	fclose($fd);
    }

    private function logDebugMail(Mail $mail, $all = true) {
	$fd = fopen("/Users/proph/Sites/debugMail.log", "a");

	fwrite($fd, ">>>" . (string) $mail->UniversalID . "\n");
	if ($all == true) {
	    fwrite($fd, $mail->Body . "\n====================================================================================\n\n");
	}
	fclose($fd);
    }

    private function parse(\SimpleXMLElement $item) {
	return mb_convert_encoding(base64_decode(trim((string) $item)), 'UTF-8', 'UTF-16LE');
    }

    public function run() {
	if ($this->checkAccess) {
	    call_user_func($this->checkAccess, $this->id);
	}

	#echo Yii::$app->getRequest()->getRawBody();
	libxml_use_internal_errors(true);
	$XML = new \SimpleXMLElement(Yii::$app->getRequest()->getRawBody());
	if (!$XML) {
	    throw new ServerErrorHttpException('Failed to parse data. ' . implode('. ', libxml_get_errors()));
	}
	#$this->logDebug($XML);

	$mail = new Mail;
	$mail->UniversalID = (string) ($XML->noteinfo[0]['unid']);
	foreach ($XML->item as $item) {
	    #echo "|" . $item['name'] . "|\n";
	    #var_dump($item['name']);
	    $mail->{$item['name']} = $this->parse($item);
	}

	foreach (arMailPatt::find()->all() as $mp) {
	    #echo 'Pattern: ' . $mp->Pattern . "\n";
	    if (preg_match_all("/(\w+)\|(.+)\|/", $mp->Pattern, $matches, PREG_SET_ORDER) > 0) {
		foreach ($matches as $out) {
		    if (!isset($mail->{$out[1]})) {
			throw new ServerErrorHttpException('Ошибка примения шаблона. Поле ' . $out[1] . " не найдено!");
		    }
		    #echo "Patt: " . $out[2] . "| " . $mail->{$out[1]} . "\n";
		    if (preg_match($out[2], $mail->{$out[1]}) > 0) {
			$bp = arBodyPatt::find()->BP($mp)->one();
			#echo "Patt:\n" . trim(str_replace("\r", "", $bp->Pattern)) . "\n";
			#echo "Body:\n" . trim(str_replace("\r", "", $mail->Body)) . "\n";

			if (preg_match(trim(str_replace("\r", "", $bp->Pattern)), trim(str_replace("\r", "", $mail->Body)), $bmatch) > 0) {
			    $this->logDebugMail($mail, false);
			    #var_dump($bmatch);
			} else {
			    $this->logDebugMail($mail);
			}
			/*
			  if (class_exists("app\\models\\api\\Parse\\" . $mp->Model) &&
			  method_exists("app\\models\\api\\Parse\\" . $mp->Model, 'import')) {
			  call_user_func("app\\models\\api\\Parse\\" . $mp->Model . '::import', $mail);
			 *
			 */
		    }
		}
	    }
	}
	#return $mail;
	return false;
    }

}
