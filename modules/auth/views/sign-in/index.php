<?php
/**
 * @var $model \app\models\Users
 * @var $error string|null
 */
?>
<?php if($error !== null):?>
<div class="row">
    <div class="alert alert-danger">
        <?=$error?>
    </div>
</div>
<?php endif;?>
<div class="row">
    <div class="col-xs-12">
        <?php $form = \yii\bootstrap\ActiveForm::begin(['method' => 'POST']);?>
        <?=$form->field(
            $model,
            'email',
            array(
                'enableClientValidation' => false,
            )
        );?>
        <?=$form->field(
            $model,
            'password',
            array(
                'enableClientValidation' => false,
            )
        );?>
        <button class="btn btn-primary" type="submit">Sign In</button>
        <?php $form::end();?>
    </div>
</div>
