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

	static public
		function SQLiteDateNow() {
		#$date = new \DateTime();
		#var_dump($date->getTimezone()->getName());
		return self::DateTime2UTC(new \DateTime());
	}

}
