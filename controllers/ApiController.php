<?php

namespace app\controllers;

class ApiController extends \yii\rest\ActiveController
{
	public $modelClass = 'app\models\api\Mail';
	
	/*
	public function actionMail()
    {
        return $this->render('mail');
    }
	 * 
	 */

}
