<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use app\common\Convert;
use PhpOffice\PhpWord\IOFactory;

/**
 * Команды работы с шаблонами (Word).
 */
class TemplateController extends Controller {

	/**
	 * Добавление ключей из файла (Excel)
	 * @param string $file Файл шаблона
	 */
	public function actionInfo($file) {
		$tp = IOFactory::load($file, 'MsDoc');
		#var_dump($tp);
		echo "Show Sections:\n";
		$i = 0;
		foreach ($tp->getSections() as $sN => $s) {
			echo "Section: " . $i++ . "({$sN})\n";
			echo "\tSectionId: {$s->getSectionId()}\n";
			echo "\tDocPart: {$s->getDocPart()}\n";
			echo "\tDocPartID: {$s->getDocPartId()}\n";
			echo "\tElementId: {$s->getElementId()}\n";
			$j = 0;
			foreach ($s->getElements() as $eN => $e) {
				echo "\tElement: " . $j++ . "({$eN})\n";
				echo "\t\tClass: " . get_class($e) . "\n";
				echo "\t\tText: {$e->getText()}\n";
			}
		}
		#echo "Show Sections:\n\t" . implode("\n\t", $tp->getSections());
		#echo "\n";
		return 0;
	}

}
