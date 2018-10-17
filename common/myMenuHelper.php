<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common;

use mdm\admin\components\MenuHelper;
use mdm\admin\models\Menu;
use yii\helpers\Html;
use Yii;

/**
 * Description of newPHPClass
 *
 * @author proph
 */
class myMenuHelper extends MenuHelper {

	public static function getAssignedMenuByName($userId, $root = null, $refresh = false) {
		if ($root === null) {
			$rootid = null;
		} else {
			$mn = Menu::find()->where(['name' => $root])->one();
			if ($mn === false) {
				return false;
			}
			$rootid = $mn->id;
		}
		return parent::getAssignedMenu($userId, $rootid, 'app\common\myMenuHelper::CallbackAssignedMenu', $refresh);
	}

	public static function CallbackAssignedMenu($menu) {
		if (preg_match('/^CODE:(.+)/u', $menu['name'], $match) > 0) {
			return eval($match[1]);
		}
                
		if (preg_match('/^CODE:(.+)/u', $menu['data'], $match) > 0) {
			$data = eval($match[1]);
			#var_dump($data);
		} else {
			$data = [$menu['data']];
		}
		return [
			'label' => $menu['name'],
			'url' => [$menu['route']],
			'options' => $data,
			'items' => $menu['children'],
		];
	}

}
