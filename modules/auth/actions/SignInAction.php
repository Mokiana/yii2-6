<?php

namespace app\modules\auth\actions;


use yii\base\Action;
use yii\web\Application;
use yii\web\Response;

class SignInAction extends Action
{
    /**
     * @var $app Application
     *
     */
    public $app;

    public function run()
    {
        $this->app->response->format = Response::FORMAT_JSON;
        return array('data' => 'asda', 'sd', 1, 22);

        return $this->controller->render('index');
    }

}