<?php

namespace app\controllers;

class InfoController extends \yii\web\Controller
{
 	public $defaultAction = 'phpinfo';
	public $ControllerMenu = 'systemInfo';

	public function actionPhpinfo()
    {
        return $this->render('phpinfo');
    }

}
