<?php

namespace app\modules\auth\controllers;

use app\modules\auth\actions\LogoutAction;

class LogoutController extends AbstractAuthController
{
    /**
     * Renders the index view for the module
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function actions()
    {
        return array(
            'index' => array(
                'class' => LogoutAction::class,
                'app' => \Yii::$app,
            ),
        );
    }

    public function getIsSignIn(): bool
    {
        return true;
    }
}
