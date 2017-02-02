<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\grid\EditableColumnAction;
use app\models\pos\arKey;
use app\models\pos\arKeyReserve;
use app\models\pos\arRegPos;
use app\models\pos\KeyReserveModel;
use app\models\pos\RegPosSearch;
use yii\widgets\ActiveForm;

class PosController extends Controller {

    public $defaultAction = 'register';
    public $ControllerMenu = 'pos';

    public function actionIndex() {
        return $this->render('index');
    }

    public function actions() {
        return ArrayHelper::merge(parent::actions(), [
                    'key-reserve-edit' => [// identifier for your editable column action
                        'class' => EditableColumnAction::className(), // action class name
                        'modelClass' => arKeyReserve::className(), // the model for the record being edited
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
                        'errorOptions' => ['header' => ''] // error summary HTML options
                    // 'postOnly' => true,
                    // 'ajaxOnly' => true,
                    // 'findModel' => function($id, $action) {},
                    // 'checkAccess' => function($action, $model) {}
                    ],
        ]);
    }

    public function actionEnterKeyReserve() {
        $model = new KeyReserveModel();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/pos']);
        }
        return $this->render('enter-key-reserve', [
                    'model' => $model,
        ]);
    }

    public function actionKeyReserve() {
        $query = arKeyReserve::find()
                ->where(['Comment' => null])
                ->orderBy('Number');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('key-reserve', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRegister() {
        /*
          $post = \Yii::$app->request->post();
          #var_dump($post);
          $key = new arKey();
          if ($key->load($post)) {
          $key->validate() && $key->save();
          $this->renderAjax('_key-detail', [
          'model' => [
          'key' => $key,
          ]
          ]);
          }
         * 
         */
        $searchModel = new RegPosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        return $this->render('register', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel
        ]);
    }

    public function actionRegisterDetail() {
        $post = \Yii::$app->request->post();
        #var_dump($post);
        if (isset($post['expandRowKey'])) {
            $model = arRegPos::findOne($post['expandRowKey']);
            return $this->renderPartial('_register-detail', ['model' => $model]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionAddkey() {
        $model = new arKey;
        $post = \Yii::$app->request->post();
        //var_dump($post);
        if (!isset($post['arKey'])) {
            $model->attributes = $post;
        }

        if (Yii::$app->request->isAjax && $model->load($post)) {
            if ($model->save()) {
                return $this->redirect(Url::to('register'));
            } else {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            /*
              if ($model->load($post) && $model->save()) {
              return $this->redirect(Url::to('register'));
              }
             * 
             */
        }
        return $this->renderAjax(Url::to('_addkey'), ['model' => $model]);
    }

}
