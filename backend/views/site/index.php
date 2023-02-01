<?php
/* @var $this yii\web\View */
/* @var $post common\models\Content */

$this->title = 'Website Overview';
?>
<div class="row">
    <div class="col-lg-12">

            <div class="panel panel-default">
        <div class="panel-body">
            <p class="lead">Currently, there are <em><?=$postCount?></em> articles and <em>0</em> comments about you in <em><?=$categoryCount?></em> categories.</p>
            <p class="lead">Click on the links below to start quickly:</p>
            <div>

                <?=\yii\helpers\Html::a('Write New Article',['/post/create'],['class'=>'btn btn-primary'])?>
                <?=\yii\helpers\Html::a('System Settings',['/option'],['class'=>'btn btn-primary'])?>
            </div>
        </div>
    </div>
</div>

</div>
<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Recently Published Articles</h3>
            </div>
            <div class="panel-body">
                <ul class="list-unstyled">
                    <?php foreach($recentPublishedPost as $post): ?>
                    <li>
                        <span class="pull-right"><?=Yii::$app->formatter->asDate($post->created,'MM.dd') ?></span>
                        <?=\yii\helpers\Html::a($post->title,Yii::$app->frontendUrlManager->createUrl(['site/post','id'=>$post->cid]),['target'=>'_blank'])?>
                    </li>
                    <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<div class="col-lg-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Recently Received Replies</h3>
        </div>
        <div class="panel-body">
            <ul class="list-unstyled">
                <li>todo</li>

            </ul>
        </div>
    </div>
  </div>
</div>