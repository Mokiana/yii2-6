<?php

namespace app\controllers\actions;


use app\components\ActivityComponent;
use yii\base\Action;

class ActivityListAction extends Action
{
    public $name;

    public function run()
    {
        $activityComponent = \Yii::$app->get($this->name);

        return $this->controller->render(
            'list',
            array(
                'arColumns' => $activityComponent->getColumns(),
                'arRows' => $activityComponent->getAllActivities(),
                'arLinkFields' => array(
                    'title',
                    'id',
                ),
                'linkTemplate' => '@web/activity/detail',
                'param' => 'id'
            )
        );
    }
}