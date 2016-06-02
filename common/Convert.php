<?php

namespace app\common;

use Yii;

/**
 * Description of toStr
 *
 * @author proph
 */
class Convert {

	static public function Exception2Str(\Exception $e) {
		return 'Message: ' . $e->getMessage() . ' in [' .
			str_replace(Yii::getAlias('@app') . '/', '', $e->getFile()) . ':' . $e->getLine() . ']';
	}

	const MailDateFormat = "/(?'day'\d{2})[\.\/\-](?'mon'\d{2})[\.\/\-](?'year'\d{2,4})\s+?(?'hour'\d{2}):(?'min'\d{2}):(?'sec'\d{2})/i";

	static public function MailDate2SQLiteDate($inDate) {
		if (preg_match(self::MailDateFormat, $inDate, $m) > 0) {
			if ($m['year'] < 100) {
				$m['year'] += 2000;
			}

			return "{$m['year']}-{$m['mon']}-{$m['day']} {$m['hour']}:{$m['min']}:{$m['sec']}";
		}

		return null;
	}

}
