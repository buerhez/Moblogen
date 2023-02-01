<?php
use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Manage Categories';
?>
<div class="meta-index">

    <div class="btn-group">
        <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
            Selected items <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <li><a href="#">Delete</a></li>
            <li><a href="#">Update</a></li>
        </ul>

    </div>
        <?= Html::a('Create New', ['create'], ['class' => 'btn btn-success']) ?>
    <?php if($parentCategory): ?>
        <?= Html::a('Go back one level', ['/category','parent'=>$parentCategory->parent], ['class' => 'btn btn-default']) ?>
    <?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => \yii\grid\CheckboxColumn::className()],
            'name',
            [
                'header'=>'Subcategory',
                'class' => yii\grid\Column::className(),
                'content'=>function ($model, $key, $index, $column){
                    $count= \common\components\CategoryTree::getInstance()->getSubCategoriesCount($model->mid);
                    if($count==0){
                        return Html::a('Add',['/category/create','parent'=>$model->mid]);
                    }else{
                        return Html::a($count.'Categories',['/category','parent'=>$model->mid]);
                    }
                }
            ],
            'slug',

            'count',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{update} {delete}',
            ],
        ],
        'tableOptions'=>['class' => 'table table-striped']
    ]); ?>

</div>
