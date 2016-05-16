<?php

namespace app\controllers;

class ApiController extends \yii\rest\ActiveController
{
    public function actionMail()
    {
        return $this->render('mail');
    }

}
