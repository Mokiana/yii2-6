<?php


namespace app\behaviors;


use yii\base\Behavior;

class DateCreatedBehavior extends Behavior
{

    public $date_created_attribute;

    public function getDateAt(){
        $owner=$this->owner;

        return $owner->{$this->date_created_attribute}.' t';
    }
}