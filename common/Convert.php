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

	#dd/MM/YY(YY) hh:mm:ss
	const FullDateFormat = "/(?'day'\d{2})[\.\/\-](?'mon'\d{2})[\.\/\-](?'year'\d{2,4})\s+?(?'hour'\d{2}):(?'min'\d{2})(?::(?'sec'\d{2}))?/i";
	#dd/MM/YY(YY) hh:mm
	const noSecDateFormat = "/(?'day'\d{2})[\.\/\-](?'mon'\d{2})[\.\/\-](?'year'\d{2,4})\s+?(?'hour'\d{2}):(?'min'\d{2})/i";

	static public function Date2SQLiteDate($inDate, $format = self::FullDateFormat) {
		if (preg_match($format, $inDate, $m) > 0) {
			if ($m['year'] < 100) {
				$m['year'] += 2000;
			}

			if (!isset($m['sec'])) {
				$m['sec'] = '00';
			}

			return "{$m['year']}-{$m['mon']}-{$m['day']} {$m['hour']}:{$m['min']}:{$m['sec']}";
		}

		return null;
	}

}
