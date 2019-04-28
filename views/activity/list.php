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
<table class="table">
    <tr>
        <?php foreach ($arColumns as $code => $title):?>
            <th><?=$title?></th>
        <?php endforeach;?>
    </tr>
    <?php foreach ($arRows as $arRow):?>
        <tr>
            <?php foreach ($arColumns as $code => $title):?>
                <?php if(in_array($code, $arLinkFields)):?>
                <td>
                    <a href="<?=Url::to([$linkTemplate, $param => $arRow[$param]])?>"><?=$arRow[$code]?></a>
                </td>
                <?php else:?>
                    <td><?=$arRow[$code]?></td>
                <?php endif;?>
            <?php endforeach;?>
        </tr>
    <?php endforeach;?>
</table>
