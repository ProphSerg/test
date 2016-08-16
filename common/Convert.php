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

	static public function ValidaterError2Str($model, $only = '', $exclude = '') {
		$str = '';
		foreach ($model->getErrors() as $a => $es) {
			if (($only == '' || $a == $only) && ($exclude == '' || $a != $exclude)) {
				$str .= "{$a}[{$model->$a}]: " . implode('. ', $es) . ".\n";
			}
		}

		return $str;
	}

	#dd/MM/YY(YY)( hh:mm:(ss))

	const AllFormat = ['!d#m#y H#i#s', '!d#m#Y H#i#s', '!d#m#y H#i', '!d#m#Y H#i', '!d#m#y', '!d#m#Y'];

	static public function Date2SQLiteDate($inDate, $format = self::AllFormat) {

		#var_dump($inDate);
		if (is_array($format)) {
			foreach ($format as $fr) {
				if (($dt = \DateTime::createFromFormat($fr, $inDate)) !== false) {
					#var_dump($dt);
					return self::DateTime2UTC($dt);
				}
			}
		} elseif (($dt = \DateTime::createFromFormat($format, $inDate)) !== false) {
			#var_dump($dt);
			return self::DateTime2UTC($dt);
		}
		return null;
	}

	static public function DateTime2UTC(\DateTime $date) {
		$date->setTimezone(new \DateTimeZone('UTC'));
		return $date->format(\DateTime::W3C);

		#return $date->getTimestamp();
	}

	static public function SQLiteDateNow() {
		#$date = new \DateTime();
		#var_dump($date->getTimezone()->getName());
		return self::DateTime2UTC(new \DateTime());
	}

	static public function KeyByGroup($key) {
		return implode(' ', [
			substr($key, 0, 4),
			substr($key, 4, 4),
			substr($key, 8, 4),
			substr($key, 12, 4),
			substr($key, 16, 4),
			substr($key, 20, 4),
			substr($key, 24, 4),
			substr($key, 28, 4)
		]);
	}

}
