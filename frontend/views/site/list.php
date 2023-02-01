<?php
use yii\helpers\Html;
use common\helpers\DateTimeHelper;
/* @var $this yii\web\View */
/* @var $pagination yii\data\Pagination */
$this->title = '';
?>
<?php if(isset($category)):?>
    <?php $this->title='Category'.$category->name.'Articles below' ?>
<div class="cover tag-cover">
    <h3 class="tag-name">
        Categories：<?=$category->name ?>
    </h3>
    <div class="post-count">
        Total <?=$pagination->totalCount ?> Article
    </div>
</div>
<?php endif; ?>

<?php if(isset($tag)):?>
    <?php $this->title='Tag'.$tag->name.'Articles under this label' ?>
    <div class="cover tag-cover">
        <h3 class="tag-name">
            Tags：<?=$tag->name ?>
        </h3>
        <div class="post-count">
            Total of <?=$pagination->totalCount ?> articles under this label
        </div>
    </div>
<?php endif; ?>

<?php if(isset($author)):?>
    <?php $this->title=$author->screenName.'Articles published' ?>
    <div class="cover tag-cover">
        <h3 class="tag-name">
            Author：<?=$author->screenName ?>
        </h3>
        <div class="post-count">
            Total <?=$pagination->totalCount ?> Articles
        </div>
    </div>
<?php endif; ?>

<?php foreach($posts as $post): ?>
<article class="post">

    <div class="post-head">
        <h1 class="post-title"><?=Html::a($post->title,['post','id'=>$post->cid])?></h1>
        <div class="post-meta">
            <span class="author"><i class="fa fa-user"></i> <?=Html::a($post->author==null?'':$post->author->screenName,['site/author','name'=>$post->author->name])?></span> &bull;
            <span><i class="fa fa-clock-o"></i> <time class="date" datetime="<?=Yii::$app->formatter->asDate($post->created)?>"><?=Yii::$app->formatter->asDate($post->created)?></time></span> &bull;
            <span>
            <i class="fa fa-folder-open-o"></i>
            <?php
            $postCategories=$post->categories;
            foreach($postCategories as $v):
                ?>
                <?=Html::a($v->name,['site/category','slug'=>$v->slug])?>
            <?php endforeach; ?>
            </span>
        </div>
    </div>
    <div class="post-content">
        <?=\yii\helpers\Markdown::process($post->text)?>
    </div>
    <div class="post-permalink">
        <?=Html::a('Read the original post',['post','id'=>$post->cid],['class'=>'btn btn-default'])?>
    </div>

    <footer class="post-footer clearfix">
    <div class="pull-left tag-list">
        <i class="fa fa-tag"></i>
        <?php
        $postTags=$post->tags;
        foreach($postTags as $v):
            ?>
            <?=Html::a($v->name,['site/tag','slug'=>$v->slug])?>
        <?php endforeach; ?>
    </div>
</footer>
