<?php

namespace app\modules\auth\controllers;

use app\modules\auth\actions\SignInAction;

/**
 * Default controller for the `auth` module
 */
class SignInController extends AbstractAuthController
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
                'class' => SignInAction::class,
                'app' => \Yii::$app,
                'authComponent' => $this->getAuthComponent()
            ),
        );
    }

    public function getIsSignIn(): bool
    {
        return true;
    }
}
