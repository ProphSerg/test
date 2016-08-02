<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\atm\ATMOrder;
use app\models\atm\ATMOrderSearch;
use app\models\atm\arSprATMOrderTech;
use yii\data\ActiveDataProvider;

class AtmController extends Controller {

	public $defaultAction = 'orders';
	public $ControllerMenu = 'atm';

	public function actionOrders() {
		$searchModel = new ATMOrderSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->get());
		$tech = arSprATMOrderTech::find()->all();
		return $this->render('orders', [
				'dataProvider' => $dataProvider,
				'searchModel' => $searchModel,
				'techList' => $tech,
		]);
	}

	protected function findModel($id) {
		if (($model = arRequest::find()->where(['id' => $id])->with('texts')->one()) !== null) {
			#if (($model = arRequest::find()->where(['ID' => $id])->one()) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	public function actionTechs() {
		$tech = arSprATMOrderTech::find();
		$dataProvider = new ActiveDataProvider([
			'query' => $tech,
		]);
		return $this->render('techs', [
				'dataProvider' => $dataProvider,
		]);
	}

	/*
	  public function actionOrderRemarks() {
	  if (isset($_POST['expandRowKey'])) {
	  $model = \app\models\Book::findOne($_POST['expandRowKey']);
	  return $this->renderPartial('_book-details', ['model' => $model]);
	  } else {
	  return '<div class="alert alert-danger">No data found</div>';
	  }
	  }
	 * 
	 */
}
