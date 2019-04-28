<?php

namespace app\models;


use app\base\models\interfaces\StartFinishModelInterface;
use app\base\validators\AfterDateValidator;
use yii\base\Model;

class Activity extends Model implements StartFinishModelInterface
{
    public $title;
    public $description;
    public $startDate;
    public $endDate;
    public $email;
    public $isBlocking;
    public $needNotification;
    public $uploadedFile;


    public function getTitleAttribute()
    {
        return 'title';
    }

    public function getDescriptionAttribute()
    {
        return 'description';
    }

    public function getStartDateAttribute()
    {
        return 'startDate';
    }

    public function getEndDateAttribute()
    {
        return 'endDate';
    }

    public function getNeedNotificationAttribute()
    {
        return 'needNotification';
    }
    public function getEmailAttribute()
    {
        return 'email';
    }

    public function getIsBlockingAttribute()
    {
        return 'isBlocking';
    }

    public function getUploadedFileAttribute()
    {
        return 'uploadedFile';
    }

    public function getUploadedFileMultiAttribute()
    {
        return $this->getUploadedFileAttribute() . '[]';
    }


    public function getStartDate()
    {
        return $this->getStartDateAttribute();
    }

    public function getFinishDate()
    {
        return $this->getEndDateAttribute();
    }

    public function createTimeStamp($value)
    {
        if(is_string($value))
            return \DateTime::createFromFormat('Y-m-d', $value)->getTimestamp();
        return "";
    }

    public function getDateActivity($value, $emptyResult = "")
    {
        if(is_string($value)) {
            $date = \DateTime::createFromFormat('Y-m-d', $value);
            if(!$date) {
                return $emptyResult;
            }
            return $date->format('d.m.Y');
        }
        return $emptyResult;
    }


    public function attributeLabels()
    {
        return array(
            $this->getTitleAttribute() => 'Название события',
            $this->getDescriptionAttribute() => 'Описание события',
            $this->getStartDateAttribute() => 'Дата начала',
            $this->getEndDateAttribute() => 'Дата завершения',
            $this->getIsBlockingAttribute() => 'Блокирует день',
            $this->getEmailAttribute() => 'Email',
            $this->getNeedNotificationAttribute() => 'Присылать оповещения',
            $this->getUploadedFileAttribute() => 'Картинка события',
        );
    }

    public function rules()
    {
        return array(
            array(
                array($this->getTitleAttribute(), $this->getDescriptionAttribute(), $this->getStartDateAttribute()),
                'required',
            ),
            array(
                $this->getDescriptionAttribute(),
                'string',
                'min' => 10,

            ),
            array(
                array($this->getIsBlockingAttribute(), $this->getNeedNotificationAttribute()),
                'boolean',
            ),
            array(
                array($this->getEndDateAttribute()),
                'date',
                'format' => 'yyyy-MM-dd'
            ),
            array(
                array($this->getStartDateAttribute()),
                'date',
                'format' => 'yyyy-MM-dd',
                'min' => date('Y-m-d',time()),
                'tooSmall' => '"{attribute}" не может быть ранее сегодняшнего дня',
            ),
            array(
                array($this->getStartDateAttribute(), $this->getEndDateAttribute()),
                AfterDateValidator::class
            ),
            array(
                array($this->getEmailAttribute()),
                'email'
            ),
            array(
                array($this->getEmailAttribute()),
                'required',
                'when' => function($model, $attribute){
                    /**
                     * @var $model ActivityModel
                     */
                    $checkingAttribute = $model->getNeedNotificationAttribute();
                    return $model->$checkingAttribute == true;
                },
                'message' => 'Если Вы хотите получать оповещения, необходимо заполнить поле "{attribute}"'
            ),
            array(
                $this->getUploadedFileAttribute(),
                'file',
                'extensions' => array('jpeg', 'jpg', 'gif', 'png'),
                'maxSize' => 15 * 1024 * 1024,
                'maxFiles' => 2
            ),
        );
    }
}