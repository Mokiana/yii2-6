<?php

namespace app\rules;


use yii\helpers\ArrayHelper;
use yii\rbac\Item;
use yii\rbac\Rule;

class ViewOwnActivity extends Rule
{

    public $name = 'checkOwner';

    /**
     * Executes the rule.
     *
     * @param string|int $user the user ID. This should be either an integer or a string representing
     * the unique identifier of a user. See [[\yii\web\User::id]].
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to [[CheckAccessInterface::checkAccess()]].
     * @return bool a value indicating whether the rule permits the auth item it is associated with.
     */
    public function execute($user, $item, $params)
    {
        $ownerId = ArrayHelper::getValue($params, 'ownerId');
        return \Yii::$app->user->getId() === $ownerId;
    }
}