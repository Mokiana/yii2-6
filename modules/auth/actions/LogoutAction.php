<?php

namespace app\modules\auth\actions;


use app\modules\auth\components\AuthComponent;
use yii\base\Action;
use yii\web\Application;

class LogoutAction extends Action
{
    /**
     * @var $app Application
     *
     */
    public $app;

    public function run()
    {
        $this->app->user->logout();

        return $this->controller->goHome();
    }

}