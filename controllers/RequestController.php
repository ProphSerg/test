<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\request\RequestSearch;
use app\models\request\arRequest;
use app\models\request\arReqText;
use app\models\request\RequestMan;
use kartik\mpdf\Pdf;
use yii\data\ActiveDataProvider;

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
		$modelComment = new arReqText();
		$post = Yii::$app->request->post();
		if (isset($post['reqCloseBtn']) && $modelComment->load($post)) {
			$modelComment->RequestID = $id;
			$modelComment->closeRequest();
			$this->redirect(['actived']);
		} elseif (isset($post['reqAddCommentBtn']) && $modelComment->load($post)) {
			$modelComment->RequestID = $id;
			$modelComment->Date = null;
			$modelComment->addComment();
		}

		$model = $this->findModel($id);
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

	public function actionAdd($type) {
		$model = new RequestMan($type);
		$post = Yii::$app->request->post();
		#var_dump($post);
		if ($model->load($post)) {
			$model->addReq();
			$this->redirect(['detail', 'id' => $model->ID]);
		}

		return $this->render('add', [
				'model' => $model,
				]
		);
	}

	public function actionPrint($type) {
		$query = arRequest::find();
		call_user_func([$query, $type]);
		#$query->joinWith('texts');

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'Date' => SORT_ASC,
				],
			],
			'pagination' => false,
		]);

		/*
		return $this->renderPartial('print', [
				'dataProvider' => $dataProvider,
				'type' => $type]);
		 * 
		 */
		
		$pdf = new Pdf([
			'mode' => Pdf::MODE_UTF8,
			'format' => Pdf::FORMAT_A4,
			#'orientation' => Pdf::ORIENT_LANDSCAPE,
			'cssFile' => '@app/views/request/print.css',
			'content' => $this->renderPartial('print', [
				'dataProvider' => $dataProvider,
				'type' => $type,
			]),
			'methods' => [
				'SetHeader' => ($type == 'actived' ? 'Активные заявки' : 'Закрытые заявки') . '||' . date('r'),
				'SetFooter' => '||стр. {PAGENO}',
			]
		]);
		return $pdf->render();
	}

}
