<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use Yii;
use yii\web\AssetBundle;

class ClipboardAsset extends AssetBundle {

	public $sourcePath = '@bower/clipboard/dist';
	public $js = [
		'clipboard.js',
	];

	static public function Instantiate($obj, $param) {
		$obj->registerJs("new Clipboard('{$param}');");
	}

}
