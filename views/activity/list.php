<?php
/**
 * @var $this  \yii\web\View
 * @var $arColumns array
 * @var $arRows array
 */
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
                <td><?=$arRow[$code]?></td>
            <?php endforeach;?>
        </tr>
    <?php endforeach;?>
</table>
