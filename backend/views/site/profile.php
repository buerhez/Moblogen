<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */

$this->title='Personal settings';
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'screenName')->textInput(['maxlength' => 32]) ?>
    <?= $form->field($model, 'url')->textInput(['maxlength' => 200]) ?>
    <?= $form->field($model, 'mail')->textInput(['maxlength' => 200]) ?>
    <?= $form->field($model, 'password')->passwordInput(['minlength'=>6,'maxlength' => 20,'value'=>'']) ?>


    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
