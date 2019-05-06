<?php



/* @var $this \yii\web\View */
/* @var $model \app\models\ActivitySearch */
/* @var $provider \yii\data\ActiveDataProvider */

?>

<?=\yii\grid\GridView::widget([
    'dataProvider' => $provider,
    'filterModel' => $model,
    'tableOptions' => [
        'class'=>'table table-hover table-bordered'
    ],
    'rowOptions' => function($model,$key,$index,$grid){
        $class=$index%2?'odd':'even';
        return[
            'class'=>$class
        ];
    },
    'layout' => "{summary}\n{pager}\n{items}\n{pager}",
    'columns' => [
        ['class'=>\yii\grid\SerialColumn::class],
        'id',
        [
            'attribute' => 'title',
            'value' => function($model){
                return \yii\helpers\Html::a(\yii\helpers\Html::encode($model->title),['/activity/detail','id'=>$model->id]);
            },
            'format' => 'html'
        ],
        [
            'attribute' => 'user.email',
            'label' => 'Пользователь'
        ]
    ]
]);?>