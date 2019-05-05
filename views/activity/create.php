<?php
/**
 * @var $this  \yii\web\View
 * @var $activity \app\models\Activity
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
                <?=$form->field($activity, 'title')?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?=$form->field($activity, 'description')->textarea()?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?=$form->field($activity,
                    'startDate',
                    array(
                        'enableClientValidation' => false,
                        'enableAjaxValidation' => true
                    )
                )->input('date')?>
            </div>
            <div class="col-md-6">
                <?=$form->field(
                    $activity,
                    'endDate',
                    array('enableClientValidation' => false,
                        'enableAjaxValidation' => true
                    )
                    )->input('date')?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?=$form->field($activity, 'uploadedFile')->fileInput(array('multiple' => true))?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?=$form->field(
                        $activity,
                        'email',
                        array(
                            'enableClientValidation' => false,
                            'enableAjaxValidation' => true
                        )
                )->textInput() ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?=$form->field($activity, 'needNotification')->checkbox()?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?=$form->field($activity, 'isBlocking')->checkbox()?>
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
