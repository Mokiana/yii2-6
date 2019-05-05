<?php

namespace app\modules\auth\controllers;


use app\base\controllers\BaseController;
use app\models\Users;
use app\modules\auth\components\AuthComponent;
use app\modules\auth\models\UsersSignIn;

abstract class AbstractAuthController extends BaseController
{
    abstract public function getIsSignIn(): bool;
    /**
     * @param bool $signIn
     * @return Users|UsersSignIn
     * @throws \yii\base\InvalidConfigException
     */
    public function getModel()
    {
        $modelClass = !$this->getIsSignIn() ? Users::class : UsersSignIn::class;
        return \Yii::createObject(
            $modelClass
        );
    }

    public function getAuthComponent()
    {
        return \Yii::createObject(
            array(
                'class' => AuthComponent::class,
                'model' => $this->getModel(),
                'app' => \Yii::$app
            )
        );
    }
}