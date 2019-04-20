<?php

namespace app\controllers\actions;


use app\components\ActivityComponent;
use app\helpers\ComponentManager;
use app\models\Activity;
use yii\base\Action;

class ActivityListAction extends Action
{
    public function run()
    {
        $activityComponent = ComponentManager::getActivityComponent();
        if(!$activityComponent) {
            /**
             * @var $activityComponent ActivityComponent
             */
            $activityComponent = \Yii::createObject(array(
                'class' => ActivityComponent::class,
                'activity_class' => Activity::class
            ));
        }

        return $this->controller->render(
            'list',
            array(
                'arColumns' => $activityComponent->getColumns(),
                'arRows' => $activityComponent->getAllActivities()
            )
        );
    }
}