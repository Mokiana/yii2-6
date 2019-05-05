<?php

namespace app\controllers\actions;


use app\components\ActivityComponent;
use app\models\Activity;
use app\modules\rbac\components\RbacComponent;
use yii\base\Action;
use yii\web\HttpException;

class ActivityDetailAction extends Action
{
    public $name;
    /**
     * @var $rbac RbacComponent
     */
    public $rbac;

    public function run()
    {

        /**
         * @var $activityComponent ActivityComponent
         */
        $activityComponent = \Yii::$app->get($this->name);
        $activityId = \Yii::$app->request->get('id');

        $arActivity = $activityComponent->getActivityById($activityId);
        if(!$this->rbac->canViewActivity($arActivity['user_id'])) {
            throw new HttpException(403, 'No permission to read this activity');
        }

        if(!$arActivity) {
            return $this->controller->render('no_activity', array('listLink' => 'activity/list'));
        }

        return $this->controller->render(
            'detail',
            array(
                'title' => $arActivity['title'],
                'dateFrom' => $arActivity['dateFrom'],
                'dateTo' => $arActivity['dateTo'],
                'pictures' => $arActivity['uploadedFile'],
                'description' => $arActivity['description'],
                'isBlocking' => $arActivity['isBlocking'],
                'useNotifications' => $arActivity['needNotification'],
                'email' => $arActivity['email'],
            )
        );
    }
}