<?php
/**
 * @var $model \app\models\Users
 */
?>
<div class="row">
    <div class="col-xs-12">
        <?php $form = \yii\bootstrap\ActiveForm::begin(['method' => 'POST']);?>
        <?=$form->field($model, 'name')?>
        <?=$form->field($model, 'email')?>
        <?=$form->field($model, 'password');?>
        <button class="btn btn-primary" type="submit">Sign Up</button>
        <?php $form::end();?>
    </div>
</div>
