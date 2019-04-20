<?php

namespace app\components;


use app\base\models\ActivityModel;
use app\helpers\ActivityStorage;
use app\models\Activity;
use yii\base\Component;
use yii\base\Exception;

class ActivityComponent extends Component
{
    public $activity_class;
    public $errors = array();

    public function init()
    {
        parent::init();

        if(empty($this->activity_class))
            throw new Exception('Нужно передать activity_class');
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
     * @return bool
     */
    public function createActivity(Activity &$model):bool
    {
        $isValid = $model->validate();
        if($isValid){
            $obActivityStorage = new ActivityStorage($model);
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
        return $model->attributeLabels();
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
}