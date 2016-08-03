<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use kartik\grid\EditableColumnAction;
use app\models\atm\ATMOrder;
use app\models\atm\ATMOrderSearch;
use app\models\atm\arSprATMOrderTech;
use app\models\atm\arSprATM;

class AtmController extends Controller {

	public $defaultAction = 'orders';
	public $ControllerMenu = 'atm';

	public function actions() {
		return ArrayHelper::merge(parent::actions(), [
				'edittech' => [									   // identifier for your editable column action
					'class' => EditableColumnAction::className(), // action class name
					'modelClass' => arSprATMOrderTech::className(), // the model for the record being edited
					/*
					'outputValue' => function ($model, $attribute, $key, $index) {
						return (int) $model->$attribute / 100;	  // return any custom output value if desired
					},
					 */
					/*
					'outputMessage' => function($model, $attribute, $key, $index) {
						return '';								  // any custom error to return after model save
					},
					 */
					'showModelErrors' => true, // show model validation errors after save
					'errorOptions' => ['header' => '']				// error summary HTML options
				// 'postOnly' => true,
				// 'ajaxOnly' => true,
				// 'findModel' => function($id, $action) {},
				// 'checkAccess' => function($action, $model) {}
				],
				'editatm' => [									   // identifier for your editable column action
					'class' => EditableColumnAction::className(), // action class name
					'modelClass' => arSprATM::className(), // the model for the record being edited
					/*
					'outputValue' => function ($model, $attribute, $key, $index) {
						return (int) $model->$attribute / 100;	  // return any custom output value if desired
					},
					 */
					/*
					'outputMessage' => function($model, $attribute, $key, $index) {
						return '';								  // any custom error to return after model save
					},
					 */
					'showModelErrors' => true, // show model validation errors after save
					'errorOptions' => ['header' => '']				// error summary HTML options
				// 'postOnly' => true,
				// 'ajaxOnly' => true,
				// 'findModel' => function($id, $action) {},
				// 'checkAccess' => function($action, $model) {}
				]
		]);
	}

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
		$tech = arSprATMOrderTech::find()->indexBy('ID');
		$dataProvider = new ActiveDataProvider([
			'query' => $tech,
		]);
		return $this->render('techs', [
				'dataProvider' => $dataProvider,
		]);
	}
	public function actionAtmlist() {
		$atm = arSprATM::find()->indexBy('ID');
		$dataProvider = new ActiveDataProvider([
			'query' => $atm,
		]);
		return $this->render('atmlist', [
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
