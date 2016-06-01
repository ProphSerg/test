<?php

namespace app\common;

use Yii;

class myFileTarget extends \yii\log\FileTarget {

	/**
	 * Formats a log message for display as a string.
	 * @param array $message the log message to be formatted.
	 * The message structure follows that in [[Logger::messages]].
	 * @return string the formatted message
	 */
	public function formatMessage($message) {
		list($text, $level, $category, $timestamp) = $message;
		$level = \yii\log\Logger::getLevelName($level);
		if (!is_string($text)) {
			// exceptions may not be serializable if in the call stack somewhere is a Closure
			if ($text instanceof \Throwable || $text instanceof \Exception) {
				$text = (string) $text;
			} else {
				$text = \yii\helpers\VarDumper::export($text);
			}
		}
		$traces = [];
		if (isset($message[4])) {
			foreach ($message[4] as $trace) {
				$traces[] = '(' . str_replace(Yii::getAlias('@app') . '/', '', $trace['file']) . ":{$trace['line']})";
			}
		}

		if ($this->prefix === false) {
			$prefix = '';
		} else {
			$prefix = ' ' . $this->getMessagePrefix($message) . "[$level][$category]";
		}

		return date('d-m-Y H:i:s', $timestamp) . "\t{$prefix} $text"
			. (empty($traces) ? '' : "\n\t\t" . implode("\n\t\t", $traces));
	}

}
