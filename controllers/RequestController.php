<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\request\RequestSearch;

class RequestController extends Controller {

	public $defaultAction = 'actived';
	public $ControllerMenu = 'request';

	public function actionActived() {
		return $this->actActClo();
		$model = arRequest::find()->actived()->with('texts');
		return $this->render('request', ['model' => $model]);
	}

	public function actionClosed() {
		return $this->actActClo();
		$model = arRequest::find()->closed()->with('texts');
		return $this->render('request', ['model' => $model]);
	}

	private function actActClo() {
		$searchModel = new RequestSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->get());
		return $this->render('request', [
				'dataProvider' => $dataProvider,
				'searchModel' => $searchModel
		]);
	}

	
}
