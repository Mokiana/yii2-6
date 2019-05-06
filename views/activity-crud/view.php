<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Activity */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Activities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$model->attachBehavior('ttt',['class'=>\app\behaviors\DateCreatedBehavior::class,
    'date_created_attribute' => 'date_created']);

//$model->detachBehavior('ttt');
\yii\web\YiiAsset::register($this);
?>
<div class="activity-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'title',
            'description:ntext',
            'startDate',
            'endDate',
            'email:email',
            'isBlocking',
            'needNotification',
            [
                    'attribute'=>'date_created',
                    'value'=>function($model){
        return $model->getDateAt();
                    }
            ],
        ],
    ]) ?>

</div>
