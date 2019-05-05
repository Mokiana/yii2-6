<?php
/**
 * @var $this  \yii\web\View
 * @var $activity \app\models\Activity
 */

use app\helpers\Date; ?>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-success">
            Событие успешно создано!
        </div>
        <table class="table stripped">
            <tr>
                <th>Название</th>
                <td><?=$activity->title?></td>
            </tr>
            <tr>
                <th>Описание</th>
                <td><?=$activity->description?></td>
            </tr>
            <tr>
                <th>Начало события</th>
                <td><?= Date::convertFromFormatToString($activity->startDate)?></td>
            </tr>
            <?php if($activity->endDate):?>
                <tr>
                    <th>Окончание события</th>
                    <td><?=Date::convertFromFormatToString($activity->endDate)?></td>
                </tr>
            <?php endif;?>
            <tr>
                <th>Событие занимает весь день</th>
                <td><?=$activity->isBlocking ? 'Да' : 'Нет'?></td>
            </tr>
        </table>
    </div>
</div>
