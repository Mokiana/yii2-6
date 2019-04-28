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
                'title' => $arActivity[$model->getTitleAttribute()],
                'dateFrom' => $arActivity[$model->getStartDateAttribute()],
                'dateTo' => $arActivity[$model->getEndDateAttribute()],
                'pictures' => $arActivity[$model->getUploadedFileAttribute()],
                'description' => $arActivity[$model->getDescriptionAttribute()],
                'isBlocking' => $arActivity[$model->getIsBlockingAttribute()],
                'useNotifications' => $arActivity[$model->getNeedNotificationAttribute()],
                'email' => $arActivity[$model->getEmailAttribute()],
            )
        );
    }
}