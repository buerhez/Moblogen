<!-- start widget -->
<div class="widget">
    <h4 class="title">Download MoBlog</h4>
    <div class="content download">
        <a href="https://coding.net/u/mojifan/p/MoBlog/git" target="_blank" class="btn btn-default btn-block">Go to Coding</a>
        <a href="https://github.com/mojifan/MoBlog" target="_blank" class="btn btn-default btn-block">Go to Github</a>
    </div>
</div>
<!-- end widget -->
<div class="widget">
    <h4 class="title">Categories</h4>
    <div class="content category">
        <?=\common\widgets\CategoryList::widget()?>
    </div>
</div>
<!-- start tag cloud widget -->
<div class="widget">
    <h4 class="title">Tag Cloud</h4>
    <div class="content tag-cloud">
        <?=\frontend\widgets\TagCloud::widget() ?>
    </div>
</div>