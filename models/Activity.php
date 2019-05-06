<?php

namespace app\models;


use app\base\models\interfaces\StartFinishModelInterface;
use app\base\validators\AfterDateValidator;
use app\behaviors\DateCreatedBehavior;
use app\behaviors\LoggerBehavior;
use yii\base\Model;

class Activity extends ActivityBase implements StartFinishModelInterface
{
    public $uploadedFile;

    public function behaviors()
    {
        return [
            ['class'=>DateCreatedBehavior::class,'date_created_attribute' => 'date_created'],
            LoggerBehavior::class
        ];
    }



    public function getStartDate()
    {
        return 'startDate';
    }

    public function getFinishDate()
    {
        return 'endDate';
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
            'title' => 'Название события',
            'user_id' => 'Id пользователя',
            'description' => 'Описание события',
            'startDate' => 'Дата начала',
            'endDate' => 'Дата завершения',
            'isBlocking' => 'Блокирует день',
            'email' => 'Email',
            'needNotification' => 'Присылать оповещения',
            'uploadedFile' => 'Картинка события',
        );
    }

    public function rules()
    {
        return array_merge(
            parent::rules(),
            array(
                array(
                    'description',
                    'string',
                    'min' => 10,

                ),
                array(
                    array('isBlocking', 'needNotification'),
                    'boolean',
                ),
                array(
                    array('endDate'),
                    'date',
                    'format' => 'yyyy-MM-dd'
                ),
                array(
                    array('startDate'),
                    'date',
                    'format' => 'yyyy-MM-dd',
                    'min' => date('Y-m-d',time()),
                    'tooSmall' => '"{attribute}" не может быть ранее сегодняшнего дня',
                ),
                array(
                    array('startDate', 'endDate'),
                    AfterDateValidator::class
                ),
                array(
                    array('email'),
                    'email'
                ),
                array(
                    array('email'),
                    'required',
                    'when' => function($model, $attribute){
                        /**
                         * @var $model Activity
                         */
                        return $model->needNotification == true;
                    },
                    'message' => 'Если Вы хотите получать оповещения, необходимо заполнить поле "{attribute}"'
                ),
                array(
                    'uploadedFile',
                    'file',
                    'extensions' => array('jpeg', 'jpg', 'gif', 'png'),
                    'maxSize' => 15 * 1024 * 1024,
                    'maxFiles' => 2
                ),
            )
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }
}