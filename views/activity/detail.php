<?php
/**
 * @var $this  \yii\web\View
 * @var $title string
 * @var $dateFrom string
 * @var $dateTo string
 * @var $pictures string
 * @var $description string
 * @var $isBlocking string
 * @var $useNotifications string
 * @var $email string
 *
 */

use yii\helpers\Html; ?>
<div class="row">
    <div class="col-md-6">
        <h3><?=$title?></h3>
        <ul>
            <li><b>Дата начала:</b> <?=$dateFrom?></li>
            <?php if($dateTo):?>
                <li><b>Дата окончания:</b> <?=$dateTo?></li>
            <?php endif;?>
            <li><b>Событие блокирует день:</b> <?=$isBlocking ? 'Да' : 'Нет'?></li>
            <li><b>Прислать оповещение:</b> <?=$useNotifications ? 'Да' : 'Нет'?></li>
            <li><b>Email:</b> <?=$email ? $email : 'Не заполено'?></li>
        </ul>
    </div>
    <div class="col-md-6">
        <br>
        <h4>Описание:</h4>
        <div>
            <?=$description?>
        </div>
    </div>
</div>
<?php if(is_array($pictures) && count($pictures) > 0):?>
<div class="row">
    <div class="col-md-12">
        <h4>Картинки:</h4>
        <div>
            <?php foreach ($pictures as $picture):?>
                <?=Html::img($picture)?>
            <?php endforeach;?>
        </div>
    </div>
</div>
<?php endif;?>
