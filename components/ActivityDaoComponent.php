<?php

namespace app\components;


use app\base\components\DaoComponent;
use yii\db\Query;

class ActivityDaoComponent extends DaoComponent
{
    public $tableName = 'activities';

    /**
     * @param $param
     * @param $value
     * @return Query
     */
    private function getQueryForParamValue($param, $value)
    {
        $query = new Query();
        $query
            ->select('*')
            ->from($this->tableName)
            ->where(array($param => $value))
            ->leftJoin('activity_files', "{$this->tableName}.id=activity_files.activity_id");

        return $query;
    }

    public function getOneByParam($param, $value)
    {
        return $this->getQueryForParamValue($param, $value)->one();
    }

    public function getAllByParam($param, $value)
    {
        return $this->getQueryForParamValue($param, $value)->all();
    }

    public function addNewItem(array $arColumns)
    {
        $arFiles = $arColumns['uploadedFile'];
        unset($arColumns['uploadedFile']);

        $activityId =  parent::addNewItem($arColumns);
        $arFileColumns = array();
        foreach ($arFiles as $filePath){
            $arFileColumns[] = array($activityId, $filePath);
        }
        $this->getDb()
            ->createCommand()
            ->batchInsert(
                'activity_files',
                array('activity_id', 'file_path'),
                $arFileColumns
            )->execute();
    }
}