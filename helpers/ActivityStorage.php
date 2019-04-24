<?php

namespace app\helpers;


use app\base\models\ActivityModel;
use app\helpers\base\Storage;
use app\models\Activity;
use yii\base\Model;

class ActivityStorage extends Storage
{
    private $errors = array();

    public function __construct(Model $model)
    {
        parent::__construct('activities', $model);
    }


    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param array $arItem
     * @return bool
     */
    public function validateValues(array $arItem): bool
    {
        $arAllActivities = $this->getAllFromStorage();

        $arBlockingActivitiesInInterval = array_filter($arAllActivities, function($arActivity) use ($arItem){
            /**
             * @var $model Activity
             */
            $model = $this->getModel();
            //Если проверяемое и выпадаемое соыбтия не блокирующие, пропускаем
            if(!$arActivity[$model->getIsBlockingAttribute()] && !$arItem[$model->getIsBlockingAttribute()])
                return false;

            $addingStartDate = $arItem[$model->getStartDateAttribute()];
            $addingEndDate = $arItem[$model->getEndDateAttribute()];
            $addingEndDate = $addingEndDate ? $addingEndDate : $addingStartDate;

            $currentStartDate = $arActivity[$model->getStartDateAttribute()];
            $currentEndDate = $arActivity[$model->getEndDateAttribute()];
            $currentEndDate = $currentEndDate ? $currentEndDate : $currentStartDate;


            $addingStartDate = $model->createTimeStamp($addingStartDate);
            $addingEndDate = $model->createTimeStamp($addingEndDate);
            $currentStartDate = $model->createTimeStamp($currentStartDate);
            $currentEndDate = $model->createTimeStamp($currentEndDate);

            //Если не пересекаются интервалы - пропускаем
            $startIsOutOfInterval = ($addingStartDate > $currentEndDate && $addingStartDate > $currentStartDate) || ($addingStartDate < $currentEndDate && $addingStartDate < $currentStartDate);
            $endIsOutOfInterval = ($addingEndDate > $currentEndDate && $addingEndDate > $currentStartDate) || ($addingEndDate < $currentEndDate && $addingEndDate < $currentStartDate);
            if($startIsOutOfInterval && $endIsOutOfInterval)
                return false;

            return true;
        });


        if(!empty($arBlockingActivitiesInInterval)) {
            /**
             * @var $model Activity
             */
            $model = $this->getModel();
            foreach ($arBlockingActivitiesInInterval as $arActivity) {
                if($arActivity[$model->getIsBlockingAttribute()])
                    $this->errors[] = "На указанную дату выпадает блокирующее событие: " . $arActivity[$model->getTitleAttribute()];
                else
                    $this->errors[] = "Нельзя добавить блокирующее событие. На указанные даты уже создано событие " . $arActivity[$model->getTitleAttribute()];
            }
        }

        return empty($arBlockingActivitiesInInterval);

    }

    public function getAllFromStorage(): array
    {
        $arAllActivities = parent::getAllFromStorage();
        $arAllActivities = array_filter($arAllActivities, function($arActivity){
            /**
             * @var $model Activity
             */
            $model = $this->getModel();
            $currentDate = time();
            $activityEndDate = $arActivity[$model->getEndDateAttribute()] ?: $arActivity[$model->getStartDateAttribute()];
            $activityEndTimeStamp = $model->createTimeStamp($activityEndDate);
            if($currentDate > $activityEndTimeStamp && date('d.m.Y', $currentDate) !== date('d.m.Y', $activityEndTimeStamp))
                return false;
            return true;
        });


        usort($arAllActivities, function($arAct1, $arAct2) {
            /**
             * @var $model Activity
             */
            $model = $this->getModel();

           $startFirst =  $model->createTimeStamp($arAct1[$model->getStartDateAttribute()]);
           $startSecond =  $model->createTimeStamp($arAct2[$model->getStartDateAttribute()]);
           return $startFirst > $startSecond;
        });

        return array_map(function($arItem){
            /**
             * @var $model Activity
             */
            $model = $this->getModel();
            $arFiles = $arItem[$model->getUploadedFileAttribute()];
            if(!is_array($arFiles))
                return $arItem;
            foreach ($arFiles as &$file) {
                $file = str_replace(\Yii::getAlias('@webroot'), '', $file);
            }
            $arItem[$model->getUploadedFileAttribute()] = $arFiles;
            return $arItem;
        }, $arAllActivities);
    }
}