<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode(\common\helpers\SiteHelper::getBackendTitle($this->title)) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' =>Yii::$app->name,
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);

        $leftMenuItems=[];
        $rightMenuItems=[];
            if (!Yii::$app->user->isGuest) {

                $leftMenuItems=[
                    ['label'=>'Control Panel','items'=>[
                        ['label' => 'Overview', 'url' => ['/site/index']],
                        ['label' => 'Profile', 'url' => ['/site/profile']],
                    ]],
                    ['label'=>'Write','items'=>[
                        ['label' => 'Write Article', 'url' => ['/post/create']],
                        ['label' => 'Create Page', 'url' => ['/page/create']],
                    ]],
                    ['label'=>'Manage','items'=>[
                        ['label' => 'Posts', 'url' => ['/post']],
                        ['label' => 'Pages', 'url' => ['/page']],
                        ['label' => 'Comments', 'url' => ['/comment']],
                        ['label' => 'Categories', 'url' => ['/category']],
                        ['label' => 'Tags', 'url' => ['/tag']],
                        ['label' => 'Media', 'url' => ['/media']],
                        ['label' => 'Users', 'url' => ['/user']],
                    ]],
                    ['label'=>'Settings','items'=>[
                        ['label' => 'Basic', 'url' => ['/option/index']],
                    ]],
                ];


                $rightMenuItems = [
                    [
                        'label' => 'Logout(' . Yii::$app->user->identity->name . ')',
                        'url' => ['/site/logout'],
                        'linkOptions' => ['data-method' => 'post']
                    ],
                    ['label' => 'website', 'url' => Yii::$app->frontendUrlManager->getHostInfo(),'linkOptions'=>['target'=>'_blank']],
                ];
            }
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => $leftMenuItems,
        ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $rightMenuItems,
            ]);
            NavBar::end();
        ?>

        <div class="container">

            <div class="page-header">
                <h2><?=Html::encode($this->title)?></h2>
            </div>

        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; <?=Yii::$app->name;?> <?= date('Y') ?></p>
        <p class="pull-right"></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
