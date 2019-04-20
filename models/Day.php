<?php

namespace app\models;


use app\base\models\ActivityModel;
use app\helpers\ActivityStorage;
use yii\base\Model;

class Day extends Model
{
    public $isHoliday;
    public $activities;


    public function rules()
    {
        return array(
            array(
                array('isHoliday'),
                'required'
            ),
            array(
                array('isHoliday'),
                'boolean'
            ),
            array(
                array('activities'),
                'validateActivityIsTypeOfActivity'
            )
        );
    }

    function validateActivityIsTypeOfActivity()
    {
        if(!empty($this->activities) && !is_array($this->activities)) {
            $this->activities = array($this->activities);
        }

        foreach ($this->activities as $activity) {
            $obActivityStorage = new ActivityStorage(new ActivityModel());
            $arActivities = $obActivityStorage->getAllByParam('id', $activity);
            if(empty($arActivities)) {
                $this->addError('activities', 'Нет активити с указанным ID');
            }
        }
    }
}