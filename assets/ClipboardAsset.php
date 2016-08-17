<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use Yii;
use yii\web\AssetBundle;
use yii\helpers\Html;

class ClipboardAsset extends AssetBundle {

	public $sourcePath = '@bower/clipboard/dist';
	public $js = [
		'clipboard.js',
	];
	public $jsOptions = [
		'position' => \yii\web\View::POS_BEGIN,
	];

	static public function Instantiate($obj, $param = 'btnClip') {
		$obj->registerJs("new Clipboard('{$param}');", \yii\web\View::POS_BEGIN);
	}

	static public function buttonCopy($id, $size = 13) {
		return Html::button(
				Html::img(['/images/clippy.svg'], ['width' => $size]), [
				'class' => 'btn btnClip',
				'style' => ['border: none; background: transparent;'],
				'data-clipboard-target' => '#clip_' . $id,
		]);
	}

	static public function buttonCopyText($value, $id, $btnSize = 13) {

		return (($value === null) || ($value == '') ? null : self::buttonCopy($id, $btnSize) .
				Html::tag('span', $value, ['id' => 'clip_' . $id]));
	}

}
