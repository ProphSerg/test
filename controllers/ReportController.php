<?php

namespace app\controllers;

use Yii;
use app\models\request\arRequest;

class ReportController extends \yii\web\Controller {

	#public $defaultAction = 'request-close';
	public $ControllerMenu = 'reports';

	public function actionIndex() {
		return $this->render('index');
	}
	public function actionReport($type, $name) {
		$post = Yii::$app->request->post();
		#var_dump($post);

		$range = ['value' => null];
		if (isset($post['report_range']) && $post['report_range'] !== '') {
			$range['value'] = $post['report_range'];
			$range['start'] = substr($range['value'], 0, 10);
			$range['end'] = substr($range['value'], 13, 10);
		} elseif (isset($post['report_date']) && $post['report_date'] !== '') {
			$range['value'] = $post['report_date'];
			$range['date'] = substr($range['value'], 0, 10);
		}

		return $this->render('report-' . $type, [
				'report' => $name,
				'range' => $range,
		]);
	}

}
