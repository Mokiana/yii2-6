<?php

namespace app\modules\auth\controllers;

use app\modules\auth\actions\SignUpAction;

/**
 * Default controller for the `auth` module
 */
class SignUpController extends AbstractAuthController
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
                'class' => SignUpAction::class,
                'authComponent' => $this->getAuthComponent(),
                'app' => \Yii::$app
            ),
        );
    }

    public function getIsSignIn(): bool
    {
        return false;
    }
}
