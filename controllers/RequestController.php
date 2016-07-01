<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\request\RequestSearch;
use app\models\request\arRequest;
use app\models\request\arReqText;

class RequestController extends Controller {

	public $defaultAction = 'actived';
	public $ControllerMenu = 'request';

	public function actionActived() {
		return $this->actActClo();
	}

	public function actionClosed() {
		return $this->actActClo();
	}

	private function actActClo() {
		$searchModel = new RequestSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->get());
		return $this->render('request', [
				'dataProvider' => $dataProvider,
				'searchModel' => $searchModel
		]);
	}

	public function actionDetail($id) {
		$model = $this->findModel($id);
		$modelComment = new arReqText();
		$post = Yii::$app->request->post();
		if(isset($post['reqCloseBtn']) && $modelComment->load($post)){
			$modelComment->RequestID = $id;
			$modelComment->closeRequest();
		}
		return $this->render('detail', [
				'model' => $model,
				]
		);
	}

	protected function findModel($id) {
		if (($model = arRequest::find()->where(['id' => $id])->with('texts')->one()) !== null) {
		#if (($model = arRequest::find()->where(['ID' => $id])->one()) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

}
