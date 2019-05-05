<?php

namespace app\controllers\actions;


use app\components\ActivityComponent;
use app\models\Activity;
use yii\base\Action;

class ActivityDetailAction extends Action
{
    public $name;

    public function run()
    {
        /**
         * @var $activityComponent ActivityComponent
         */
        $activityComponent = \Yii::$app->get($this->name);
        $model = $activityComponent->getModel();
        $activityId = \Yii::$app->request->get('id');

        $arActivity = $activityComponent->getActivityById($activityId);

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