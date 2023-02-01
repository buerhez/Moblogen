<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model common\models\Content */

$this->title = 'Article';
?>
<div class="content-index">

    <p>
        <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => \yii\grid\CheckboxColumn::className()],
            [
                'header'=>'Title',
                'class' => yii\grid\Column::className(),
                'content'=>function ($model, $key, $index, $column){
                    return $model->title.'&nbsp;'.Html::a('<span class="glyphicon glyphicon-link"></span>',Yii::$app->frontendUrlManager->createUrl(['site/post','id'=>$key]),['target'=>'_blank','title'=>'View']);
                }
            ],
            [
                'attribute'=>'authorId',
                'value'=>function($model){
                    return $model->author==null?'-':$model->author->screenName;
                },
            ],
            [
                'label'=>'Category',
                'value'=>function($model){
                    $names= ArrayHelper::getColumn(ArrayHelper::toArray($model->categories),'name');
                    return implode(' ',$names);
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
