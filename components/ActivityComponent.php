<?php

namespace app\components;


use app\base\components\FileComponent;
use app\helpers\Date;
use app\models\Activity;
use app\models\ActivityFiles;
use app\models\ActivitySearch;
use app\modules\rbac\components\RbacComponent;
use yii\base\Component;
use yii\base\Exception;
use yii\web\HttpException;


/**
 * Class ActivityComponent
 * @package app\components
 */
class ActivityComponent extends Component
{
    public $activity_class;

    public $errors = array();

    public function init()
    {
        parent::init();

        if(empty($this->activity_class)) {
            throw new Exception('Нужно передать activity_class');
        }
    }

    /**
     * @return Activity
     */
    public function getModel()
    {
        return new $this->activity_class;
    }

    /**
     * @param Activity $model
     * @param FileComponent|ActivityFileComponent $fileComponent
     * @return bool
     * @throws Exception
     */
    public function createActivity(Activity &$model, $fileComponent):bool
    {
        $isValid = $model->validate();
        if($isValid){
            $fileComponent->saveFiles($model, 'uploadedFile');

            $model->save();

            foreach ($model->uploadedFile as $file) {
                $fileModel = \Yii::createObject(
                    array(
                        'class' => ActivityFiles::class,
                        'activity_id' => $model->id,
                        'file_path' => $file
                    )
                );
                $isValidFile = $fileModel->validate();
                if($isValidFile) {
                    $fileModel->save();
                }
            }

            return true;
        }
        return $isValid;
    }

    public function getColumns()
    {
        $model = $this->getModel();
        $includedInListColumns = array(
            'id' => 'ID события',
            'title' => $model->getAttributeLabel('title'),
            'startDate' => $model->getAttributeLabel('startDate'),
            'endDate' => $model->getAttributeLabel('endDate'),
            'isBlocking' => $model->getAttributeLabel('isBlocking'),
        );

        return $includedInListColumns;
    }

    public function getAllActivities()
    {
        $model = $this->getModel();

        $filter = null;

        /**
         * @var $rbacComponent RbacComponent
         */
        $rbacComponent = \Yii::createObject(array(
            'class' => RbacComponent::class,
            'app' => \Yii::$app,
            'authManager' => \Yii::$app->authManager
        ));


        $viewAll = $rbacComponent->canViewAllActivities();
        if(!$viewAll) {
            $viewMy = $rbacComponent->canViewOwnActivities(\Yii::$app->user->getId());
        }


        $model = $model::find();
        if(!$viewAll && $viewMy) {
            $model = $model->where(array('user_id' => \Yii::$app->user->getId()));
        } elseif(!$viewAll) {
            throw new HttpException(403, 'You have no permissions to read the list');
        }


        $arData = $model->asArray()->all();
        $isBlockingCode = 'isBlocking';
        $startDateCode = 'startDate';
        $endDateCode = 'endDate';
        foreach ($arData as $key => $arDatum) {
            $arData[$key][$isBlockingCode] = $arDatum[$isBlockingCode] == true ? 'Да' : "Нет";
            $arData[$key][$startDateCode] = Date::convertFromFormatToString($arDatum[$startDateCode], "&mdash;");
            $arData[$key][$endDateCode] = Date::convertFromFormatToString($arDatum[$endDateCode], "&mdash;");
        }
        return $arData;
    }

    public function getActivityById($id)
    {
        $model = $this->getModel();
        $model = $model::find()
            ->select(array(
                '*',
            ))
            ->where(['id' => $id])
            ->one();

        $files = $model->getActivityFiles()->asArray()->all();
        $arActivity = $model->getAttributes();

        foreach ($files as $file) {
            $arActivity['uploadedFile'][] = $file['file_path'];
        }

        return $arActivity;
    }

}