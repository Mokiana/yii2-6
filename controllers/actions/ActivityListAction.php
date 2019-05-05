<?php

namespace app\controllers\actions;


use app\components\ActivityComponent;
use app\models\Activity;
use yii\base\Action;

class ActivityListAction extends Action
{
    public $name;

    public function run()
    {
        $activityComponent = \Yii::$app->get($this->name);
        if(!$activityComponent) {
            /**
             * @var $activityComponent ActivityComponent
             */
            $activityComponent = \Yii::createObject(array(
                'class' => ActivityComponent::class,
                'activity_class' => Activity::class
            ));
        }
        $model = $activityComponent->getModel();

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