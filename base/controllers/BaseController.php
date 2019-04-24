<?php

namespace app\base\controllers;


use app\helpers\Service;
use yii\web\Controller;

class BaseController extends Controller
{
    public function afterAction($action, $result)
    {
        if(strpos(\Yii::$app->request->url, '/asset') !== 0)
            \Yii::$app->session->set(Service::getLastPageSessionKey(), \Yii::$app->request->url);
        return parent::afterAction($action, $result);
    }
}