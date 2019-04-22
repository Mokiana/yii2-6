<?php
/**
 * @var $this  \yii\web\View
 * @var $activity \app\base\models\ActivityModel
 * @var $strUser string
 * @var $arErrors
 */

?>
<div class="row">
    <?php if(!empty($arErrors)):?>
        <div class="col-md-12">
            <?php foreach($arErrors as $error):?>
                <div class="alert alert-danger"><?=$error?></div>
            <?php endforeach;?>
        </div>
    <?php endif;?>
    <div class="col-md-12">
        <h3>Добавление события.</h3>
        <?php $form = \yii\bootstrap\ActiveForm::begin(array());?>
        <div class="row">
            <div class="col-md-12">
                <?=$form->field($activity, $activity->getTitleAttribute())?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?=$form->field($activity, $activity->getDescriptionAttribute())->textarea()?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?=$form->field($activity, $activity->getStartDateAttribute())->input('date')?>
            </div>
            <div class="col-md-6">
                <?=$form->field($activity, $activity->getEndDateAttribute())->input('date')?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?=$form->field($activity, $activity->getIsBlockingAttribute())->checkbox()?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <button class="btn btn-default" type="submit">Создать</button>
                </div>
            </div>
        </div>
        <?php $form::end();?>
    </div>
</div>
