<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Individual pages';
?>
<div class="content-index">

    <p>
        <?= Html::a('New', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => \yii\grid\CheckboxColumn::className()],
            [
                'header'=>'Header',
                'class' => yii\grid\Column::className(),
                'content'=>function ($model, $key, $index, $column){
                    return $model->title.'&nbsp;'.Html::a('<span class="glyphicon glyphicon-link"></span>',Yii::$app->frontendUrlManager->createUrl(['site/page','slug'=>$model->slug]),['target'=>'_blank','title'=>'View']);
                }
            ],
            'slug',
            [
                'attribute'=>'authorId',
                'value'=>function($model){
                    return $model->author==null?'-':$model->author->screenName;
                },
            ],
            'created:datetime',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{update} {delete}',
            ],
        ],
        'tableOptions'=>['class' => 'table table-striped']
    ]); ?>

</div>
