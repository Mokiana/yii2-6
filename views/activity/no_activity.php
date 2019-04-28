<?php
/**
 * @var $this  \yii\web\View
 * @var $listLink string
 */

use yii\helpers\Url;
?>
<div class="row">
    <div class="col-md-12">
        <h3>Ошибка</h3>
        <div>
            <div class="alert alert-danger">Событие не найдено...</div>
        </div>
        <div>
            <a href="<?=Url::to(array($listLink))?>">К списку событий</a>
        </div>
    </div>
</div>
