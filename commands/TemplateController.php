<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use app\common\Convert;
use PhpOffice\PhpWord\TemplateProcessor;

/**
 * Команды работы с шаблонами (Word).
 */
class TemplateController extends Controller {

	/**
	 * Добавление ключей из файла (Excel)
	 * @param string $file Файл шаблона
	 */
	public function actionInfo($file) {
		$tp = new TemplateProcessor($file);
		echo "Show Variables:\n\t" . implode("\n\t", $tp->getVariables());
		echo "\n";
		return 0;
	}

}
