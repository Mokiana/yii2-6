<?php

namespace app\controllers\actions;


use app\components\ActivityComponent;
use app\components\ActivityFileComponent;
use app\models\Activity;
use app\modules\rbac\components\RbacComponent;
use yii\base\Action;
use yii\web\HttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class ActivityEditAction extends Action
{
    public $name;
    public $fileComponent;

    /**
     * @var $rbac RbacComponent
     */
    public $rbac;

    public function run()
    {
        $activityId = \Yii::$app->request->get('id');
        $activityComponent = \Yii::$app->get($this->name);
        /**
         * @var $model Activity
         */
        $model = $activityComponent->getModel();
        $model = $model::find()->where(array('id' => $activityId))->one();

        if(!$this->rbac->canEditActivity($model->user_id)) {
            throw new HttpException(403, 'No permissions to edit activity');
        }

        /**
         * @var $activityComponent ActivityComponent
         */

        $fileComponent = \Yii::createObject(array(
            'class' => ActivityFileComponent::class,
            'directory' => 'images'
        ));


        if (\Yii::$app->request->isPost) {
            $model->load(\Yii::$app->request->post());
            if (\Yii::$app->request->isAjax) {
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            $model->user_id = \Yii::$app->getUser()->getId();
            $res = $activityComponent->createActivity($model, $fileComponent);
            if ($res) {
                return $this->controller->render('success', array('activity' => $model));
            }
            return $this->controller->render('edit', array('activity' => $model, 'arErrors' => $activityComponent->errors));
        }

        return $this->controller->render('edit', array('activity' => $model));
    }
}