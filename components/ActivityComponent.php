<?php

namespace app\components;


use app\base\components\FileComponent;
use app\base\models\ActivityModel;
use app\helpers\ActivityStorage;
use app\helpers\base\Storage;
use app\models\Activity;
use function foo\func;
use yii\base\Component;
use yii\base\Exception;

/**
 * Class ActivityComponent
 * @package app\components
 */
class ActivityComponent extends Component
{
    public $activity_class;
    public $storage_class;

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
            $fileAttribute = $model->getUploadedFileAttribute();
            $fileComponent->saveFiles($model, $fileAttribute);
            /**
             * @var $obActivityStorage Storage
             */
            $obActivityStorage = new $this->storage_class($model);
            $res = $obActivityStorage->addItem($model->getAttributes());
            if(!$res) {
                $this->errors = array_merge($this->errors, $obActivityStorage->getErrors());
            }
            return $res;

        }
        return $isValid;
    }

    public function getColumns()
    {
        $model = $this->getModel();
        $includedInListColumns = array(
            'id' => 'ID события',
            $model->getTitleAttribute() => $model->getAttributeLabel($model->getTitleAttribute()),
            $model->getStartDateAttribute() => $model->getAttributeLabel($model->getStartDateAttribute()),
            $model->getEndDateAttribute() => $model->getAttributeLabel($model->getEndDateAttribute()),
            $model->getIsBlockingAttribute() => $model->getAttributeLabel($model->getIsBlockingAttribute()),
        );

        return $includedInListColumns;
    }

    public function getAllActivities()
    {
        $model = $this->getModel();
        $obStorage = new ActivityStorage($model);
        $arData = $obStorage->getAllFromStorage();
        $isBlockingCode = $model->getIsBlockingAttribute();
        $startDateCode = $model->getStartDateAttribute();
        $endDateCode = $model->getEndDateAttribute();
        foreach ($arData as $key => $arDatum) {
            $arData[$key][$isBlockingCode] = $arDatum[$isBlockingCode] == true ? 'Да' : "Нет";
            $arData[$key][$startDateCode] = $model->getDateActivity($arDatum[$startDateCode], "&mdash;");
            $arData[$key][$endDateCode] = $model->getDateActivity($arDatum[$endDateCode], "&mdash;");
        }
        return $arData;
    }

    public function getActivityById($id)
    {
        $arActivities = array_values(array_filter($this->getAllActivities(), function($arItem) use ($id) {
            if((int)$arItem['id'] === (int)$id) {
                return true;
            }
            return false;
        }));
        list($arActivity) = $arActivities;
        return $arActivity;
    }
}