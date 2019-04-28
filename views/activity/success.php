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
                <td><?=$activity->getAttributes()[$activity->getTitleAttribute()]?></td>
            </tr>
            <tr>
                <th>Описание</th>
                <td><?=$activity->getAttributes()[$activity->getDescriptionAttribute()]?></td>
            </tr>
            <tr>
                <th>Начало события</th>
                <td><?= Date::convertFromFormatToString($activity->getAttributes()[$activity->getStartDateAttribute()])?></td>
            </tr>
            <?php if($activity->getAttributes()[$activity->getEndDateAttribute()]):?>
                <tr>
                    <th>Окончание события</th>
                    <td><?=Date::convertFromFormatToString($activity->getAttributes()[$activity->getEndDateAttribute()])?></td>
                </tr>
            <?php endif;?>
            <tr>
                <th>Событие занимает весь день</th>
                <td><?=$activity->getAttributes()[$activity->getIsBlockingAttribute()] ? 'Да' : 'Нет'?></td>
            </tr>
        </table>
    </div>
</div>
