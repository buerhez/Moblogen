<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use common\models\Content;
use backend\widgets\TinyMCE;
use backend\widgets\BootstrapDatetimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Content */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-9">


        <?= $form->field($model, 'title') ?>


        <?=\backend\widgets\BootstrapMarkdown::widget([
            'model'=>$model,
            'attribute'=>'text',
            'options'=>['style'=>'height:400px;']
        ])?>

        <div class="form-group">
            <?= Html::submitButton('publishing page', ['class' => 'btn btn-primary']) ?>
        </div>


    </div><!-- post -->

    <div class="col-md-3">
        <?=\yii\bootstrap\Tabs::widget([
            'renderTabContent'=>false,
            'items'=>[
                [
                    'label' => 'Option',
                    'options' => ['id' => 'options'],
                ],
                [
                    'label' => 'Attachment',
                    'options' => ['id' => 'files'],
                ],
            ],
        ]) ?>
        <div class="tab-content">
            <div id="options" class="tab-pane active">

                <?= $form->field($model, 'slug') ?>
                <?=BootstrapDatetimePicker::widget([
                    'model'=>$model,
                    'attribute'=>'created'
                ])?>
                <?= $form->field($model, 'order') ?>

                <?= $form->field($model, 'status')->dropDownList([
                    Content::STATUS_PUBLISH=>'Public',
                    Content::STATUS_HIDDEN=>'Hide',
                ],['id'=>'visibility']) ?>

                <?= $form->field($model, 'allowComment')->checkbox() ?>
                <?= $form->field($model, 'allowPing')->checkbox() ?>
                <?= $form->field($model, 'allowFeed')->checkbox() ?>


            </div>
            <div id="files" class="tab-pane">
                <?=\backend\widgets\Plupload::widget([
                    'attachments'=>$model->isNewRecord?[]:$model->attachments,
                    'fileInputName'=>'file',
                    'filesInputHiddenName'=>'inputAttachments[]',
                    'serverUrl'=>Yii::$app->urlManager->createUrl('site/upload')
                ])?>
            </div>
        </div>


    </div>
    <?php ActiveForm::end(); ?>

</div>
