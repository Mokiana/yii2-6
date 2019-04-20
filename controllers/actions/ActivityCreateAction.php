<?php

namespace app\controllers\actions;


use app\components\ActivityComponent;
use app\helpers\ActivityStorage;
use app\helpers\ComponentManager;
use app\models\Activity;
use yii\base\Action;

class ActivityCreateAction extends Action
{
    public $name;

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

        $model = $activityComponent->getModel();

        if (\Yii::$app->request->isPost) {
            $model->load(\Yii::$app->request->post());
            $res = $activityComponent->createActivity($model);
            if($res){
                return $this->controller->render('success', array('activity' => $model));
            }
            return $this->controller->render('create', array('activity' => $model, 'arErrors' => $activityComponent->errors));
        }

        return $this->controller->render('create', array('activity' => $model));
    }
}