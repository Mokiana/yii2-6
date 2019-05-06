<?php

namespace app\base\components;


use yii\base\Component;
use yii\db\Connection;
use yii\db\Query;

class DaoComponent extends Component
{
    public $connection;
    public $tableName;


    /**
     * @return Connection
     */
    public function getDb()
    {
        return $this->connection;
    }

    public function getAllData()
    {
        $sql = "select * FROM {$this->tableName}";
        return $this->getDb()->createCommand($sql)->queryAll();
    }

    public function getAllByParamValue($param, $value)
    {
        $query = new Query();
        $query
            ->select('*')
            ->from($this->tableName)
            ->where(array($param => $value));

        return $query->all();
    }

    public function getOneByParam($param, $value)
    {
        $query = new Query();
        $query
            ->select('*')
            ->from($this->tableName)
            ->where(array($param => $value));

        return $query->one();
    }

    public function addNewItem(array $arColumns)
    {
        $this->getDb()
            ->createCommand()
            ->insert($this->tableName, $arColumns)
            ->execute();

        return $this->getDb()->getLastInsertID();
    }

}