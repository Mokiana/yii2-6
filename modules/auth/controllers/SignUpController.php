<?php

namespace app\modules\auth\controllers;

use app\base\controllers\BaseController;
use app\models\Users;
use app\modules\auth\actions\SignUpAction;
use app\modules\auth\components\CreateUserComponent;
use yii\web\Controller;

/**
 * Default controller for the `auth` module
 */
class SignUpController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function actions()
    {
        $model = \Yii::createObject(
            Users::class
        );

        $authComponent = \Yii::createObject(
            array(
                'class' => CreateUserComponent::class,
                'model' => $model,
                'app' => \Yii::$app
            )
        );

        return array(
            'index' => array(
                'class' => SignUpAction::class,
                'authComponent' => $authComponent,
                'app' => \Yii::$app
            ),
        );
    }
}
