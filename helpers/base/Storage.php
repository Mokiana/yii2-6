<?php
namespace app\helpers\base;


use yii\base\Exception;
use yii\base\Model;

class Storage
{
    private $storage;
    private $fields;
    private $requiredFields = array();

    private $model;

    private $data = null;

    public function __construct(string $storageName, Model $model)
    {
        $this->model = $model;
        $storageDir = \Yii::getAlias('@app') . '/helpers/storage';
        if(!file_exists($storageDir)){
            mkdir($storageDir);
        }
        $storageFile = $storageDir . '/' . $storageName . '.txt';
        if(file_exists($storageDir) && !file_exists($storageFile)){
            $f = fopen($storageFile, 'a+');
            fclose($f);
        }

        $this->storage = $storageFile;


        $this->fields = $model->attributes();

        $arRules = array_filter($model->rules(), function($arRule){
            return in_array('required', $arRule);
        });

        foreach ($arRules as $arRule) {
            list($arFields) = $arRule;
            if(!is_array($arFields) && !in_array($arFields, $this->requiredFields)) {
                $this->requiredFields[] = $arFields;
            }elseif(is_array($arFields)) {
                foreach ($arFields as $field) {
                    if(!in_array($field, $this->requiredFields)) {
                        $this->requiredFields[] = $field;
                    }
                }
            }
        }
    }

    /**
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    private function getAllData()
    {
        if($this->data !== null)
            return $this->data;

        $result = unserialize(file_get_contents($this->storage));
        $result = $result ? $result : array('data' => array(), 'counter' => 0);
        $this->data = $result;
        return $result;
    }

    /**
     * @return array
     */
    public function getAllFromStorage():array
    {
        return $this->getAllData()['data'];
    }

    /**
     * @return int
     */
    public function getCounter():int
    {
        return (int)$this->getAllData()['counter'];
    }

    public function setAllToStorage(array $arData, $counter)
    {
        $this->data = null;
        file_put_contents(
            $this->storage,
            serialize(array(
                'data' => $arData,
                'counter' => $counter
            ))
        );
    }

    /**
     * @param array $arItem (key=>value)
     * @return bool
     */
    public function validateValues(array $arItem):bool
    {
        return true;
    }

    /**
     * @param array $arItem
     * @return bool
     * @throws Exception
     */
    public function addItem(array $arItem):bool
    {
        if(!$this->validateValues($arItem))
            return false;
        $arAllData = $this->getAllFromStorage();
        $fields = $this->fields;
        $arItem = array_filter($arItem, function($key) use ($fields){
            return in_array($key, $fields);
        }, ARRAY_FILTER_USE_KEY );

        $arObligatoryLeft = array_filter($this->requiredFields, function($obligField) use ($arItem){
            return !isset($arItem[$obligField]);
        });

        if(!empty($arObligatoryLeft)) {
            throw new Exception('Не заполнены обязательные поля: ' . implode(',', $arObligatoryLeft));
        }
        $counter = $this->getCounter() + 1;
        $arItem['id'] = $counter;
        $arAllData[] = $arItem;
        $this->setAllToStorage($arAllData, $counter);
        return true;
    }

    /**
     * @param string $param
     * @param $value
     * @return array
     * @throws Exception
     */
    public function getAllByParam(string $param, $value):array
    {
        $arData = $this->getAllFromStorage();

        if(!in_array($param, $this->fields) && $param !== 'id') {
            throw new Exception("В хранилище {$this->storage} объектов с праметром {$param} не обнаружено");
        }

        $arResult = array_filter($arData, function($arItem) use ($param, $value){
            return $arItem[$param] === $value;
        });

        return $arResult;
    }

    /**
     * @param string $param
     * @param $value
     * @return array
     */
    public function getOneByParam(string $param, $value):array
    {
        list($arItem) = $this->getAllByParam($param, $value);
        return $arItem;
    }
}