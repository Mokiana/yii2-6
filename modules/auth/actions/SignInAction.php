<?php

namespace app\modules\auth\actions;


use app\modules\auth\components\AuthComponent;
use yii\base\Action;
use yii\web\Application;

class SignInAction extends Action
{
    /**
     * @var $authComponent AuthComponent
     */
    public $authComponent;

    /**
     * @var $app Application
     *
     */
    public $app;

    public function run()
    {
        $modelUser = $this->authComponent->getModel();
        $error = null;
        if($this->app->request->isPost) {
            $modelUser->load($this->app->request->post());
            if($this->authComponent->authUser($modelUser)) {
                return $this->controller->redirect('/activity/create');
            }
            $error = 'Ошибка! Пароль не верен!';
        }

        return $this->controller->render(
            'index',
            array(
                'model' => $modelUser,
                'error' => $error
            )
        );
    }

}