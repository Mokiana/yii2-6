<?php
namespace app\helpers;


use app\components\ActivityComponent;
use yii\base\Component;
use yii\base\Exception;

class ComponentManager
{
    /**
     * @param string $name
     * @return Component|false
     */
    private static function getComponentByName(string $name)
    {
        if(!isset(\Yii::$app->getComponents()[$name])) {
            return false;
        }
        return \Yii::$app->$name;
    }

    /**
     * @return ActivityComponent
     */
    public static function getActivityComponent()
    {
        return static::getComponentByName('activity');
    }
}