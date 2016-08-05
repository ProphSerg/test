<?php

namespace app\controllers;

use Yii;
use app\models\request\arRequest;

class ReportController extends \yii\web\Controller {

	public $defaultAction = 'request-close';
	public $ControllerMenu = 'reports';

	public function actionRequestClose() {
		$post = Yii::$app->request->post();
		var_dump($post);

		$report_range = '';
		$model = null;
		if (isset($post['report_range'])) {
			$report_range = $post['report_range'];
			$range['start'] = substr($report_range, 0, 10);
			$range['end'] = substr($report_range, 13, 10);
			
			$model = arRequest::find()->ReportClose($range);
		}
		
		return $this->render('requestClose', [
				'model' => $model,
				'report_range' => $report_range,
		]);
	}

}
