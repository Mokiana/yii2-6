<?php
/**
 * @var $this  \yii\web\View
 * @var $arColumns array
 * @var $arRows array
 */
?>
<table class="table">
    <tr>
        <?foreach ($arColumns as $code => $title):?>
            <th><?=$title?></th>
        <?endforeach;?>
    </tr>
    <?foreach ($arRows as $arRow):?>
        <tr>
            <?foreach ($arColumns as $code => $title):?>
                <td><?=$arRow[$code]?></td>
            <?endforeach;?>
        </tr>
    <?endforeach;?>
</table>
