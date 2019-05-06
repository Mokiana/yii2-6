<?php


namespace app\widgets\activityt;


use yii\bootstrap\Widget;

class AcitivityTableWidget extends Widget
{
    public $arColumns;
    public $arRows;
    public $arLinkFields;
    public $linkTemplate;
    public $param;

    public function run()
    {
        return $this->render('table',['arColumns'=>$this->arColumns,
            'arRows'=>$this->arRows,'arLinkFields'=>$this->arLinkFields,
            'linkTemplate'=>$this->linkTemplate,'param'=>$this->param]);
    }
}