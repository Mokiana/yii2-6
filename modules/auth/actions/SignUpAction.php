<?php

namespace app\modules\auth\actions;


use app\modules\auth\components\CreateUserComponent;
use yii\base\Action;
use yii\web\Application;

class SignUpAction extends Action
{
    /**
     * @var $authComponent CreateUserComponent
     */
    public $authComponent;
    /**
     * @var $app Application|\yii\console\Application
     */
    public $app;

    public function run()
    {
        $model = $this->authComponent->getModel();

        if($this->app->request->isPost) {
            $model->load($this->app->request->post());
            if($this->authComponent->createUser($model)) {
                return $this->controller->redirect('/auth/sign-in/');
            }
        }
        return $this->controller->render('index', ['model' => $this->authComponent->getModel()]);
    }

}