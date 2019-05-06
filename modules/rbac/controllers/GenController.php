<?php

namespace app\modules\rbac\controllers;


use app\base\controllers\BaseController;
use app\modules\rbac\components\RbacComponent;

class GenController extends BaseController
{
    public function actionIndex()
    {
        $rbacComponent = \Yii::createObject(array(
            'class' => RbacComponent::class,
            'app' => \Yii::$app,
            'authManager' => \Yii::$app->authManager
        ));

        $rbacComponent->genRbac();
    }
}