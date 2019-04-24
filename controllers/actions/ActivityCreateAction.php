<?php

namespace app\controllers\actions;


use app\components\ActivityComponent;
use app\components\ActivityFileComponent;
use app\models\Activity;
use yii\base\Action;
use yii\web\Response;
use yii\widgets\ActiveForm;

class ActivityCreateAction extends Action
{
    public $name;
    public $fileComponent;

    public function run()
    {
        $activityComponent = \Yii::$app->get($this->name);

        $fileComponent = \Yii::createObject(array(
            'class' => ActivityFileComponent::class,
            'directory' => 'images'
        ));
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
            if(\Yii::$app->request->isAjax) {
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            $res = $activityComponent->createActivity($model, $fileComponent);
            if($res){
                return $this->controller->render('success', array('activity' => $model));
            }
            return $this->controller->render('create', array('activity' => $model, 'arErrors' => $activityComponent->errors));
        }

        return $this->controller->render('create', array('activity' => $model));
    }
}