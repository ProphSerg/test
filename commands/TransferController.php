<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use app\models\pos\arKey;
use app\models\pos\arRegPos;
use app\common\Convert;

/**
 * Команды ручного переноса данных.
 */
class TransferController extends Controller {

	/**
	 * Удаление ключей
	 */
	public function actionKeysDelete() {
		if (!arKey::isExist()) {
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

	/**
	 * Добавление ключей из файла (Excel)
	 * @param string $file Файл с ключами
	 * @param string $sheet Название листа
	 * @param string $field Соответствие колонки в файле полю в базе col1=field1,..,colN=fieldN. 
	 * Обязательные поля Number,Comp1,Comp2,Comp3. 
	 * Рекомендуемое поле Check, для проверки ключей.
	 */
	public function actionKeysAdd($file, $sheet, array $field) {
		if (!arKey::isExist()) {
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

		$reader = \PHPExcel_IOFactory::createReader(self::extensionType($file));
		$reader->setReadFilter(new readFilter(array_keys($fld)));
		$reader->setLoadSheetsOnly($sheet);
		$xls = $reader->load($file);
		/*
		  $xls = \PHPExcel_IOFactory::load($file);
		  $xls->setActiveSheetIndexByName($sheet);
		 * 
		 */
		$xls_sheet = $xls->getActiveSheet();
		$kn = 0;
		for ($i = 1; $i <= $xls_sheet->getHighestRow(); $i++) {
			echo "Row: {$i} ... ";

			$k = new arKey();
			foreach ($fld as $c => $f) {
				$k->$f = $xls_sheet->getCell($c . $i)->getValue();
				#echo $cell->getColumn() . '(' . $cell->getValue() . ') ';
			}

			if( !($k->Comp1 === null || $k->Comp1 == '' ||
			    $k->Comp2 === null || $k->Comp2 == '' ||
			    $k->Comp3 === null || $k->Comp3 == '')) {

			    if ($k->validate() == false) {
					echo Convert::ValidaterError2Str($k);
				}

				$k->save() && $kn++;
			}
			echo "\r";
		}
		echo "\nDone.\nAdded {$kn} keys\n";
		return 0;
	}

	/**
	 * Удаление регданных
	 */
	public function actionRegDelete() {
		$regp = new arRegPos();
		$regp->deleteAll();

		return 0;
	}

	/**
	 * Добавление ключей из файла (Excel)
	 * @param string $file Файл с регданными
	 * @param string $sheet Название листа
	 * @param string $field Соответствие колонки в файле полю в базе col1=field1,..,colN=fieldN. 
	 * Обязательные поля ClientN,Name,ContractN,TerminalID,Address,MerchantID,KeyNum,TMK_CHECK,TPK_KEY,TAK_KEY,TDK_KEY
	 * Рекомендуемые поля City,TPK_CHECK,TAK_CHECK,TDK_CHECK.
	 */
	public function actionRegAdd($file, $sheet, array $field) {

		$fld = [];
		foreach ($field as $f) {
			if (($p = strpos($f, '=')) !== false) {
				$fld[substr($f, $p + 1)] = substr($f, 0, $p);
			}
		}
		#var_dump($field);
		#var_dump($fld);

		$reader = \PHPExcel_IOFactory::createReader(self::extensionType($file));
		$reader->setReadFilter(new readFilter(array_values($fld)));
		$reader->setLoadSheetsOnly($sheet);
		$xls = $reader->load($file);
		/*
		  $xls = \PHPExcel_IOFactory::load($file);
		  $xls->setActiveSheetIndexByName($sheet);
		 * 
		 */
		$xls_sheet = $xls->getActiveSheet();
		$kn = 0;
		for ($i = 1; $i <= $xls_sheet->getHighestRow(); $i++) {
			echo "Row: {$i} ... ";

			$k = arRegPos::find()->findReg(
				$xls_sheet->getCell($fld['TerminalID'] . $i)->getValue(), $xls_sheet->getCell($fld['KeyNum'] . $i)->getValue()
			);
			if ($k === null) {
				$k = new arRegPos();
			}
			foreach ($fld as $f => $c) {
				$k->$f = $xls_sheet->getCell($c . $i)->getValue();
				#echo "Cell({$c}{$i}): " . $xls_sheet->getCell($c . $i)->getValue();
			}
			if ($k->TMK_CHECK === null || $k->TMK_CHECK == '') {
				$k->TMK_CHECK = '000000';
			}
			if ($k->validate() == false) {
				#echo Convert::ValidaterError2Str($k);
			}

			$k->save() && $kn++;

			echo "\r";
		}
		echo "\nDone.\nAdded {$kn} registration\n";
		return 0;
	}

	private static function extensionType($pFilename) {

		// First, lucky guess by inspecting file extension
		$pathinfo = pathinfo($pFilename);

		$extensionType = NULL;
		if (isset($pathinfo['extension'])) {
			switch (strtolower($pathinfo['extension'])) {
				case 'xlsx':  //      Excel (OfficeOpenXML) Spreadsheet
				case 'xlsm':  //      Excel (OfficeOpenXML) Macro Spreadsheet (macros will be discarded)
				case 'xltx':  //      Excel (OfficeOpenXML) Template
				case 'xltm':  //      Excel (OfficeOpenXML) Macro Template (macros will be discarded)
					$extensionType = 'Excel2007';
					break;
				case 'xls':  //      Excel (BIFF) Spreadsheet
				case 'xlt':  //      Excel (BIFF) Template
					$extensionType = 'Excel5';
					break;
				case 'ods':  //      Open/Libre Offic Calc
				case 'ots':  //      Open/Libre Offic Calc Template
					$extensionType = 'OOCalc';
					break;
				case 'slk':
					$extensionType = 'SYLK';
					break;
				case 'xml':  //      Excel 2003 SpreadSheetML
					$extensionType = 'Excel2003XML';
					break;
				case 'gnumeric':
					$extensionType = 'Gnumeric';
					break;
				case 'htm':
				case 'html':
					$extensionType = 'HTML';
					break;
				case 'csv':
					// Do nothing
					// We must not try to use CSV reader since it loads
					// all files including Excel files etc.
					break;
				default:
					break;
			}

			return $extensionType;
		}
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
