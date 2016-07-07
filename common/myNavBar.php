<?php

namespace app\common;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Yii;
use yii\helpers\ArrayHelper;
use yii\bootstrap\NavBar;
use yii\bootstrap\BootstrapPluginAsset;
use yii\helpers\Html;

class myNavBar extends NavBar {

	public $ContainerEnds;

	/**
	 * Renders the widget.
	 */
	public function run() {
		$tag = ArrayHelper::remove($this->containerOptions, 'tag', 'div');
		echo Html::endTag($tag);
		if ($this->renderInnerContainer) {
			echo Html::endTag('div');
		}

		if (isset($this->ContainerEnds)) {
			echo $this->ContainerEnds;
		}
		$tag = ArrayHelper::remove($this->options, 'tag', 'nav');
		echo Html::endTag($tag);
		BootstrapPluginAsset::register($this->getView());
	}

}
