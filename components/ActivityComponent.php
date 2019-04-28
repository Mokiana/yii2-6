<?php

namespace app\components;


use app\base\components\FileComponent;
use app\helpers\Date;
use app\models\Activity;
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
             * @var $obActivityDao \app\components\ActivityDaoComponent
             */
            $obActivityDao = \Yii::createObject(array(
                'class' => ActivityDaoComponent::class,
                'connection' => \Yii::$app->getDb()
            ));
            $arData = $model->getAttributes();
            $arData['user_id'] = 1;
            $obActivityDao->addNewItem($arData);
            return true;
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
        /**
         * @var $obActivityDao \app\components\ActivityDaoComponent
         */
        $obActivityDao = \Yii::createObject(array(
            'class' => ActivityDaoComponent::class,
            'connection' => \Yii::$app->getDb()
        ));

        $arData = $obActivityDao->getAllData();

        $isBlockingCode = $model->getIsBlockingAttribute();
        $startDateCode = $model->getStartDateAttribute();
        $endDateCode = $model->getEndDateAttribute();
        foreach ($arData as $key => $arDatum) {
            $arData[$key][$isBlockingCode] = $arDatum[$isBlockingCode] == true ? 'Да' : "Нет";
            $arData[$key][$startDateCode] = Date::convertFromFormatToString($arDatum[$startDateCode], "&mdash;");
            $arData[$key][$endDateCode] = Date::convertFromFormatToString($arDatum[$endDateCode], "&mdash;");
        }
        return $arData;
    }

    public function getActivityById($id)
    {
        /**
         * @var $obActivityDao \app\components\ActivityDaoComponent
         */
        $obActivityDao = \Yii::createObject(array(
            'class' => ActivityDaoComponent::class,
            'connection' => \Yii::$app->getDb()
        ));
        $arActivity = $obActivityDao->getAllByParam('id', $id);
        $arFiles = array();
        foreach ($arActivity as $arAct) {
            if($arAct['file_path']) {
                $arFiles[] = $arAct['file_path'];
            }
        }
        list($arActivity) = $arActivity;
        if(!empty($arFiles)) {
            $arActivity[$this->getModel()->getUploadedFileAttribute()] = $arFiles;
        }

        return $arActivity;
    }
}