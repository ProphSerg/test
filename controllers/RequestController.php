<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\request\arRequest;

class RequestController extends Controller {

	public $defaultAction = 'actived';
	public $ControllerMenu = 'request';

	public function actionActived() {
		$model = arRequest::find()->actived()->with('texts');
		return $this->render('request', ['model' => $model]);
	}

	public function actionClosed() {
		$model = arRequest::find()->closed()->with('texts');
		return $this->render('request', ['model' => $model]);
	}

}
