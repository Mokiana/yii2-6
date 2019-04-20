<?php

namespace app\base\models;


use yii\base\Model;

class ActivityModel extends Model
{
    public $title;
    public $description;
    public $startDate;
    public $endDate;
    public $is_blocking;


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

    public function getIsBlockingAttribute()
    {
        return 'is_blocking';
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
                $this->getIsBlockingAttribute(),
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
        );
    }
}