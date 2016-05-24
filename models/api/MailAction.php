<?php

namespace app\models\api;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;

/**
 * Description of PostMail
 *
 * @author proph
 */
class MailAction extends \yii\base\Action {

	public $checkAccess;

	private function parse(\SimpleXMLElement $item) {
		$str = '';
		if ($item->count() > 0) {
			foreach ($item->children() as $kids) {
				switch ($kids->getName()){
					case 'rawitemdata':
						#$str .= base64_decode(trim((string)$kids));
						$str .= trim((string)$kids);
						break;
					case 'richtext':
						break;
				}
				
			}
			#echo $str . "\n";
			return $str;
		}

		return null;
	}

	public function run() {
		if ($this->checkAccess) {
			call_user_func($this->checkAccess, $this->id);
		}

		#echo Yii::$app->getRequest()->getRawBody();
		libxml_use_internal_errors(true);
		$XML = new \SimpleXMLElement(Yii::$app->getRequest()->getRawBody());
		if (!$XML) {
			throw new ServerErrorHttpException('Failed to parse data. ' . implode('. ', libxml_get_errors()));
		}
		#var_dump($XML);
		$mail = new Mail;

		foreach ($XML->item as $item) {
			#echo "|" . $item['name'] . "|\n";
			#var_dump($item['name']);
			if (isset($item['name']) && property_exists($mail, 'mail' . $item['name'])) {
				$mail->{'mail' . $item['name']} = $this->parse($item);
			}
		}

		return $mail;
		/* @var $model \yii\db\ActiveRecord */
		/*
		  $model = new $this->modelClass([
		  'scenario' => $this->scenario,
		  ]);

		  $model->load(Yii::$app->getRequest()->getBodyParams(), '');
		  if ($model->save()) {
		  $response = Yii::$app->getResponse();
		  $response->setStatusCode(201);
		  $id = implode(',', array_values($model->getPrimaryKey(true)));
		  $response->getHeaders()->set('Location', Url::toRoute([$this->viewAction, 'id' => $id], true));
		  } elseif (!$model->hasErrors()) {
		  throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
		  }

		  return $model;
		 *
		 */
	}

}
