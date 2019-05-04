<?php

namespace app\modules\auth\controllers;

use app\base\controllers\BaseController;
use app\models\Users;
use app\modules\auth\actions\SignInAction;
use app\modules\auth\actions\SignUpAction;
use app\modules\auth\components\CreateUserComponent;
use yii\web\Controller;

/**
 * Default controller for the `auth` module
 */
class SignInController extends BaseController
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
                'app' => \Yii::$app
            ),
        );
    }
}
