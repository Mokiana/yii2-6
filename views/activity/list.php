<?php
/**
 * @var $this  \yii\web\View
 * @var $arColumns array
 * @var $arRows array
 * @var $arLinkFields array
 * @var $linkTemplate string
 * @var $param string
 */

use yii\helpers\Url;
?>
<div class="row">
    <div class="col-md-6">
<?=\app\widgets\activityt\AcitivityTableWidget::widget(['arColumns' => $arColumns,
    'arRows' => $arRows,'arLinkFields' => $arLinkFields,'linkTemplate' => $linkTemplate,
    'param' => $param]);?>
</div>
</div>