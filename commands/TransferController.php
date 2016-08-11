<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use app\models\pos\arKey;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class TransferController extends Controller {

	public function actionKeysDelete() {
		if(!arKey::isExist()){
			return 1;
		}
		$keys = new arKey();
		$keys->deleteAll();

		return 0;
	}

	private static function printValidaterError($model) {
		foreach ($model->getErrors() as $a => $es) {
			if ($a == 'Check') {
				echo "{$a}[{$model->$a}]: " . implode('. ', $es) . ".\n";
			}
		}
	}

	public function actionKeysAdd($file, $sheet, array $field) {
		if(!arKey::isExist()){
			return 1;
		}
		$fld = [];
		foreach ($field as $f) {
			if (($p = strpos($f, '=')) !== false) {
				$fld[substr($f, 0, $p)] = substr($f, $p + 1);
			}
		}
		#var_dump($field);
		#var_dump(array_keys($fld));

		$reader = \PHPExcel_IOFactory::createReader('Excel5');
		$reader->setReadFilter(new readFilter(array_keys($fld)));
		$reader->setLoadSheetsOnly($sheet);
		$xls = $reader->load($file);
		/*
		  $xls = \PHPExcel_IOFactory::load($file);
		  $xls->setActiveSheetIndexByName($sheet);
		 * 
		 */
		$xls_sheet = $xls->getActiveSheet();
		$kn=0;
		for ($i = 1; $i <= $xls_sheet->getHighestRow(); $i++) {
			echo "Row: {$i} ... ";

			$k = new arKey();
			foreach ($fld as $c => $f) {
				$k->$f = $xls_sheet->getCell($c . $i)->getValue();
				#echo $cell->getColumn() . '(' . $cell->getValue() . ') ';
			}
			if ($k->validate() == false) {
				self::printValidaterError($k);
			}

			$k->save() && $kn++;

			echo "\r";
		}
		echo "\nDone.\nAdded {$kn} keys\n";
		return 0;
	}

}

class readFilter implements \PHPExcel_Reader_IReadFilter {

	private $_col = [];

	function __construct(array $col) {
		$this->_col = $col;
		#parent::__construct();
	}

	public function readCell($column, $row, $worksheetName = '') {
		if (in_array($column, $this->_col)) {
			return true;
		}
		return false;
	}

}
