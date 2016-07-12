<?php

namespace app\controllers;

#use yii\base\InvalidConfigException;
#use yii\base\Model;
use yii\web\ForbiddenHttpException;
use yii\rest\Controller;

class ApiController extends Controller {
	/**
	 * @inheritdoc
	 */
	/*
	  public function init()
	  {
	  parent::init();
	  if ($this->modelClass === null) {
	  throw new InvalidConfigException('The "modelClass" property must be set.');
	  }
	  }
	 */

	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [
			'mail' => [
				'class' => 'app\models\api\MailAction',
#				'modelClass' => $this->modelClass,
				'checkAccess' => [$this, 'checkAccess'],
#				'scenario' => $this->createScenario,
			],
			'convert' => [
				'class' => 'app\models\api\ConvertAction',
#				'modelClass' => $this->modelClass,
				'checkAccess' => [$this, 'checkAccess'],
#				'scenario' => $this->createScenario,
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	protected function verbs() {
		return [
			'mail' => ['POST'],
		];
	}

	/**
	 * Checks the privilege of the current user.
	 *
	 * This method should be overridden to check whether the current user has the privilege
	 * to run the specified action against the specified data model.
	 * If the user does not have access, a [[ForbiddenHttpException]] should be thrown.
	 *
	 * @param string $action the ID of the action to be executed
	 * @param object $model the model to be accessed. If null, it means no specific model is being accessed.
	 * @param array $params additional parameters
	 * @throws ForbiddenHttpException if the user does not have access
	 */
	public function checkAccess($action, $model = null, $params = []) {
		
	}

}
